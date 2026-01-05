<?php

namespace App\Console\Commands;

use App\Services\StoryCreatorServiceInterface;
use Illuminate\Console\Command;

class GetStoriesCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:getStories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get stories from viral';

    protected StoryCreatorServiceInterface $storyCreatorService;

    public function __construct(
        StoryCreatorServiceInterface $storyCreatorService,
    )
    {
        parent::__construct();
        $this->storyCreatorService = $storyCreatorService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->storyCreatorService->run();
        return Command::SUCCESS;
    }
}
