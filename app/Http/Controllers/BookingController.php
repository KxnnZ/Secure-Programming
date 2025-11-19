<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $bookings = Booking::with(['seats', 'showtime.movie', 'showtime.theater'])
            ->where('user_id', $userId)
            ->orderByDesc('booked_at')
            ->paginate(12);

        return view('bookings.index', compact('bookings'));
    }
}
