<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AreaTriggerEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    { 
        $size = $this->size;
        if (is_string($size)) {
            $decoded = json_decode($size, true);
            $size = $decoded !== null ? $decoded : $size;
        }
        
        if (is_string($size) && str_contains($size, ',')) {
            $size = explode(',', $size);
        }

        return [
            'id' => $this->id,
            'element_id' => $this->name === 'area_trigger_fresco' ? 'area_trigger_fresco' : null,
            'name' => $this->name,
            'slug' => $this->slug,
            'shape' => $this->shape,
            'position' => [
                'x' => $this->x,
                'y' => $this->y,
                'z' => $this->z,
            ],
            'size' => $size,
            'actions_type' => $this->actions_type,
            'auto_trigger' => $this->auto_trigger,
            'disabled' => $this->disabled,
            'actions' => ActionsResource::collection($this->whenLoaded('actions')),
        ];
    }
}  