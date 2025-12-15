<?php

namespace App\Providers;

use App\Repositories\CronLockRepository;
use App\Repositories\TopicsRepository;
use App\Repositories\TopicsViralRepository;
use App\Repositories\TopicsStoryRepository;
use App\Services\ViralCreatorService;
use App\Services\StoryCreatorService;
use App\Services\SentStoryToGenerateVideoService;
use App\Services\GetGeneratedVideoService;
use App\Support\CronLock;
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
        $this->app->bind('ViralCreatorService', function ($app) {
            return new ViralCreatorService(
                $app->make(TopicsRepository::class),
                $app->make(TopicsViralRepository::class)
            );
        });

        $this->app->bind('StoryCreatorService', function ($app) {
            return new StoryCreatorService(
                $app->make(TopicsViralRepository::class),
                $app->make(TopicsStoryRepository::class)
            );
        });

        $this->app->bind('SentStoryToGenerateVideoService', function ($app) {
            return new SentStoryToGenerateVideoService(
                $app->make(TopicsStoryRepository::class)
            );
        });

        $this->app->bind('GetGeneratedVideoService', function ($app) {
            return new GetGeneratedVideoService(
                $app->make(TopicsStoryRepository::class)
            );
        });

        $this->app->bind('CronLock', function ($app) {
            return new CronLock(
                $app->make(CronLockRepository::class)
            );
        });
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
