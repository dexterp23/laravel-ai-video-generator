<?php

namespace App\Services;

use App\Repositories\TopicsRepository;
use App\Repositories\TopicsViralRepository;

class ViralCreatorService
{
    protected const PER_PAGE = 1;
    protected const CRON_LOCK_TABLE = 'topics';
    protected const PER_TOPIC = 1;
    protected TopicsRepository $topicsRepository;
    protected TopicsViralRepository $topicsViralRepository;
    protected AiService $aiService;
    protected Logger $logger;

    public function __construct(
        TopicsRepository $topicsRepository,
        TopicsViralRepository $topicsViralRepository,
    )
    {
        $this->topicsRepository = $topicsRepository;
        $this->topicsViralRepository = $topicsViralRepository;
        $this->aiService = new AiService();
        $this->logger = new Logger();
    }

    public function run(): void
    {
        try {
            $topics = $this->topicsRepository->getAllActiveForCron(self::PER_PAGE);
            if ($topics->isEmpty()) {
                app('CronLock')->handleEmpty(self::CRON_LOCK_TABLE, $this->topicsRepository);
                return;
            }

            foreach ($topics as $topic) {
                $this->processTopic($topic);
            }
        } catch (\Exception $e) {
            $this->logger::error($e->getMessage());
        }
    }

    protected function processTopic($topic): void
    {
        $prompt = messageFormatter(
            config('ai.prompt_viral'),
            [
                '{per_topc}' => self::PER_TOPIC,
                '{description}' => $topic->description,
            ]
        );
        $jsonText = $this->aiService->chat(
            createOpenAiJsonPrompt($prompt, 'ai.viral_topic_json_format')
        );
        $data = validateJson($jsonText);

        $array = $data['videoIdeas'];
        if (self::PER_TOPIC == 1) {
            unset($array);
            $array[] = $data['videoIdeas'];
        }

        foreach ($array as $value) {
            $value['topic_id'] = $topic->id;
            $this->processViral($value);
        }

        $this->topicsRepository->update($topic->id, ['cron_lock' => true]);
    }

    protected function processViral(array $value): void
    {
        $attributes = [
            'topic_id'    => $value['topic_id'],
            'title'       => $value['title'],
            'description' => $value['description'],
        ];
        $this->topicsViralRepository->addByTile($value['title'], $attributes);
    }
}
