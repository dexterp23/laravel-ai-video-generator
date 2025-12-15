<?php

namespace App\Listeners;

use App\Services\Logger;
use App\Events\UserUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogUserUpdated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserUpdated  $event
     * @return void
     */
    public function handle(UserUpdated $event)
    {
        Logger::info('User updated event', [
            'id' => $event->user->id,
            'name' => $event->user->name,
        ]);
    }
}
