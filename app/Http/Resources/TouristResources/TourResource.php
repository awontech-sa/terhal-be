<?php

namespace App\Http\Resources\TouristResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'tour_owner' => $this->user->name,
            'tour_id' => $this->id,
            'tour_name' => $this->t_name,
            'tour_description' => $this->t_description,
            'tour_image' => $this->t_image,
            'tour_videos' => $this->t_videos,
            'tour_duration' => $this->t_duration,
            'visitors_limit' => $this->visitor_limit,
            'rate' => $this->t_rate,
            'date' => $this->t_date,
            'price' => $this->t_price,
            'participants' => ParticipantResource::collection($this->participants),
        ];
    }
}