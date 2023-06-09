<?php

namespace App\Providers;

use App\Events\LeadAssignEvent;
use App\Events\LeadImportEvent;
use App\Events\LeadReassignEvent;
use App\Listeners\BroadcastUserLoginNotification;
use App\Listeners\BroadcastUserLogoutNotification;
use App\Listeners\LogLeadAssignListener;
use App\Listeners\LogLeadImportListener;
use App\Listeners\LogLeadReassignListener;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use function Illuminate\Events\queueable;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Login::class => [
            BroadcastUserLoginNotification::class,
        ],
        Logout::class => [
            BroadcastUserLogoutNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
        Event::listen(
            LeadAssignEvent::class,
            [LogLeadAssignListener::class, 'handle']
        );

        Event::listen(queueable(function(LeadAssignEvent $event){
            //
        }));

        Event::listen(
            LeadReassignEvent::class,
            [LogLeadReassignListener::class, 'handle']
        );

        Event::listen(queueable(function(LeadReassignEvent $event){
            //
        }));

        Event::listen(
            LeadImportEvent::class,
            [LogLeadImportListener::class, 'handle']
        );

        Event::listen(queueable(function(LeadImportEvent $event){

        }));
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
