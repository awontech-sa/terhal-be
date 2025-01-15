<?php

namespace App\Http\Resources\AdminResources;

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
            "user_id" => $this->user_id,
            "event_type_id" => $this->event_type_id,
            "e_images" => $this->e_images,
            "e_name" => $this->e_name,
            "e_location" => $this->e_location,
            "e_price" => $this->e_price,
            "e_description" => $this->e_description,
            "e_rate" => $this->e_rate,
            "e_date" => $this->e_date,
            "e_videos" => $this->e_videos,
            'e_lang' => $this->e_lang,
            'e_lat' => $this->e_lat
        ];
    }
}
