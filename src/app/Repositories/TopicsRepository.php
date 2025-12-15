<?php

namespace App\Repositories;

use App\Models\Topics;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TopicsRepository
{
    private Topics $model;

    public function __construct( Topics $model )
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

    public function updateAll(array $attributtes): Bool
    {
        return $this->model
            ->query()
            ->update($attributtes);
    }

    public function getById(int $id): Topics
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
                            case 'filter_group':
                                $query->where('group_id', $value);
                                break;
                        }
                    }
                }

            })
            ->orderBy('title', 'asc');
        return $query->paginate(10);
    }

	public function add(array $attributtes): Topics
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
