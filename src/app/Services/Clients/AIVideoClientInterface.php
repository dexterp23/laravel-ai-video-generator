<?php

namespace App\Services\Clients;

interface AIVideoClientInterface
{
    public function video(string $type, array $data): mixed;
}
