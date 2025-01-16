<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequests\EventRequest;
use App\Http\Requests\AdminRequests\ProductTypeRequest;
use App\Http\Requests\EventTypeRequest;
use App\Http\Resources\AdminResources\EventResource;
use App\Http\Resources\AdminResources\ProductTypeResource;
use App\Http\Resources\EventTypeResource;
use App\Models\Event;
use App\Models\EventType;
use App\Models\ProductType;
use Illuminate\Http\Request;

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
                $path = $image->store(
                    'event-images',
                    'do'
                );
                $imagePaths[] = $path;
            }
        }
        
        if ($request->hasFile('e_videos')) {
            foreach ($request->file('e_videos') as $video) {
                $path = $video->store(
                    'event-videos',
                    'do'
                );
                $videPath[] = $path;
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

    public function createEventType(EventTypeRequest $request)
    {
        $data = $request->validated();

        $new_event_type = EventType::create($data);

        return response()->json(new EventTypeResource($new_event_type));
    }
}
