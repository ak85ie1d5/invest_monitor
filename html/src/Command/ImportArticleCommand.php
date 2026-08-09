<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:import-article',
    description: 'Add a short description for your command',
)]
class ImportArticleCommand extends Command
{
    private const URL = 'https://www.boursedirect.fr/fr/actualites/categorie/turbos';

    public function __construct(private HttpClientInterface $client)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //$io = new SymfonyStyle($input, $output);
        //$io->success('You have a new command! Now make it your own! Pass --help to see your options.');


        $response = $this->client->request(
            'GET',
            self::URL,
            [
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    'Accept-Language' => 'fr-FR,fr;q=0.9',
                ],
            ]
        );

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

        foreach ($articles as $article) {
            $output->writeln(sprintf('[%s %s] %s', $article['date'], $article['hour'], $article['title']));
            $output->writeln('  '.$article['url']);
        }

        $output->writeln(sprintf('<info>%d articles trouvés.</info>', \count($articles)));

        return Command::SUCCESS;

    }
}
