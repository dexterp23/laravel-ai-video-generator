<?php

namespace App\Services;

use App\Models\TopicsStory as TopicsStoryModel;
use App\Repositories\TopicsStoryRepository;
use App\Services\Traits\VideoClientTrait;
use App\Services\Traits\VideoTypeTrait;
use Illuminate\Support\Facades\Storage;

class SentStoryToGenerateVideoService
{
    use VideoTypeTrait, VideoClientTrait;

    protected const PER_PAGE = 1;
    protected TopicsStoryRepository $topicsStoryRepository;
    protected Logger $logger;
    protected AiService $aiService;

    public function __construct(
        TopicsStoryRepository $topicsStoryRepository
    )
    {
        $this->topicsStoryRepository = $topicsStoryRepository;
        $this->logger = new Logger();
        $this->aiService = new AiService();
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
        $video = $this->aiService->video(self::VIDEO_GENERATE, $data, self::VIDEO_CLIENT_OPENAI);
        if (empty($video['id'])) {
            throw new \Exception("No Video ID: $story->id");
        }
        $this->topicsStoryRepository->update($story->id, [
            'video_id' => $video['id'],
            'video_ai_client' => self::VIDEO_CLIENT_OPENAI,
            'video_status' => TopicsStoryModel::VIDEO_STATUS_SENT_FOR_GENERATION
        ]);
    }
}
