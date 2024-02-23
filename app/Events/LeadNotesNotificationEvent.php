<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeadNotesNotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $noteTitle;
    public $noteDescription;
    public $userId;
    public $leadId;
    public $senderId;
    public $icon;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($noteTitle, $noteDescription, $userId, $leadId, $senderId, $icon)
    {
        $this->noteTitle = $noteTitle;
        $this->noteDescription = $noteDescription;
        $this->userId = $userId;
        $this->leadId = $leadId;
        $this->senderId = $senderId;
        $this->icon = $icon;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('lead-notes-notification');
    }
}