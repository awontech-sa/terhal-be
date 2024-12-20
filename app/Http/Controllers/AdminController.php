<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequests\EventRequest;
use App\Http\Requests\AdminRequests\ProductTypeRequest;
use App\Http\Resources\AdminResources\EventResource;
use App\Http\Resources\AdminResources\ProductTypeResource;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\ProductType;

class AdminController extends Controller
{
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create(EventRequest $request)
    {
        $data = $request->validated();

        $imagePaths = [];
        $videoPaths = [];

        // Handle image uploads
        if ($request->hasFile('e_images')) {
            foreach ($request->file('e_images') as $image) {
                $path = $image->store('uploads/events', 'public');
                $imagePaths[] = $path;
            }
        }

        // Handle video uploads
        if ($request->hasFile('e_videos')) {
            foreach ($request->file('e_videos') as $video) {
                $path = $video->store('uploads/events', 'public');  // Correct path
                $videoPaths[] = $path;
            }
        }

        $data['e_images'] = json_encode($imagePaths);
        $data['e_videos'] = json_encode($videoPaths);

        $new_event = Event::create($data);

        return response()->json(new EventResource($new_event));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }

    public function createProduct(ProductTypeRequest $request)
    {
        $data = $request->validated();

        $new_product_type = ProductType::create($data);

        return response()->json(new ProductTypeResource($new_product_type));
    }
}
