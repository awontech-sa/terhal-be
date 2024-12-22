<?php

namespace App\Http\Controllers;

use App\Http\Resources\TouristResources\TourResource;
use App\Models\Tour;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $date = $request->input('date');
        $query = Tour::with([
            'user',
            'places.placeType',
            'participants'
        ])->paginate(10);

        // if ($date) {
        //     $query->whereDate('t_date', $date);
        // } else {
        //     // Show only future tours
        //     // $query->whereDate('t_date', '>', Carbon::now());
        // }

        // $data = $query->get();

        return TourResource::collection($query);
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
    public function show()
    {
        $data = Tour::where('t_rate', 5)->select('t_name', 't_image', 't_date')->get();

        return $data;
    }

    public function date(string $date)
    {
        $data = Tour::where('t_date', $date)->get();

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tour $tour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tour $tour)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tour $tour)
    {
        //
    }

    public function tour(int $id)
    {
        $tour = Tour::where('id', $id)->select('t_image', 't_videos', 't_name', 't_duration', 't_price', 't_description', )->get();

        return $tour;
    }
}
