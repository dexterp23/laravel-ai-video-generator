<?php

namespace App\Jobs;

use App\Services\Logger;
use App\Models\TopicsStory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Queue\Queueable;

class CheckVideoGeneratedJob implements ShouldQueue
{
    use Queueable;

    public $tries = 5;        // Pokušaj 5 puta
    public $timeout = 60;     // Svaki pokušaj max 60 sekundi
    public $backoff = 10;     // Čekaj 10 sekundi između pokušaja

    protected TopicsStory $story;

    /**
     * Create a new job instance.
     */
    public function __construct(TopicsStory $story)
    {
        $this->story = $story;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Logger::info('CheckVideoGeneratedJob', ['id' => $this->story->id]);
    }
}
