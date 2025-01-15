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
            'e_name' => $this->e_name,
            'e_description' => $this->e_description,
            'e_images' => $this->e_images,
            'e_videos' => $this->e_videos,
            'e_duration' => $this->e_duration,
            'e_location' => $this->e_location,
            'e_price' => $this->e_price,
            'e_rate' => $this->e_rate,
            'e_date' => $this->e_date,
            'event_type_id' => $this->eventType->id,
            'event_type' => $this->eventType->et_name,
            'e_lang' => $this->e_lang,
            'e_lat' => $this->e_lat,
            'attendees' => AttendeeResource::collection($this->attendees)
        ];
    }
}
