<?php

namespace App\Infrastructure\Command;

use App\Application\League\CreateLeagueHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchLeaguesCommand extends Command
{
    protected static $defaultName = 'app:fetch-leagues';

    /**
     * @var CreateLeagueHandler
     */
    private $createLeagueHandler;
    /**
     * @var string|null
     */
    private $name;
    /**
     * @var FetchLeaguesInterface
     */
    private FetchLeaguesInterface $fetcherService;

    public function __construct(FetchLeaguesInterface $fetcherService, CreateLeagueHandler $createLeagueHandler, string $name = null)
    {

        $this->createLeagueHandler = $createLeagueHandler;
        $this->name = $name;

        $this->fetcherService = $fetcherService;
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
       $leagues = $this->fetcherService->fetch([]);

       foreach ($leagues as $league) {
            try {
                $this->createLeagueHandler->handle($league);
                $output->writeln($league['name']." saved");
            } catch (\Exception $e) {
                $output->writeln($e->getMessage());
            }
       }

        $output->writeln('Leagues are created');

        return Command::SUCCESS;
    }
}