<?php

namespace App\Services\Clients;

interface AIChatClientInterface
{
    public function chat(array $data): mixed;
}
