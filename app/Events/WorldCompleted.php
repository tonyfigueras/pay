<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WorldCompleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $worldId;
    public $nextWorldId;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $worldId, $nextWorldId = null)
    {
        $this->userId = $userId;
        $this->worldId = $worldId;
        $this->nextWorldId = $nextWorldId;
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
        return 'world.completed';
    }

    /**
     * Data to broadcast with the event.
     */
    public function broadcastWith()
    {
        return [
            'world_id' => $this->worldId,
            'next_world_id' => $this->nextWorldId,
        ];
    }
}
