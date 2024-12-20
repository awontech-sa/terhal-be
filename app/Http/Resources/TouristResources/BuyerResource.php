<?php

namespace App\Http\Resources\TouristResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuyerResource extends JsonResource
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
            'comment' => $this->pivot->up_comment,
            'rate' => $this->pivot->up_rate,
            'is_favorite' => $this->pivot->is_favorite,
            'is_buy' => $this->pivot->is_buy,
            'status' => $this->pivot->up_status,
        ];
    }
}
