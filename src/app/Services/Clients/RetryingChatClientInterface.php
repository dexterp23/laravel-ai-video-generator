<?php

namespace App\Services\Clients;

interface RetryingChatClientInterface
{
    public function run(array $data): mixed;
}
