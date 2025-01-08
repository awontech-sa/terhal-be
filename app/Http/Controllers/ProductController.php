<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoreResources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'product_type' => 'nullable|string|exists:product_types,prt_name',
        ]);

        // Get the product_type from the validated data
        $productType = $validated['product_type'] ?? null;

        // Build the query with eager loading
        $query = Product::with([
            'user',
            'buyers' => function ($query) {
                $query->select('name', 'up_comment', 'up_rate')
                    ->where('status', 'تم التوصيل');
            },
            'productType'
        ]);

        // filter if product_type exists
        if ($productType) {
            $query->whereHas('productType', fn($q) => $q->where('prt_name', $productType));
        }

        // paginate
        $products = $query->paginate(10);

        // Return the data as a resource
        return ProductResource::collection($products);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

     public function show(int $id)
    {
        $product = Product::where('id', $id)->select('pr_images', 'pr_videos', 'pr_price', 'pr_description')->get();

        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
