<?php

namespace App\Http\Resources\StoreResources;

use App\Http\Resources\TouristResources\BuyerResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'owner' => $this->user->name,
            'product_id' => $this->id,
            'product_name' => $this->pr_name,
            'images' => $this->pr_images,
            'videos' => $this->pr_videos,
            'price' => $this->pr_price,
            'rate' => $this->pr_rates,
            'description' => $this->pr_description,
            'product_type' => $this->productType->prt_name,
            'buyers' => BuyerResource::collection($this->buyers),
        ];
    }
}