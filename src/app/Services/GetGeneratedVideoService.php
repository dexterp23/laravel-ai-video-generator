<?php

namespace App\Services;

use App\Models\TopicsStory as TopicsStoryModel;
use App\Repositories\TopicsStoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class GetGeneratedVideoService implements GetGeneratedVideoServiceInterface
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
            $stories = $this->topicsStoryRepository->getAllForGetGeneratedVideo(self::PER_PAGE);
            foreach ($stories as $story) {
                $this->processVideo($story);
            }
        } catch (\Exception $e) {
            $this->logger::error($e->getMessage());
        }
    }

    protected function processVideo($story): void
    {
        $data = [
            'video_id' => $story->video_id
        ];
        $video = $this->aiService->video(config("ai.video_action_type.retrieve"), $data, $story->video_ai_client);
        if ($video['status'] == 'completed') {
            $this->downloadVideo($data, $story);
            $this->topicsStoryRepository->update($story->id, ['video_status' => config("ai.video_status.generated")]);
        }
    }

    protected function downloadVideo(array $data, TopicsStoryModel $story): void
    {
        $video = $this->aiService->video(config("ai.video_action_type.download"), $data, $story->video_ai_client);
        $filename = $data['video_id'] . ".mp4";
        Storage::disk('local')->put("videos/$filename", $video);
    }
}
