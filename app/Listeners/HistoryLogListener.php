<?php

namespace App\Listeners;

use App\Events\HistoryLogsEvent;
use App\Models\LeadHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HistoryLogListener
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
    public function handle(HistoryLogsEvent $event)
    {
        LeadHistory::create([
            'lead_id' => $event->leadId,
            'user_profile_id' => $event->userProfileId,
            'changes' => json_encode(['title' => $event->title, 'description' => $event->description]),
        ]);
    }
}
