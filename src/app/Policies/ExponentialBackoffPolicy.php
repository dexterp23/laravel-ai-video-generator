<?php

namespace App\Policies;

class ExponentialBackoffPolicy
{
    private int $baseSleep;

    public function __construct(
        int $baseSleep = 2
    ) {
        $this->baseSleep = $baseSleep;
    }

    public function shouldRetry(\Exception $e): bool
    {
        return $e->getCode() === 429;
    }

    public function getSleepTime(int $attempt): int
    {
        return pow($this->baseSleep, $attempt);
    }
}
