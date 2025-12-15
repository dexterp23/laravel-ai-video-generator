<?php

return [
    'video_clients' => [
        'openai' => App\Services\Clients\OpenAIVideoClient::class,
        'veo' => App\Services\Clients\VeoAIVideoClient::class,
    ],
    'default_language' => 'en',
    'viral_topic_json_format' => [],
    'story_json_format' => [],
    'prompt_viral' => "",
    'prompt_story' => "",
    'json_system' => "",
    'prompt_video' => ""
];
