<?php

namespace App\Services\Clients;

use App\Policies\ExponentialBackoffPolicy;
use App\Services\Logger;

class RetryingVideoClient implements RetryingVideoClientInterface
{
    private int $maxAttempts;
    protected Logger $logger;
    protected ExponentialBackoffPolicy $policy;

    public function __construct(
        private AIVideoClientInterface $next,
        int $maxAttempts = 5
    ) {
        $this->maxAttempts = $maxAttempts;
        $this->logger = new Logger();
        $this->policy = new ExponentialBackoffPolicy();
    }

    public function run(string $type, array $data): mixed
    {
        $attempt = 0;

        while ($attempt < $this->maxAttempts) {
            try {
                return $this->next->video($type, $data);
            } catch (\Exception $e) {
                if (!$this->policy->shouldRetry($e)) {
                    throw $e;
                }

                $attempt++;
                $wait = $this->policy->getSleepTime($attempt);

                $this->logger::warning("Rate limited. Retry in {$wait}s");
                sleep($wait);
            }
        }

        throw new \RuntimeException(
            "Chat request failed after {$this->maxAttempts} attempts."
        );
    }
}
