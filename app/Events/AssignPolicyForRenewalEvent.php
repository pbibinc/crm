<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssignPolicyForRenewalEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $policy;
    public $userProfile;
    public $leadId;
    public $userId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($policy, $userProfile, $leadId, $userId)
    {
        $this->policy = $policy;
        $this->userProfile = $userProfile;
        $this->leadId = $leadId;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('assign-policy-for-renewal');
    }
}