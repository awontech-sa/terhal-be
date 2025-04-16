<?php

namespace App\Http\Resources\TouristResources;

use App\Http\Resources\TourGuideResources\TourResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserTourResource extends JsonResource
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
            // 'tour_id' => $this->tour_id,
            'user_id' => $this->user_id,
            'ut_count' => $this->ut_count,
            'ut_total_price' => $this->ut_total_price,
            'ut_comment' => $this->ut_comment,
            'ut_rate' => $this->ut_rate,
            'ut_status' => $this->ut_status,
            'ut_uuid' => $this->ut_uuid,
            // 'tour' => new TourResource($this->tour),
        ];
    }
}
