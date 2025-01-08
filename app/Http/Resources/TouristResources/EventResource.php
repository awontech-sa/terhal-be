<?php

namespace App\Http\Resources\TouristResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'event_owner' => $this->user->name,
            'event_id' => $this->id,
            'event_name' => $this->e_name,
            'event_description' => $this->e_description,
            'event_images' => $this->e_images,
            'event_videos' => $this->e_videos,
            'event_duration' => $this->e_duration,
            'event_location' => $this->e_location,
            'event_price' => $this->e_price,
            'event_rate' => $this->e_rate,
            'event_date' => $this->e_date,
            'event_type_id' => $this->eventType->id,
            'event_type' => $this->eventType->et_name,
            'attendees' => AttendeeResource::collection($this->attendees),
        ];
    }
}