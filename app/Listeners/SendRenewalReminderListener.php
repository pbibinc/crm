<?php

namespace App\Listeners;

use App\Events\SendRenewalReminderEvent;
use App\Models\LeadHistory;
use App\Models\LeadNotes;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRenewalReminderListener
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
    public function handle(SendRenewalReminderEvent $event)
    {

        LeadHistory::create([
            'lead_id' => $event->leadId,
            'user_profile_id' => $event->userProfileId,
            'changes' => json_encode(['policy_name' => $event->productName, 'sent_date' => now(), 'type' => 'renewal_reminder'])
        ]);

        LeadNotes::create([
            'lead_id' => $event->leadId,
            'user_profile_id' => $event->userProfileId,
            'description' => 'Renewal reminder sent for policy number ' . $event->policyNumber,
            'title' => 'Renewal Reminder Sent',
            'status' => 'renewal-reminder'
        ]);
    }
}