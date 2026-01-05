<?php

namespace App\Console\Commands;

use App\Services\GetGeneratedVideoServiceInterface;
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

    protected GetGeneratedVideoServiceInterface $getGeneratedVideoService;

    public function __construct(
        GetGeneratedVideoServiceInterface $getGeneratedVideoService,
    )
    {
        parent::__construct();
        $this->getGeneratedVideoService = $getGeneratedVideoService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->getGeneratedVideoService->run();
        return Command::SUCCESS;
    }
}
