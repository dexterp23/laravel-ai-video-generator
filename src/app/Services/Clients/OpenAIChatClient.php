<?php

namespace App\Services\Clients;

use OpenAI\Client;

class OpenAIChatClient implements AIChatClientInterface
{
    private Client $client;
    private string $model;

    public function __construct(string $model = 'o3-mini')
    {
        $this->client = (new OpenAIClient())->getClient();
        $this->model = $model;
    }

    public function chat(array $data): mixed
    {
        $response = $this->client->responses()->create([
            'model' => $this->model,
            'instructions' => $data['instructions'],
            'input' => $data['input'],
        ]);
        return $response['output_text'];
    }
}
