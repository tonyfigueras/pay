<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StepCompleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId;
    public $stepId;
    public $nextStep;

    /**
     * Create a new event instance.
     */
    public function __construct($userId, $stepId, $nextStep = null)
    {
        $this->userId = $userId;
        $this->stepId = $stepId;
        $this->nextStep = $nextStep; // Handle null value for nextStep
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
}
