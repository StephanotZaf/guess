<?php

namespace App\Infrastructure\Command;

use App\Application\Handler\League\CreateLeagueHandler;
use App\Infrastructure\Service\FetchLeaguesInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class FetchLeaguesCommand.
 */
class FetchLeaguesCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:fetch-leagues';

    private CreateLeagueHandler $createLeagueHandler;

    /**
     * @var string|null
     */
    private $name;

    private FetchLeaguesInterface $fetcherService;

    /**
     * FetchLeaguesCommand constructor.
     * @param FetchLeaguesInterface $fetcherService
     * @param CreateLeagueHandler $createLeagueHandler
     * @param string|null $name
     */
    public function __construct(FetchLeaguesInterface $fetcherService, CreateLeagueHandler $createLeagueHandler, string $name = null)
    {
        $this->createLeagueHandler = $createLeagueHandler;
        $this->name = $name;
        $this->fetcherService = $fetcherService;
        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $leagues = $this->fetcherService->fetch([]);

        foreach ($leagues as $league) {
            try {
                $this->createLeagueHandler->handle($league);
                $output->writeln($league['name'].' saved');
            } catch (\Exception $e) {
                $output->writeln($e->getMessage());
            }
        }

        $output->writeln('Leagues are created');

        return Command::SUCCESS;
    }
}
