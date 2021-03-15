<?php

namespace App\Infrastructure\Service;

interface ProviderInterface
{
    public function getContent(array $criteria);
}
