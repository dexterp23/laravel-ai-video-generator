<?php

return [
    'video_clients_class' => [
        'openai' => App\Services\Clients\OpenAIVideoClient::class,
        'veo' => App\Services\Clients\VeoAIVideoClient::class,
    ],
    'chat_clients_class' => [
        'openai' => App\Services\Clients\OpenAIChatClient::class,
    ],
    'video_clients' => [
        'openai' => 'openai',
        'veo' => 'veo',
    ],
    'video_action_type' => [
        'generate' => 'generate',
        'retrieve' => 'retrieve',
        'download' => 'download',
    ],
    'video_status' => [
        'no_generation' => '1',
        'for_generation' => '10',
        'sent_for_generation' => '20',
        'generated' => '30',
    ],
    'video_status_text' => [
        '1' => 'No Generation',
        '10' => 'For Generation',
        '20' => 'Sent for Generation',
        '30' => 'Generated',
    ],
    'default_language' => 'en',
    'viral_topic_json_format' => [],
    'story_json_format' => [],
    'prompt_viral' => "",
    'prompt_story' => "",
    'json_system' => "",
    'prompt_video' => ""
];
