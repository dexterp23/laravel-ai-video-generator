<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    private User $model;

    public function __construct( User $model )
    {
        $this->model = $model;
    }

    public function getById(int $userId): User
    {
        return $this->model->where('id', $userId)->first();
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
                                    $q->where('name', 'like', "%{$value}%")
                                        ->orWhere('email', 'like', "%{$value}%");
                                });
                                break;
                            case 'filter_role':
                                $query->where('role', $value);
                                break;
                        }
                    }
                }

            })
            ->orderBy('name', 'asc');
        return $query->paginate(10);
    }

	public function add(array $attributtes): User
    {
        return $this->model->create($attributtes);
    }

    public function update(int $id, array $attributtes): void
    {
        $this->model->where('id', $id)->update($attributtes);
    }

    public function delete(int $id): void
    {
        $this->model->where('id', $id)->delete();
    }
}
