<?php

namespace App\Services;

use App\Services\Clients\RetryingVideoClient;
use App\Services\Clients\RetryingChatClient;
use App\Services\Clients\OpenAIChatClient;
use App\Services\Clients\OpenAIVideoClient;
use App\Services\Clients\VeoAIVideoClient;
use App\Services\Traits\VideoClientTrait;

class AiService
{
    use VideoClientTrait;

    public function video(string $type, array $data, string $client): mixed
    {
        switch ($client) {
            case self::VIDEO_CLIENT_OPENAI:
                $videoClient = new OpenAIVideoClient();
                break;
            case self::VIDEO_CLIENT_VEO:
                $videoClient = new VeoAIVideoClient();
                break;
        }
        $chatClient = new RetryingVideoClient(
            $videoClient
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
