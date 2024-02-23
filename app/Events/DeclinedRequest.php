<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeclinedRequest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $leadId;
    public $generalInformationId;
    public $productId;
    public $userId;
    /**
     * Create a new event instance.
     *
     * @param $leadId
     * @param $generalInformationId
     * @param $productId
     * @return void
     */
    public function __construct($leadId, $generalInformationId, $productId, $userId)
    {
        $this->leadId = $leadId;
        $this->generalInformationId = $generalInformationId;
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
        return new Channel('declined-make-payment-request');
    }
}