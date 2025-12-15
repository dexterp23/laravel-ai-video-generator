<?php

namespace App\Services\Clients;

use OpenAI\Client;

interface AIClientInterface
{
    public function getClient(): Client;
    public function setClient(): void;
}
