<?php

namespace App\Application\Handler\League;

use App\Domain\League\LeagueRepositoryInterface;

/**
 * Class ListLeagueHandler.
 */
class ListLeagueHandler
{
    private LeagueRepositoryInterface $leagueRepository;

    /**
     * CreateLeagueHandler constructor.
     * @param LeagueRepositoryInterface $leagueRepository
     */
    public function __construct(LeagueRepositoryInterface $leagueRepository)
    {
        $this->leagueRepository = $leagueRepository;
    }

    /**
     * @param array $league
     * @throws \Exception
     */
    public function handle()
    {
        return $this->leagueRepository->findAll();
    }
}
