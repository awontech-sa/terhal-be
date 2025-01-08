<?php

namespace App\Http\Controllers;

use App\Http\Resources\TouristResources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with([
            'user',
            'attendees',
            'eventType',
        ])
        ->paginate(10);

        return EventResource::collection($events);
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
    public function show(int $event)
    {
        $data = Event::where('event_type_id', $event)->select('e_images', 'e_videos', 'e_name', 'e_location', 'e_price', 'e_duration', 'e_description')->get();

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}