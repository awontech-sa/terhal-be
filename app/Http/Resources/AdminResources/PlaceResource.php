<?php

namespace App\Http\Resources\AdminResources;

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
            'place_type_id' => $this->place_type_id,
            'p_name' => $this->p_name,
            'p_lang' => $this->p_lang,
            'p_lat' => $this->p_lat
        ];
    }
}
