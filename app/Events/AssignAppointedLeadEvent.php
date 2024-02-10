<?php

namespace App\Events;

use App\Models\QuotationProduct;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssignAppointedLeadEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $leadId;
    public $userProfileId;
    public $productId;
    public $userId;
    /**
     * Create a new event instance.\
     *
     * @return void
     */
    public function __construct($leadId, $userProfileId, $productId,
    $userId)
    {
        $this->leadId = $leadId;
        $this->userProfileId = $userProfileId;
        $this->productId = $productId;
        $this->userId = $userId;
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('assign-appointed-lead');
    }
}