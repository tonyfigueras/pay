<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorldResource extends JsonResource
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
            'galaxy' => GalaxyResource::make($this->whenLoaded('galaxy')),
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'order' => $this->order,
            'glb' => $this->glb,
            'default_spawn' => [
                'x' => $this->default_spawn_x,
                'y' => $this->default_spawn_y,
                'z' => $this->default_spawn_z,
            ],
            'sections' => json_decode($this->sections, true) ?? [],
            'intro_seen' => $this->intro_seen,
            'tutorial_completed' => $this->tutorial_completed,
            'audios' => AudioResource::collection($this->whenLoaded('audios')),
            'area_trigger_events' => AreaTriggerEventResource::collection($this->whenLoaded('areaTriggerEvents')),
            'npcs' => NpcResource::collection($this->whenLoaded('npcs')),
            'coins' => CoinResource::collection($this->whenLoaded('coins')),
        ];
    }
}
