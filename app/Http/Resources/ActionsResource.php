<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $properties = is_string($this->properties) 
            ? json_decode($this->properties, true) 
            : $this->properties;

        return [
            'id' => $this->id,
            'actionable_id' => $this->actionable_id,
            'actionable_type' => $this->actionable_type,
            'action_type' => $this->action_type,
            'parent_id' => $this->parent_id,
            'order' => $this->order,
            'properties' => $properties,
            'audios' => $this->whenLoaded('audios', function() {
                return $this->audios->map(function($audio) {
                    return [
                        'name' => $audio->name,
                        'path' => $audio->path
                    ];
                });
            }),
            'actions' => $this->when(
                $this->actions->isNotEmpty(),
                ActionsResource::collection($this->actions)
            ),
        ];
    }
}
