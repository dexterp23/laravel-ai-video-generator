<?php

namespace App\Services;

interface AiServiceInterface
{
    public function video(string $type, array $data, string $client = 'openai'): mixed;

    public function chat(array $data, string $client = 'openai'): mixed;
}
