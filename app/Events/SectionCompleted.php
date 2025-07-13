<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SectionCompleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $sectionId;
    public $nextSectionId;
    public $worldId;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $sectionId, $nextSectionId = null, $worldId)
    {
        $this->userId = $userId;
        $this->sectionId = $sectionId;
        $this->nextSectionId = $nextSectionId;
        $this->worldId = $worldId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('App.User.' . $this->userId),
        ];
    }

    /**
     * Define the event name to broadcast as.
     */
    public function broadcastAs()
    {
        return 'section.completed';
    }

    /**
     * Data to broadcast with the event.
     */
    public function broadcastWith()
    {
        return [
            'section_id' => $this->sectionId,
            'next_section_id' => $this->nextSectionId,
            'world_id' => $this->worldId
        ];
    }
}
