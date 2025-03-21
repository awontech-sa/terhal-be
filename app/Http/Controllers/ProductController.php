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

    public function show(Product $product)
    {
        $products = Product::where('id', $product->id)->get();

        return $products;
    }

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

        return ProductResource::collection($products);
    }

    public function addProductToCart(Request $request, Product $product)
    {
        $user = Auth::user();

        $existProduct = $product->buyers()->where('user_id', $user->id)->first();
        if ($existProduct) {
            $existProduct->pivot->is_buy = $request->cart;
            $existProduct->pivot->save();
        } else {
            $product->buyers()->attach($user->id, [
                'is_buy' => $request->cart
            ]);
        }

        return response()->json(['message' => 'تم إضافة المنتج للعربة'], 200);
    }

    public function favorite(Request $request, Product $product)
    {
        $user = Auth::user();

        $existProduct = $product->buyers()->where('user_id', $user->id)->first();
        if ($existProduct) {
            $existProduct->pivot->is_favorite = $request->favorite;
            $existProduct->pivot->save();
        } else {
            $product->buyers()->attach($user->id, [
                'is_favorite' => $request->favorite
            ]);
        }

        return response()->json(['message' => 'تم إضافة المنتج إلى المفضلة'], 200);
    }
}
