<?php

namespace App\Http\Resources\TouristResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendeeResource extends JsonResource
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
            'comment' => $this->pivot->ue_comment,
            'rate' => $this->pivot->ue_rate,
            'is_favorite' => $this->pivot->is_favorite,
        ];
    }
}