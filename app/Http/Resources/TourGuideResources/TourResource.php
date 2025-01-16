<?php

namespace App\Http\Resources\TourGuideResources;

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
            "user_id" => $this->user_id,
            "t_name" => $this->t_name,
            "t_description" => $this->t_description,
            "t_image" => $this->t_image,
            "t_rate" => $this->t_rate,
            "t_date" => $this->t_date,
            "t_price" => $this->t_price,
            "t_videos" => $this->t_videos,
            't_duration' => $this->t_duration,
            'visitor_limit' => $this->visitor_limit,
            't_places' => json_decode($this->t_places, true)
        ];
    }
}
