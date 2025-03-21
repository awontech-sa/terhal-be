<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequests\ProductRequest;
use App\Http\Resources\StoreResources\ProductResource;
use App\Models\Product;

class StoreController extends Controller
{
    public function create(ProductRequest $request)
    {
        $data = $request->validated();

        $imagePaths = [];
        $videoPaths = [];

        // Handle image uploads
        if ($request->hasFile('pr_images')) {
            foreach ($request->file('pr_images') as $image) {
                $path = $image->store('product-images', 'do');
                $imagePaths[] = $path;
            }
        }

        // Handle video uploads
        if ($request->hasFile('pr_videos')) {
            foreach ($request->file('pr_videos') as $video) {
                $path = $video->store('product-videos', 'do');  // Correct path
                $videoPaths[] = $path;
            }
        }

        $data['pr_images'] = json_encode($imagePaths);
        $data['pr_videos'] = json_encode($videoPaths);

        $new_product = Product::create($data);

        return response()->json(new ProductResource($new_product));
    }
}
