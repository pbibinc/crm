<?php

namespace App\Listeners;

use App\Events\AppointmentTaken;
use App\Models\LeadHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogAppointmentTaken
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    use InteractsWithQueue;
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\AppointmentTaken  $event
     * @return void
     */
    public function handle(AppointmentTaken $event)
    {
        //
        LeadHistory::create([
            'lead_id' => $event->lead->id,
            'user_profile_id' => $event->currentUserId,
            'changes' => json_encode(['user_profile_id' => $event->userProfileId, 'appointed_by' => $event->appointedBy]),
        ]);
    }
}