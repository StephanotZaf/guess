<?php

namespace App\Infrastructure\Service;

use Symfony\Component\String\Slugger\AsciiSlugger;

class FetchTeams implements FetchTeamsInterface
{
    private ProviderInterface $provider;

    /**
     * FetchLeagues constructor.
     * @param ProviderInterface $provider
     */
    public function __construct(ProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @return mixed
     */
    public function fetch(array $input = [])
    {
        $teams = $this->provider->getContent($input);

        $teamsArr = [];

        foreach ($teamsArr['api']['teams'] as $team) {
            $leagueArr[] = [
              'name' => $team['name'],
              'logo' => $team['logo'],
            ];
        }

        return $teamsArr;
    }
}
