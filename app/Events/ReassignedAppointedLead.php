<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReassignedAppointedLead implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $leadId;
    public $companyName;
    public $receivableName;
    public $product;
    public $oldOwnerName;
    public $productId;
    public $userProfileId;
    public $oldUserId;
    public $newUserId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($leadId, $companyName, $receivableName, $product, $oldOwnerName, $productId, $userProfileId, $oldUserId, $newUserId)
    {
        $this->leadId = $leadId;
        $this->companyName = $companyName;
        $this->receivableName = $receivableName;
        $this->product = $product;
        $this->oldOwnerName = $oldOwnerName;
        $this->productId = $productId;
        $this->userProfileId = $userProfileId;
        $this->oldUserId = $oldUserId;
        $this->newUserId = $newUserId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('reassign-appointed-lead');
    }
}
