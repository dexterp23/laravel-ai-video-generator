<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetGeneratedVideoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:getGeneratedVideo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get generated video from ai client';

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
        app('GetGeneratedVideoService')->run();
        return Command::SUCCESS;
    }
}
