<?php

namespace App\Console\Commands;

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
        app('SentStoryToGenerateVideoService')->run();
        return Command::SUCCESS;
    }
}
