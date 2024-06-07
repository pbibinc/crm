<?php

namespace App\Listeners;

use App\Models\LeadHistory;
use App\Models\LeadNotes;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateGeneralInformationListener
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
            'user_profile_id' => $event->userProfileId,
            'changes' => json_encode(['changes' => $event->changes, 'sent_out_date' => $event->date, 'type' => $event->type])
        ]);

    }
}