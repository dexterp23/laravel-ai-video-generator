<?php

namespace App\Support;

use App\Repositories\CronLockRepository;

class CronLock implements CronLockInterface
{
    protected CronLockRepository $cronLockRepository;

    public function __construct(
        CronLockRepository $cronLockRepository
    )
    {
        $this->cronLockRepository = $cronLockRepository;
    }

    public function handleEmpty(string $table, object $repository): void
    {
        $cronLock = $this->cronLockRepository->getByTable($table);

        if ($cronLock->isNotEmpty()) {
            $repository->updateAll(['cron_lock' => false]);
            $this->cronLockRepository->update($table);
        }
    }
}
