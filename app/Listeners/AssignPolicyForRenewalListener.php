<?php

namespace App\Listeners;

use App\Models\LeadHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssignPolicyForRenewalListener
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
    public function handle($event)
    {
        LeadHistory::create([
            'lead_id' => $event->leadId,
            'user_profile_id' => $event->userProfile,
            'changes' => json_encode(['user_profile_id' => $event->userProfile, 'assigned_renewal_policy_at' => now()])
        ]);
    }
}
