<?php

namespace App\Http\Controllers;

use App\Repositories\TopicsStoryRepository;
use App\Jobs\CheckVideoGeneratedJob;
use Illuminate\Http\Request;

class TopicStoryController extends Controller
{
    protected TopicsStoryRepository $topicsStoryRepository;

	public function __construct(TopicsStoryRepository $topicsStoryRepository)
    {

		$this->topicsStoryRepository = $topicsStoryRepository;
    }

    public function listApi(Request $request)
    {
        $filters = $request->all();
		$stories = $this->topicsStoryRepository->getAllPaginated($filters);

        return response()->json([
            'stories' => $stories
        ], 200);
    }

    public function editApi($id)
    {
        $story = $this->topicsStoryRepository->getById($id);
        CheckVideoGeneratedJob::dispatch($story)->onQueue('getVideo')->delay(now()->addMinutes(1));

        return response()->json([
            'stories' => $story
        ], 200);
    }
}
