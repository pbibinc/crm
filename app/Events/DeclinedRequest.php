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
    /**
     * Create a new event instance.
     *
     * @param $leadId
     * @param $generalInformationId
     * @param $productId
     * @return void
     */
    public function __construct($leadId, $generalInformationId, $productId)
    {
        $this->leadId = $leadId;
        $this->generalInformationId = $generalInformationId;
        $this->productId = $productId;
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