<?php

namespace App\Providers;

use App\Services\AiService;
use App\Services\AiServiceInterface;
use App\Services\GetGeneratedVideoService;
use App\Services\GetGeneratedVideoServiceInterface;
use App\Services\SentStoryToGenerateVideoService;
use App\Services\SentStoryToGenerateVideoServiceInterface;
use App\Services\StoryCreatorService;
use App\Services\StoryCreatorServiceInterface;
use App\Services\ViralCreatorService;
use App\Services\ViralCreatorServiceInterface;
use App\Support\CronLock;
use App\Support\CronLockInterface;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            GetGeneratedVideoServiceInterface::class,
            GetGeneratedVideoService::class
        );
        $this->app->bind(
            SentStoryToGenerateVideoServiceInterface::class,
            SentStoryToGenerateVideoService::class
        );
        $this->app->bind(
            StoryCreatorServiceInterface::class,
            StoryCreatorService::class
        );
        $this->app->bind(
            ViralCreatorServiceInterface::class,
            ViralCreatorService::class
        );
        $this->app->bind(
            CronLockInterface::class,
            CronLock::class
        );
        $this->app->bind(
            AiServiceInterface::class,
            AiService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('role', function (...$roles) {
            return auth()->check() && in_array(auth()->user()->role, $roles);
        });

        User::observe(UserObserver::class);
    }
}
