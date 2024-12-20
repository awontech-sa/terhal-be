<?php

namespace App\Http\Resources\TouristResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlaceResource extends JsonResource
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
            'name' => $this->p_name,
            'lang' => $this->p_lang,
            'lat' => $this->p_lat,
            'place_type' => $this->placeType->pt_name,
        ];
    }
}
