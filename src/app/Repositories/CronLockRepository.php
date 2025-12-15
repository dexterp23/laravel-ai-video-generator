<?php

namespace App\Repositories;

use App\Models\CronLock;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CronLockRepository
{
    private CronLock $model;

    public function __construct( CronLock $model )
    {
        $this->model = $model;
    }

    public function getByTable(string $table): Collection
    {
        return $this->model
            ->where('table', $table)
            ->where('date', '<', today())
            ->get();
    }

    public function update(string $table): Bool
    {
        return $this->model->where('table', $table)
                           ->update(['date' => now()]);
    }
}
