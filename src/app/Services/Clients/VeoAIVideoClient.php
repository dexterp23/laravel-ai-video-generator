<?php

namespace App\Services\Clients;

use App\Services\Traits\VideoTypeTrait;
use GuzzleHttp\Client;

class VeoAIVideoClient implements AIVideoClientInterface
{
    use VideoTypeTrait;

    protected Client $client;
    protected string $model;

    public function __construct(string $model = 'veo-2.0-generate-001')
    {
        //
    }

    public function video(string $type, array $data): mixed
    {

        return false;
    }

    protected function generate(array $data): mixed
    {

        return false;
    }
}
