<?php


namespace App\Application\Handler\Team;


use App\Application\Service\FileUploaderInterface;
use App\Domain\Team\Team;
use App\Domain\Team\TeamRepositoryInterface;

class GameOverHandler
{
    private GameRepositoryInterface $gameRepository;
    private TeamRepositoryInterface $teamRepository;

    /**
     * CreateTeamHandler constructor.
     * @param TeamRepositoryInterface $teamRepository
     * @param FileUploaderInterface $logoUploader
     */
    public function __construct(GameRepositoryInterface $gameRepository, TeamRepositoryInterface $teamRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->teamRepository = $teamRepository;
    }

    /**
     * @param array $gameFromApi
     * @throws \Exception
     */
    public function handle(array $gameFromApi): void
    {
        if (!isset($gameFromApi['score'])) {
            throw new \Exception('Need score to finish the game');
        }

        $homeTeam = $this->teamRepository->findOneBy(['name' => $gameFromApi['homeTeam']]);
        $awayTeam = $this->teamRepository->findOneBy(['name' => $gameFromApi['awayTeam']]);

        if (!$homeTeam) {
            throw new \Exception($gameFromApi['homeTeam']. ' is not the part of our database');
        }
        if (!$awayTeam) {
            throw new \Exception($gameFromApi['awayTeam']. ' is not the part of our database');
        }

        $game = $this->gameRepository->findOneBy(
          [
              'homeTeam' => $homeTeam,
              'awayTeam' => $awayTeam,
              'gameTime' => new \DateTimeImmutable($gameFromApi['gameTIme']),
          ]
        );

        if(!$game) {
            // todo -
            throw new \Exception('Game between '. $homeTeam->getName() . ' - '. $awayTeam->getName(). ' is ');
        }

        $game->complete($gameFromApi['score']);

        $this->gameRepository->save($game);
    }
}