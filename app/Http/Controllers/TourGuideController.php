<?php

namespace App\Http\Controllers;

use App\Http\Requests\TourGuideRequests\TourRequest;
use App\Http\Resources\TourGuideResources\TourResource;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TourGuideController extends Controller
{
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create(TourRequest $request)
    {
        $data = $request->validated();
        
        $imagePaths = [];
        $videPath = [];
        $places = [];

        error_log($request->user_id);

        if ($request->hasFile('t_image')) {
            foreach ($request->file('t_image') as $image) {
                $path = $image->store(
                    'tours-image',
                    'do'
                );
                $imagePaths[] = $path;
            }
        }

        if ($request->hasFile('t_videos')) {
            foreach ($request->file('t_videos') as $video) {
                $path = $video->store(
                    'tours-video',
                    'do'
                );
                $videPath[] = $path;
            }
        }

        if ($request->has('t_places')) {
            $places[] = $request->input('t_places');
        }


        $data['t_image'] = json_encode($imagePaths);
        $data['t_videos'] = json_encode($videPath);
        $data['t_places'] = json_encode($places);

        $new_tour = Tour::create($data);

        return response()->json(new TourResource($new_tour));
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
}
