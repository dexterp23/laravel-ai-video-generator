<?php

namespace App\Services;

use App\Services\Clients\RetryingVideoClient;
use App\Services\Clients\RetryingChatClient;
use App\Services\Clients\OpenAIChatClient;
use App\Services\Traits\VideoClientTrait;

class AiService
{
    use VideoClientTrait;

    public function video(string $type, array $data, string $client): mixed
    {
        $chatClient = new RetryingVideoClient(
            app(AiServiceFactory::class)->makeVideo($client)
        );
        return $chatClient->run($type, $data);
    }

    public function chat(array $data): mixed
    {
        $chatClient = new RetryingChatClient(
            new OpenAIChatClient()
        );
        return $chatClient->run($data);
    }
}
