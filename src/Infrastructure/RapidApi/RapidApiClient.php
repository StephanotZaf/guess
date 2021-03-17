<?php

namespace App\Infrastructure\RapidApi;

use App\Infrastructure\Service\ProviderInterface;
use GuzzleHttp\Client;
use Monolog\Utils;

class RapidApiClient implements ProviderInterface
{
    const API_FOOTBALL_URI_LEAGUES = '';
    const API_FOOTBALL_URI_TEAMS = '';
    const API_FOOTBALL_URI_GAMES = '';

    private Client $client;

    /**
     * RapidApiClient constructor.
     */
    public function __construct()
    {
        $this->client = new Client(
            [
                'headers' => ['X-RapidApi-Key' => 'your key'],
            ]
        );
    }

    /**
     * @return mixed
     */
    public function getContent(array $criteria)
    {
        $response = '';

        if (!$criteria) {
            $response = $this->client->request(
              'GET', self::API_FOOTBALL_URI_LEAGUES
            );
        }

        if (isset($criteria['days'])) {
            $response = $this->client->request(
                'GET', self::API_FOOTBALL_URI_GAMES,
                (new \DateTimeImmutable($criteria['days'].'day'))->format('Y-m-d')
            );
        }

        return Utils::jsonDecode(
          $response->getBody()->getContents(), true
        );
    }
}
