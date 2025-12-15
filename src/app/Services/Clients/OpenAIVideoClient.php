<?php

namespace App\Services\Clients;

use App\Services\Traits\VideoTypeTrait;
use GuzzleHttp\Client;

class OpenAIVideoClient implements AIVideoClientInterface
{
    use VideoTypeTrait;

    protected const OPENAI_URI = 'https://api.openai.com/v1/';
    protected Client $client;
    protected string $model;

    public function __construct(string $model = 'sora-2')
    {
        $this->model = $model;
        $this->client = new Client([
            'base_uri' => self::OPENAI_URI,
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type'  => 'application/json',
            ],
        ]);
    }

    public function video(string $type, array $data): mixed
    {
        switch ($type) {
            case self::VIDEO_GENERATE:
                return $this->generate($data);
                break;
            case self::VIDEO_RETREIVE:
                return $this->retrieve($data);
                break;
            case self::VIDEO_DOWNLOAD:
                return $this->download($data);
                break;
        }
        return false;
    }

    protected function generate(array $data): mixed
    {
        $response = $this->client->post('videos', [
            'json' => [
                'model' => $this->model,
                'prompt' => $data['prompt'],
                'seconds' => $data['duration'],
                'size' => $data['size']
            ]
        ]);
        return json_decode($response->getBody(), true);
    }

    protected function retrieve(array $data): mixed
    {
        $response = $this->client->get('videos/' . $data['video_id'], []);
        return json_decode($response->getBody(), true);
    }

    protected function download(array $data): mixed
    {
        $response = $this->client->get('videos/' . $data['video_id'] . '/content', []);
        return $response->getBody()->getContents();
    }
}
