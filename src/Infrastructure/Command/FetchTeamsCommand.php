<?php

namespace App\Infrastructure\Command;

use App\Application\Handler\League\CreateLeagueHandler;
use App\Application\Handler\League\ListLeagueHandler;
use App\Application\Handler\Team\CreateTeamHandler;
use App\Domain\League\League;
use App\Infrastructure\Service\FetchLeaguesInterface;
use App\Infrastructure\Service\FetchTeamsInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class FetchTeamsCommand.
 */
class FetchTeamsCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:fetch-teams';

    private CreateTeamHandler $createTeamHandler;
    private FetchTeamsInterface $fetcherService;
    private ListLeagueHandler $listLeagueHandler;

    /**
     * FetchLeaguesCommand constructor.
     * @param FetchLeaguesInterface $fetcherService
     * @param CreateLeagueHandler $createLeagueHandler
     * @param string|null $name
     */
    public function __construct(CreateTeamHandler $createTeamHandler, FetchTeamsInterface $fetcherService, ListLeagueHandler $listLeagueHandler)
    {
        $this->createTeamHandler = $createTeamHandler;
        $this->fetcherService = $fetcherService;
        $this->listLeagueHandler = $listLeagueHandler;
        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $leagues = $this->listLeagueHandler->handle();

        if(!$leagues) {
            $output->writeln('There is no leagues to add teams');
        }

        /** @var League $league */
        foreach ($leagues as $league) {
            if(!$league->getLeagueApiId()) {
                $output->writeln('We need to know rapid api league id');
            }

            $teams = $this->fetcherService->fetch(
                [
                    'league-api-id' => $league->getLeagueApiId()
                ]
            );

            foreach ($teams as $team) {
                try {
                    $this->createTeamHandler->handle($team);
                }catch (\Exception $e) {
                    $output->writeln($e->getMessage());
                }
            }
        }

        $output->writeln('Leagues are created');

        return Command::SUCCESS;
    }
}
