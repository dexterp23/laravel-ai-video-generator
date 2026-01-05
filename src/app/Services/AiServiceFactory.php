<?php

namespace App\Services;

use App\Services\Clients\AIChatClientInterface;
use App\Services\Clients\AIVideoClientInterface;
use InvalidArgumentException;

class AiServiceFactory
{
    public function makeVideo(string $provider): AIVideoClientInterface
    {
        $class = config("ai.video_clients_class.$provider");

        if (!$class) {
            throw new InvalidArgumentException("AI client [$provider] not supported.");
        }

        return app($class);
    }

    public function makeChat(string $provider): AIChatClientInterface
    {
        $class = config("ai.chat_clients_class.$provider");

        if (!$class) {
            throw new InvalidArgumentException("AI client [$provider] not supported.");
        }

        return app($class);
    }
}
