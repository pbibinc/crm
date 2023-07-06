<?php

namespace App\Listeners;

use App\Events\LeadImportEvent;
use App\Models\LeadHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogLeadImportListener
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
     * @param  \App\Events\LeadImportEvent  $event
     * @return void
     */
    public function handle(LeadImportEvent $event)
    {
        //
        LeadHistory::create([
            'lead_id' => $event->lead->id,
            'user_profile_id' => $event->userProfileId,
            'changes' => json_encode(['user_profile_id' => $event->userProfileId, 'imported_at' => $event->importedAt]),
        ]);
    }
}
