<?php

namespace App\Services;

use App\Repositories\TopicsStoryRepository;
use Illuminate\Support\Facades\Storage;

class SentStoryToGenerateVideoService implements SentStoryToGenerateVideoServiceInterface
{
    protected const PER_PAGE = 1;
    protected TopicsStoryRepository $topicsStoryRepository;
    protected Logger $logger;
    protected AiServiceInterface $aiService;

    public function __construct(
        TopicsStoryRepository $topicsStoryRepository,
        AiServiceInterface $aiService,
        Logger $logger
    )
    {
        $this->topicsStoryRepository = $topicsStoryRepository;
        $this->logger = new Logger();
        $this->aiService = $aiService;
    }

    public function run(): void
    {
        try {
            $stories = $this->topicsStoryRepository->getAllForGeneratingVideo(self::PER_PAGE);
            foreach ($stories as $story) {
                $this->processStory($story);
            }
        } catch (\Exception $e) {
            $this->logger::error($e->getMessage());
        }
    }

    protected function processStory($story): void
    {
        $primtData = $story->script;
        $primtData['description'] = $story->description;
        $data = createOpenAiVideoPrompt($primtData);
        $video = $this->aiService->video(config("ai.video_action_type.generate"), $data, config("ai.video_clients.openai"));
        if (empty($video['id'])) {
            throw new \Exception("No Video ID: $story->id");
        }
        $this->topicsStoryRepository->update($story->id, [
            'video_id' => $video['id'],
            'video_ai_client' => config("ai.video_clients.openai"),
            'video_status' => config("ai.video_status.sent_for_generation")
        ]);
    }
}
