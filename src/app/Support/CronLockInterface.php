<?php

namespace App\Support;

interface CronLockInterface
{
    public function handleEmpty(string $table, object $repository): void;
}
