<?php

namespace App\Services;

use App\Services\Clients\RetryingVideoClient;
use App\Services\Clients\RetryingChatClient;
use App\Services\Traits\VideoClientTrait;

class AiService
{
    use VideoClientTrait;

    public function video(string $type, array $data, string $client = 'openai'): mixed
    {
        $chatClient = new RetryingVideoClient(
            app(AiServiceFactory::class)->makeVideo($client)
        );
        return $chatClient->run($type, $data);
    }

    public function chat(array $data, string $client = 'openai'): mixed
    {
        $chatClient = new RetryingChatClient(
            app(AiServiceFactory::class)->makeChat($client)
        );
        return $chatClient->run($data);
    }
}
