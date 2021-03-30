<?php

namespace App\Infrastructure\Command;

use App\Application\Handler\Team\CreateTeamHandler;
use App\Infrastructure\Service\FetchGamesInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class FetchGamesCommand.
 */
class FetchGamesCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:fetch-games';

    private FetchGamesInterface $fetchGames;
    private CreateTeamHandler $createGameHandler;

    /**
     * FetchLeaguesCommand constructor.
     * @param CreateTeamHandler $createGameHandler
     * @param FetchGamesInterface $fetchGames
     */
    public function __construct(CreateTeamHandler $createGameHandler, FetchGamesInterface $fetchGames)
    {
        $this->createGameHandler = $createGameHandler;
        $this->fetchGames = $fetchGames;
        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $games = $this->fetchGames->handle([
            'days' => $input->getArgument('days')
        ]);

        foreach ($games as $game) {
            try {
                $this->createGameHandler->handle($game);
                $output->writeln($game['homeTown'].'-'.$game['awayTeam']." games are saved.");
            }catch (\Exception $e) {
                $output->writeln($e->getMessage());
            }
        }

        $output->writeln('Games are created');

        return Command::SUCCESS;
    }

    protected function configure()
    {
        parent::configure();

        $this->addArgument('days', InputArgument::REQUIRED);
    }
}
