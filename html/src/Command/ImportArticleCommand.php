<?php

namespace App\Command;

use App\Entity\ArticleArchive;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:import-article',
    description: 'This commande is use to crawl Bourse Direct blog and save articles into database.',
)]
class ImportArticleCommand extends Command
{
    private const string URL = 'https://www.boursedirect.fr/fr/actualites/categorie/turbos';

    public function __construct(
        private readonly HttpClientInterface $boursedirectClient,
        private readonly EntityManagerInterface $entityManager
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $response = $this->boursedirectClient->request('GET', self::URL);

        if ($response->getStatusCode() !== 200) {
            $output->writeln($response->getContent(false));

            return Command::FAILURE;
        }

        $crawler = new Crawler($response->getContent(), self::URL);

        $articles = $crawler->filter('div.timeline-item')->each(function (Crawler $node): array {
            $link = $node->filter('div.timeline-body a');
            $date = $node->filter('div.timeline-date');

            return [
                'title' => trim($node->filter('h2.timeline-title')->text('')),
                'url' => $link->count() ? $link->link()->getUri() : null,
                'hour' => trim($node->filter('div.timeline-date-left')->text('')),
                'date' => trim(implode(' ', [
                    trim($date->filter('span.publishDay')->text('')),
                    trim($date->filter('strong')->text('')),
                    trim($date->filter('span.text-muted')->text('')),
                ])),
            ];
        });

        $existingLinks = array_flip(
            $this->entityManager->getRepository(ArticleArchive::class)
                ->findExistingLinks(array_column($articles, 'url'))
        );

        $imported = 0;

        foreach ($articles as $article) {
            if (isset($existingLinks[$article['url']])) {
                continue;
            }

            $this->archiveArticle($article['title'], $this->parsePublicationDate($article['date'], $article['hour']) ,$article['url']);
            ++$imported;
        }

        $this->entityManager->flush();

        $output->writeln(sprintf('<info>%d nouveaux articles sur %d trouvés.</info>', $imported, \count($articles)));

        return Command::SUCCESS;

    }

    /**
     * Persist object into archiveArticle table
     * @param $title
     * @param $datetime
     * @param $link
     * @return void
     */
    private function archiveArticle($title, $datetime, $link): void
    {
        $articleArchive = new articleArchive();
        $articleArchive->setTitle($title);
        $articleArchive->setPublicationDate($datetime);
        $articleArchive->setLink($link);

        $this->entityManager->persist($articleArchive);
    }

    /**
     * Format datetime for doctrine.
     *
     * @param string $date
     * @param string $hour
     * @return \DateTime
     * @throws \DateMalformedStringException
     */
    private function parsePublicationDate(string $date, string $hour): \DateTime
    {
        $formatter = new \IntlDateFormatter(
            'fr_FR',
            \IntlDateFormatter::NONE,
            \IntlDateFormatter::NONE,
            'Europe/Paris',
            \IntlDateFormatter::GREGORIAN,
            'dd EEEE MMMM yyyy HH:mm',
        );

        $timestamp = $formatter->parse($date.' '.$hour);

        if (false === $timestamp) {
            throw new \RuntimeException(sprintf('Date illisible : "%s %s"', $date, $hour));
        }

        return new \DateTime('@'.$timestamp)->setTimezone(new \DateTimeZone('Europe/Paris'));
    }
}
