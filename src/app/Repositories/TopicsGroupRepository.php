<?php

namespace App\Repositories;

use App\Models\TopicsGroup;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class TopicsGroupRepository
{
    private TopicsGroup $model;

    public function __construct( TopicsGroup $model )
    {
        $this->model = $model;
    }

    public function getById(int $id): TopicsGroup
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
                        }
                    }
                }

            })
            ->orderBy('title', 'asc');
        return $query->paginate(10);
    }

	public function add(array $attributtes): TopicsGroup
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
