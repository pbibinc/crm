<?php

namespace App\Listeners;

use App\Events\LeadReassignEvent;
use App\Models\LeadHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogLeadReassignListener
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
     * @param  \App\Events\LeadReassignEvent  $event
     * @return void
     */
    public function handle(LeadReassignEvent $event)
    {

        LeadHistory::create([
            'lead_id' => $event->lead->id,
            'user_profile_id' => $event->currentUserId,
            'changes' => json_encode(['user_profile_id' => $event->userProfileId, 'reassigned_at' => $event->reassignedAt]),
        ]);
    }
}
