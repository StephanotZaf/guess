<?php

namespace App\Infrastructure\Command;

use App\Application\Handler\Team\GameOverHandler;
use App\Infrastructure\Service\FetchGamesInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class FetchScoresCommand.
 */
class FetchScoresCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:fetch-games';

    private FetchGamesInterface $fetchGames;
    private GameOverHandler $gameOverHandler;

    /**
     * FetchLeaguesCommand constructor.
     * @param FetchGamesInterface $fetchGames
     * @param GameOverHandler $gameOverHandler
     */
    public function __construct(FetchGamesInterface $fetchGames, GameOverHandler $gameOverHandler)
    {
        $this->fetchGames = $fetchGames;
        $this->gameOverHandler = $gameOverHandler;
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
                $this->gameOverHandler->handle($game);

                $output->writeln(
                    'Score is saved: '.
                    $game['score'].
                    ' for '.
                    $game['homwTown'].
                    " - ".
                    $game['awayTeam']
                )
                ;
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
