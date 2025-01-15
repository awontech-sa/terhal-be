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
            'event' => EventResource::collection($this->id),
            'event_type_id' => $this->eventType->id,
            'event_type' => $this->eventType->et_name,
            'attendees' => AttendeeResource::collection($this->attendees)
        ];
    }
}
