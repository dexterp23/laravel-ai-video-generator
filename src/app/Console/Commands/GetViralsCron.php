<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetViralsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:getViral';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get virals from topic';

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
        app('ViralCreatorService')->run();
        return Command::SUCCESS;
    }
}
