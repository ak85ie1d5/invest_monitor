<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
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
    public function __construct(private HttpClientInterface $client)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //$io = new SymfonyStyle($input, $output);
        //$io->success('You have a new command! Now make it your own! Pass --help to see your options.');


        $response = $this->client->request(
            'GET',
            'https://www.boursedirect.fr/fr/actualites/categorie/turbos'
        );

        if ($response->getStatusCode() !== 200) {
            $output->writeln($response->getContent(false));

            return Command::FAILURE;
        }

        return Command::SUCCESS;

    }
}
