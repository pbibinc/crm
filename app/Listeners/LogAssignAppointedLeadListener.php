<?php

namespace App\Listeners;

use App\Events\AssignAppointedLeadEvent;
use App\Models\LeadHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogAssignAppointedLeadListener
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
      * @param  \App\Events\AssignAppointedLeadEvent  $event
     * @return void
     */
    public function handle(AssignAppointedLeadEvent $event)
    {
        LeadHistory::create([
            'lead_id' => $event->leadId,
            'user_profile_id' => $event->userProfileId,
            'changes' => json_encode(['user_profile_id' => $event->userProfileId, 'product_id' => $event->productId, 'assign_appointed_at' => now()]),
        ]);
    }
}