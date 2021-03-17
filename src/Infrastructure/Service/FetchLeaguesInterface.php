<?php

namespace App\Infrastructure\Service;

/**
 * Interface FetchLeaguesInterface.
 */
interface FetchLeaguesInterface
{
    /**
     * @return mixed
     */
    public function fetch(array $input);
}
