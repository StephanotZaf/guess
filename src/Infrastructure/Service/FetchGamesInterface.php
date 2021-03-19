<?php

namespace App\Infrastructure\Service;

/**
 * Interface FetchGamesInterface.
 */
interface FetchGamesInterface
{
    /**
     * @return mixed
     */
    public function fetch(array $input);
}
