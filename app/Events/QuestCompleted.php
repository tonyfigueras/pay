<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuestCompleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $questId;
    public $nextQuestId;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $questId, $nextQuestId)
    {
        $this->userId = $userId;
        $this->questId = $questId;
        $this->nextQuestId = $nextQuestId;
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
        return 'quest.completed';
    }

    /**
     * Data to broadcast with the event.
     */
    public function broadcastWith()
    {
        return [
            'quest_id' => $this->questId,
            'next_quest_id' => $this->nextQuestId,
        ];
    }
}
