<?php

namespace App\Http\Controllers;

use App\Http\Resources\TouristResources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $event = $request->input('search');

        $query = Event::with([
            'user',
            'attendees',
            'eventType'
        ]);

        if ($event) {
            $query->where('e_name', $event);
        }

        $events = $query->paginate(10);

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
        $data = Event::where('event_type_id', $event)->get();

        return EventResource::collection($data);
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

    public function comment(Request $request, Event $event)
    {
        $user = Auth::user();

        $existComment = $event->attendees()->where('user_id', $user->id)->first();
        if ($existComment) {
            $existComment->pivot->ue_comment = $request->comment;
            $existComment->pivot->save();
        } else {
            $event->attendees()->attach($user->id, [
                'ue_comment' => $request->comment
            ]);
        }

        return response()->json(['message' => 'تم إضافة المراجعة'], 200);
    }

    public function rate(Request $request, Event $event)
    {
        $user = Auth::user();

        $exstingRate = $event->attendees()->where('user_id', $user->id)->first();
        if ($exstingRate) {
            $exstingRate->pivot->ue_rate = $request->rate;
            $exstingRate->pivot->save();
        } else {
            $event->attendees()->attach($user->id, [
                'ue_rate' => $request->rate
            ]);
        }

        return response()->json(['message' => 'تم إضافة التقييم'], 200);
    }
}
