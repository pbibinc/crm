<?php

namespace App\Providers;

use App\Events\AppointmentTaken;
use App\Events\AssignAppointedLeadEvent;
use App\Events\AssignPolicyForRenewalEvent;
use App\Events\LeadAssignEvent;
use App\Events\LeadImportEvent;
use App\Events\LeadReassignEvent;
use App\Events\ReassignedAppointedLead;
use App\Events\SendRenewalReminderEvent;
use App\Events\UpdateGeneralInformationEvent;
use App\Listeners\AssignPolicyForRenewalListener;
use App\Listeners\BroadcastUserLoginNotification;
use App\Listeners\BroadcastUserLogoutNotification;
use App\Listeners\LogAppointmentTaken;
use App\Listeners\LogAssignAppointedLeadListener;
use App\Listeners\LogLeadAssignListener;
use App\Listeners\LogLeadImportListener;
use App\Listeners\LogLeadReassignListener;
use App\Listeners\LogReassignAppointedLeadListner;
use App\Listeners\SendRenewalReminderListener;
use App\Listeners\UpdateGeneralInformationListener;
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

        Event::listen(
            AppointmentTaken::class,
            [LogAppointmentTaken::class, 'handle']
        );

        Event::listen(queueable(function(LeadImportEvent $event){

        }));


        //event for assigning appointed lead
        Event::listen(queueable(function(AssignAppointedLeadEvent $event){

        }));

        Event::listen(
            AssignAppointedLeadEvent::class,
            [LogAssignAppointedLeadListener::class, 'handle']
        );

        //event listener for reassigning appointed lead
        Event::listen(queueable(function(ReassignedAppointedLead $event){

        }));

        Event::listen(
            ReassignedAppointedLead::class,
            [LogReassignAppointedLeadListner::class, 'handle']
        );

        Event::listen(queueable(function(AssignPolicyForRenewalListener $event){

        }));

        Event::listen(
            AssignPolicyForRenewalEvent::class,
            [AssignPolicyForRenewalListener::class, 'handle']
        );

        Event::listen(queueable(function(SendRenewalReminderListener $event){

        }));

        Event::listen(
            SendRenewalReminderEvent::class,
            [SendRenewalReminderListener::class, 'handle']
        );

        Event::listen(queueable(function(UpdateGeneralInformationListener $event){

        }));

        Event::listen(
            UpdateGeneralInformationEvent::class,
            [UpdateGeneralInformationListener::class, 'handle']
        );

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