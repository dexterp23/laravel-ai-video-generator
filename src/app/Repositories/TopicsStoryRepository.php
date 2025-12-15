<?php

namespace App\Repositories;

use App\Models\TopicsStory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TopicsStoryRepository
{
    private TopicsStory $model;

    public function __construct( TopicsStory $model )
    {
        $this->model = $model;
    }

    public function getAllForGetGeneratedVideo(int $limit = 0): Collection
    {
        $query = $this->model::query();
        $query
            ->where('video_status', '=', TopicsStory::VIDEO_STATUS_SENT_FOR_GENERATION)
            ->whereNotNull('video_id')
            ->when($limit, fn($q) => $q->limit($limit))
            ->orderBy('id', 'asc');
        return $query->get();
    }

    public function getAllForGeneratingVideo(int $limit = 0): Collection
    {
        $query = $this->model::query();
        $query
            ->where('video_status', '=', TopicsStory::VIDEO_STATUS_FOR_GENERATION)
            ->when($limit, fn($q) => $q->limit($limit))
            ->orderBy('id', 'asc');
        return $query->get();
    }

    public function getById(int $id): TopicsStory
    {
        return $this->model->where('id', $id)->first();
    }

	public function getAllPaginated(array $filters): LengthAwarePaginator
    {
        $query = $this->model
            ->when($filters, function ($query, $filters) {
                foreach ($filters as $field => $value) {
                    if (!empty($value)) {
                        switch ($field) {
                            case 'filter':
                                $query->where(function ($q) use ($value) {
                                    $q->where('title', 'like', "%{$value}%");
                                });
                                break;
                            case 'filter_viral':
                                $query->where('viral_id', $value);
                                break;
                        }
                    }
                }

            })
            ->orderBy('title', 'asc');
        return $query->paginate(10);
    }

	public function add(array $attributtes): TopicsStory
    {
        return $this->model->create($attributtes);
    }

    public function update(int $id, array $attributtes): Bool
    {
        return $this->model->where('id', $id)
                           ->update($attributtes);
    }

    public function delete(int $id): Bool
    {
        return $this->model
            ->where('id', $id)
            ->delete();
    }
}
