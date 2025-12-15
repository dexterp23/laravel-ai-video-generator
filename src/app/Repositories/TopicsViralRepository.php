<?php

namespace App\Repositories;

use App\Models\TopicsViral;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TopicsViralRepository
{
    private TopicsViral $model;

    public function __construct( TopicsViral $model )
    {
        $this->model = $model;
    }

    public function getAllActiveForCron(int $limit = 0): Collection
    {
        $query = $this->model::query();
        $query
            ->where('is_active', true)
            ->where('cron_lock', false)
            ->when($limit, fn($q) => $q->limit($limit))
            ->orderBy('id', 'asc');
        return $query->get();
    }

    public function addByTile(string $title, array $attributtes)
    {
        $this->model->firstOrCreate(
            ['title' => $title], $attributtes
        );
    }

    public function updateAll(array $attributtes): Bool
    {
        return $this->model
            ->query()
            ->update($attributtes);
    }

    public function getById(int $id): TopicsViral
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
                            case 'filter_topic':
                                $query->where('topic_id', $value);
                                break;
                        }
                    }
                }

            })
            ->orderBy('title', 'asc');
        return $query->paginate(10);
    }

	public function add(array $attributtes): TopicsViral
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
