<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AudioResource extends JsonResource
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
            'name' => $this->name,
            'resources' => $this->resources,
            'loop' => $this->loop,
            'position' => [
                'x' => $this->x,
                'y' => $this->y,
                'z' => $this->z,
            ],
            'distance' => $this->distance,
            'maxDistance' => $this->maxDistance,
            'volumeDucking' => json_decode($this->volumeDucking, true),
        ];
    }
}
