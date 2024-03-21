<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendRenewalReminderEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $leadId;
    public $policyNumber;
    public $productName;
    public $userProfileId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($leadId, $policyNumber, $productName, $userProfileId)
    {
        $this->leadId = $leadId;
        $this->policyNumber = $policyNumber;
        $this->productName = $productName;
        $this->userProfileId = $userProfileId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('send-renewal-reminder-event');
    }
}
