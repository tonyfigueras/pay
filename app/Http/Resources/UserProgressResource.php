<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProgressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'world_id' => $this->world_id,
            'total_coins' => $this->total_coins,
            'total_xp' => $this->total_xp,
            'level' => $this->level,
            'completed_actions' => $this->completed_actions,
            'unlocked_worlds' => $this->unlocked_worlds,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
