<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NpcResource extends JsonResource
{
     /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'npc_id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'actions_type' => 'new',
            'actions' => $this->when(
                $this->relationLoaded('actions'),
                ActionsResource::collection($this->actions()->with('children')->whereIsRoot()->get())
            ),
        ];
    }
}
