<?php

namespace App\Services;

use App\Services\Clients\RetryingVideoClient;
use App\Services\Clients\RetryingChatClient;

class AiService implements AiServiceInterface
{
    protected AiServiceFactory $aiServiceFactory;

    public function __construct(
        AiServiceFactory $aiServiceFactory
    )
    {
        $this->aiServiceFactory = $aiServiceFactory;
    }

    public function video(string $type, array $data, string $client = 'openai'): mixed
    {
        $chatClient = new RetryingVideoClient(
            $this->aiServiceFactory->makeVideo($client)
        );
        return $chatClient->run($type, $data);
    }

    public function chat(array $data, string $client = 'openai'): mixed
    {
        $chatClient = new RetryingChatClient(
            $this->aiServiceFactory->makeChat($client)
        );
        return $chatClient->run($data);
    }
}
