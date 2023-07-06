<?php

namespace App\Events;

use App\Models\Lead;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadImportEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lead;
    public $userProfileId;
    public $importedAt;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Lead $lead, $userProfileId, $importedAt)
    {
        //
        $this->lead = $lead;
        $this->userProfileId = $userProfileId;
        $this->importedAt = $importedAt;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
