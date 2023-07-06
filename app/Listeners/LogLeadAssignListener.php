<?php

namespace App\Listeners;

use App\Events\LeadAssignEvent;
use App\Models\LeadHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogLeadAssignListener
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
     * @param  \App\Events\LeadAssignEvent  $event
     * @return void
     */
    public function handle(LeadAssignEvent $event)
    {
        //
        LeadHistory::create([
            'lead_id' => $event->lead->id,
            'user_profile_id' => $event->currentUserId,
            'changes' => json_encode(['user_profile_id' => $event->userProfileId, 'assigned_at' => $event->assignedAt]),
        ]);
    }
}
