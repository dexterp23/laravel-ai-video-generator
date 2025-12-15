<?php

namespace App\Services;

use App\Models\TopicsStory as TopicsStoryModel;
use App\Repositories\TopicsStoryRepository;
use App\Services\Traits\VideoClientTrait;
use App\Services\Traits\VideoTypeTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class GetGeneratedVideoService
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
        $video = $this->aiService->video(self::VIDEO_RETREIVE, $data, $story->video_ai_client);
        if ($video['status'] == 'completed') {
            $this->downloadVideo($data, $story);
            $this->topicsStoryRepository->update($story->id, ['video_status' => TopicsStoryModel::VIDEO_STATUS_GENERATED]);
        }
    }

    protected function downloadVideo(array $data, TopicsStoryModel $story): void
    {
        $video = $this->aiService->video(self::VIDEO_DOWNLOAD, $data, $story->video_ai_client);
        $filename = $data['video_id'] . ".mp4";
        Storage::disk('local')->put("videos/$filename", $video);
    }
}
