<?php

namespace App\Services\Clients;

interface RetryingVideoClientInterface
{
    public function run(string $type, array $data): mixed;
}
