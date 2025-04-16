<?php

namespace App\Http\Controllers;

use App\Http\Requests\TouristRequests\BookingRequest;
use App\Http\Resources\TouristResources\TourResource;
use App\Http\Resources\TouristResources\UserTourResource;
use App\Models\Tour;
use App\Models\UserTour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the date from the request
        $date = $request->input('date');

        // Build the query with eager loading
        $query = Tour::with([
            'user',
            'participants'
        ]);

        // Apply filter if date exists
        if ($date) {
            $query->whereDate('t_date', $date);
        } else {
            // Show only future tours
            // $query->whereDate('t_date', '>', Carbon::now());
        }

        // paginate
        $data = $query->paginate(10);

        // Return the data as a resource
        return TourResource::collection($data);
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Tour $tour, int $id)
    {
        $existTour = $tour->participants()->where('user_id', $id)->first();

        if ($existTour) {
            $tour->participants()->updateExistingPivot($id, [
                'ut_status' => $request->status,
            ]);
        }
        return response()->json(['message' => 'تم تحديث حالة الجولة'], 200);
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

    public function tour(Tour $tour)
    {
        // tour with participants
        $tour = Tour::with([
            'participants'
        ])->find($tour->id);

        return new TourResource($tour);
    }

    public function booking(BookingRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();

        try {
            $tour = Tour::findOrFail($validated['tour_id']);

            $existingBookings = UserTour::where('tour_id', $validated['tour_id'])->sum('ut_count');

            $remainingCapacity = $tour->visitor_limit - $existingBookings;
            if ($validated['ut_count'] > $remainingCapacity) {
                return response()->json([
                    'success' => false,
                    'message' => 'The tour is fully booked or the requested spots exceed available capacity.',
                    'remaining_capacity' => $remainingCapacity,
                ], 400);
            }

            $totalPrice = $tour->t_price * $validated['ut_count'];

            $userTour = UserTour::create([
                'tour_id' => $validated['tour_id'],
                'user_id' => $user->id,
                'ut_count' => $validated['ut_count'],
                'ut_total_price' => $totalPrice,
                'ut_comment' => $validated['ut_comment'] ?? '',
                'ut_rate' => $validated['ut_rate'] ?? 0,
                'ut_status' => 'تم الحجز',
                'ut_uuid' => uniqid(),
            ]);

            return response()->json([
                'message' => 'Tour booked successfully.',
                'data' => new UserTourResource($userTour),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to book the tour.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function bookingShow($id)
    {
        // Get the authenticated user from the Bearer token
        $user = Auth::user();

        try {
            // Fetch the booking
            $booking = UserTour::where('id', $id)
                ->where('user_id', $user->id)
                ->first();

            // If the booking does not exist or does not belong to the user, return an error
            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found or unauthorized access.',
                ], 404);
            }

            return response()->json([
                'message' => 'Booking details retrieved successfully.',
                'data' => new UserTourResource($booking),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve booking details.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function userBooking()
    {
        try {
            $user = Auth::user();

            $booking = UserTour::where('user_id', $user->id)->with('tour')->paginate(10);
            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found or unauthorized access.',
                ], 404);
            }

            return response()->json([
                'message' => 'Booking details retrieved successfully.',
                'data' => new UserTourResource($booking),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve booking details.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function rate(Request $request, Tour $tour)
    {
        $user = Auth::user();

        $exstingRate = $tour->participants()->where('user_id', $user->id)->first();

        if ($exstingRate) {
            $exstingRate->pivot->ut_rate = $request->rate;
            $exstingRate->pivot->save();
        } else {
            $tour->participants()->attach($user->id, [
                'ut_rate' => $request->rate
            ]);
        }

        return response()->json(['message' => 'تم إضافة التقييم'], 200);
    }

    public function comment(Request $request, Tour $tour)
    {
        $user = Auth::user();

        $existComment = $tour->participants()->where('user_id', $user->id)->first();

        if ($existComment) {
            $existComment->pivot->ut_comment = $request->comment;
            $existComment->pivot->save();
        } else {
            $tour->participants()->attach($user->id, [
                'ut_comment' => $request->comment
            ]);
        }

        return response()->json(['message' => 'تم إضافة التعليق'], 200);
    }

    public function cancel($id)
    {
        $user = Auth::user();

        $booking = UserTour::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        // check if a day has passed since the booking
        if ($booking->created_at->diffInDays(now()) > 1) {
            return response()->json([
                'message' => 'لا يمكن إلغاء الحجز بعد مرور يوم',
            ], 400);
        }

        $booking->ut_status = 2;
        $booking->save();

        return response()->json([
            'message' => 'تم إلغاء الحجز بنجاح',
        ], 200);
    }

    public function favorite(Request $request, Tour $tour)
    {
        $user = Auth::user();

        $exstingFavorite = $tour->participants()->where('user_id', $user->id)->first();
        if ($exstingFavorite) {
            $exstingFavorite->pivot->is_favorite = $request->favorite;
            $exstingFavorite->pivot->ut_comment = $request->ut_comment;
            $exstingFavorite->pivot->save();
        } else {
            $tour->participants()->attach($user->id, [
                'is_favorite' => $request->favorite,
                'ut_comment' => $request->ut_comment
            ]);
        }

        return response()->json(['message' => 'تم إضافته إلى المفضلة'], 200);
    }
}
