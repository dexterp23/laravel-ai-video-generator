<?php

namespace App\Services\Clients;

use OpenAI;
use OpenAI\Client;

class OpenAIClient implements AIClientInterface
{
    protected Client $client;

    public function __construct()
    {
        $this->setClient();
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function setClient(): void
    {
        $this->client = OpenAI::client(env('OPENAI_API_KEY'));
    }
}
