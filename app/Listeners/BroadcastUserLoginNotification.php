<?php

namespace App\Listeners;

use App\Events\UserSessionChange;
use App\Models\UserProfile;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class BroadcastUserLoginNotification
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
     * @param  object  $event
     * @return void
     */
    public function handle(Login $event): void
    {
        Log::debug('Handling Logout event');
        broadcast(new UserSessionChange("test login this", 'success'));
    }
}
