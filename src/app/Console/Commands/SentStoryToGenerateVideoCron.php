<?php

namespace App\Console\Commands;

use App\Services\SentStoryToGenerateVideoServiceInterface;
use Illuminate\Console\Command;

class SentStoryToGenerateVideoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:sentStoryToGenerateVideo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sent story to generate video';

    protected SentStoryToGenerateVideoServiceInterface $sentStoryToGenerateVideoService;

    public function __construct(
        SentStoryToGenerateVideoServiceInterface $sentStoryToGenerateVideoService,
    )
    {
        parent::__construct();
        $this->sentStoryToGenerateVideoService = $sentStoryToGenerateVideoService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->sentStoryToGenerateVideoService->run();
        return Command::SUCCESS;
    }
}
