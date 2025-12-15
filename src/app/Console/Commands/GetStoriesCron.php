<?php

namespace App\Console\Commands;

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

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        app('StoryCreatorService')->run();
        return Command::SUCCESS;
    }
}
