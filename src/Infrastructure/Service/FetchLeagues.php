<?php

namespace App\Infrastructure\Service;

use Symfony\Component\String\Slugger\AsciiSlugger;

class FetchLeagues implements FetchLeaguesInterface
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
        $leagues = $this->provider->getContent($input);

        $leagueArr = [];

        foreach ($leagues['api']['leagues'] as $league) {
            if (!in_array(strtolower((new AsciiSlugger())->slug($league['name'])->toString()), [
                'premier-league',
                'serie-a',
                'primera-division',
                'super-lig',
                'uefa-europa-league',
                'uefa-champions-league',
                'bundesliga-1',
                'ligue-1',
            ])) {
                continue;
            }

            if (!in_array($league['country'], [
                'England',
                'Italy',
                'France',
                'Portugal',
                'Spain',
                'Turkey',
                'World',
                'Germany',
            ])) {
                continue;
            }

            $leagueArr[] = [
              'leagueApiLd' => $league['league_id'],
              'name' => $league['name'],
              'logo' => $league['logo'],
              'leagueNameSlugged' => strtolower((new AsciiSlugger())->slug($league['name'])->toString()),
            ];
        }

        return $leagueArr;
    }
}
