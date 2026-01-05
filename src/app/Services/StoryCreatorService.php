<?php

namespace App\Services;

use App\Repositories\TopicsViralRepository;
use App\Repositories\TopicsStoryRepository;
use App\Support\CronLockInterface;

class StoryCreatorService implements StoryCreatorServiceInterface
{
    protected const PER_PAGE = 1;
    protected const TOTAL_VIDEO_CREATION = 1;
    protected const CRON_LOCK_TABLE = 'topics_viral';
    protected TopicsViralRepository $topicsViralRepository;
    protected TopicsStoryRepository $topicsStoryRepository;
    protected AiServiceInterface $aiService;
    protected Logger $logger;
    protected CronLockInterface $cronLock;

    public function __construct(
        TopicsViralRepository $topicsViralRepository,
        TopicsStoryRepository $topicsStoryRepository,
        CronLockInterface $cronLock,
        AiServiceInterface $aiService,
        Logger $logger
    )
    {
        $this->topicsViralRepository = $topicsViralRepository;
        $this->topicsStoryRepository = $topicsStoryRepository;
        $this->cronLock = $cronLock;
        $this->aiService = $aiService;
        $this->logger = $logger;
    }

    public function run(): void
    {
        try {
            $virals = $this->topicsViralRepository->getAllActiveForCron(self::PER_PAGE);
            if ($virals->isEmpty()) {
                $this->cronLock->handleEmpty(self::CRON_LOCK_TABLE, $this->topicsViralRepository);
                return;
            }

            foreach ($virals as $viral) {
                $this->processViral($viral);
            }
        } catch (\Exception $e) {
            $this->logger::error($e->getMessage());
        }
    }

    protected function processViral($viral): void
    {
        if ($viral->stories->count() == self::TOTAL_VIDEO_CREATION) {
            $this->topicsViralRepository->update($viral->id, ['is_active' => false]);
            return;
        }

        $prompt = messageFormatter(
            config('ai.prompt_story'),
            [
                '{total_video}' => self::TOTAL_VIDEO_CREATION,
                '{topic}' => $viral->title,
                '{description}' => $viral->description,
            ]
        );

        $jsonText = $this->aiService->chat(
            createOpenAiJsonPrompt($prompt, 'ai.story_json_format')
        );
        $data = validateJson($jsonText);

        $array = $data['videoScripts'];
        if (self::TOTAL_VIDEO_CREATION == 1) {
            unset($array);
            $array[] = $data['videoScripts'];
        }

        $storyVideoStatus = config("ai.video_status.no_generation");
        if ($viral->topic->create_video == true) $storyVideoStatus = config("ai.video_status.for_generation");

        foreach ($array as $value) {
            $value['viral_id'] = $viral->id;
            $value['video_status'] = $storyVideoStatus;
            $this->processStory($value);
        }

        $this->topicsViralRepository->update($viral->id, ['cron_lock' => true]);
    }

    protected function processStory(array $value): void
    {
        $storyTitle = $value['title'];
        $storyDescription = $value['description'];
        $storyHashtags = $value['hashtags'];
        $storyScript = $value['video'];

        $attributes = [
            'viral_id' => $value['viral_id'],
            'title' => $storyTitle,
            'description' => $storyDescription,
            'hashtags' => $storyHashtags,
            'script' => $storyScript,
            'video_status' => $value['video_status'],
        ];
        $this->topicsStoryRepository->add($attributes);
    }
}
