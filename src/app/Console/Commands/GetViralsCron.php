<?php

namespace App\Console\Commands;

use App\Services\ViralCreatorServiceInterface;
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

    protected ViralCreatorServiceInterface $viralCreatorService;

    public function __construct(
        ViralCreatorServiceInterface $viralCreatorService,
    )
    {
        parent::__construct();
        $this->viralCreatorService = $viralCreatorService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->viralCreatorService->run();
        return Command::SUCCESS;
    }
}
