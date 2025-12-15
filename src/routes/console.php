<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;


/**
 * Cron Jobs
 */
Schedule::command('cron:getViral')->everyFiveMinutes();
Schedule::command('cron:getStories')->everyFiveMinutes();
Schedule::command('cron:sentStoryToGenerateVideo')->everyMinute();
Schedule::command('cron:getGeneratedVideo')->everyMinute();



/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
