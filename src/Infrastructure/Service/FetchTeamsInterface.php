<?php

namespace App\Infrastructure\Service;

/**
 * Interface FetchTeamsInterface.
 */
interface FetchTeamsInterface
{
    /**
     * @return mixed
     */
    public function fetch(array $input);
}
