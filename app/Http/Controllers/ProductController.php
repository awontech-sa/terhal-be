<?php

namespace App\Http\Controllers;

use App\Http\Resources\StoreResources\ProductResource;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function store(Product $product) {}

    /**
     * Display the specified resource.
     */

    public function show(Product $product)
    {
        $products = Product::where('id', $product->id)->get();

        return $products;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Product $product, int $id)
    {
        $seller = Auth::user(); // المستخدم الحالي (البائع)

        $existProduct = $product->buyers()->where('user_id', $id)->first();

        if ($existProduct) {
            $product->buyers()->updateExistingPivot($id, [
                'up_status' => $request->status,
            ]);
        }
        return response()->json(['message' => 'تم تحديث حالة الطلب'], 200);
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

    public function comment(Request $request, Product $product)
    {
        $user = Auth::user();

        $existComment = $product->buyers()->where('user_id', $user->id)->first();
        if ($existComment) {
            $existComment->pivot->up_comment = $request->comment;
            $existComment->pivot->save();
        } else {
            $product->buyers()->attach($user->id, [
                'up_comment' => $request->comment
            ]);
        }

        return response()->json(['message' => 'تم إضافة المراجعة'], 200);
    }

    public function rate(Request $request, Product $product)
    {
        $user = Auth::user();

        $exstingRate = $product->buyers()->where('user_id', $user->id)->first();
        if ($exstingRate) {
            $exstingRate->pivot->up_rate = $request->rate;
            $exstingRate->pivot->save();
        } else {
            $product->buyers()->attach($user->id, [
                'up_rate' => $request->rate
            ]);
        }

        return response()->json(['message' => 'تم إضافة التقييم'], 200);
    }

    public function showCart()
    {
        $user = Auth::user();

        $buyer = User::where('id', $user->id)->first();

        $cart = $buyer->purchasedProducts()->get();

        return response()->json(["message" => $cart], 200);
    }

    public function showProduct(int $id)
    {
        $products = Product::where('product_type_id', $id)->get();

        return $products;
    }
}
