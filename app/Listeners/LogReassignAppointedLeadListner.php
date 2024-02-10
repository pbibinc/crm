<?php

namespace App\Listeners;

use App\Events\ReassignedAppointedLead;
use App\Models\LeadHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogReassignAppointedLeadListner
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
     * @param  object  $event
     * @return void
     */
    public function handle(ReassignedAppointedLead $event)
    {
        Log::info('ReassignedAppointedLead:' . json_encode($event));
        //
        LeadHistory::create([
            'lead_id' => $event->leadId,
            'user_profile_id' => $event->userProfileId,
            'changes' => json_encode(['company_name'=> $event->companyName, 'product' => $event->product, 'old_owner_name' => $event->oldOwnerName, 'product_id' => $event->productId, 'new_owner_name' => $event->receivableName]),
        ]);
    }
}