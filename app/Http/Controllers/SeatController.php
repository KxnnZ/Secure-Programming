<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Showtime;
use App\Models\Seat;
use App\Models\Booking;
use App\Models\BookingSeat;
use Illuminate\Support\Facades\DB;

class SeatController extends Controller
{
    public function index(Showtime $showtime)
    {
        $theater = $showtime->theater;
        $seats = Seat::where('theater_id', $theater->id)->get(['id','code','row','col','type']);
        return view('showtimes.seats', compact('showtime','theater','seats'));
    }

    public function availability(Showtime $showtime)
    {
        $bookedIds = BookingSeat::where('showtime_id',$showtime->id)->pluck('seat_id');
        return response()->json(['booked' => $bookedIds]);
    }

    public function book(Request $req, Showtime $showtime)
    {
        $seatIds = collect(json_decode($req->input('seat_ids','[]'), true))->map('intval')->unique();
        if ($seatIds->isEmpty()) return back()->with('error','Choose atleast 1 seat');

        try {
            DB::transaction(function() use ($seatIds, $showtime, $req) {
                $already = BookingSeat::where('showtime_id',$showtime->id)
                    ->whereIn('seat_id',$seatIds)->lockForUpdate()->exists();
                if ($already) throw new \Exception('Some seat are just taken.');

                $booking = Booking::create([
                    'user_id' => optional($req->user())->id,
                    'showtime_id' => $showtime->id,
                    'status' => 'pending',
                    'booked_at' => now(),
                ]);

                foreach ($seatIds as $sid) {
                    BookingSeat::create([
                        'booking_id' => $booking->id,
                        'seat_id' => $sid,
                        'showtime_id' => $showtime->id,
                    ]);
                }

                $booking->update(['total_price' => $seatIds->count() * $showtime->price]);
            });
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()->route('seats.index', $showtime)->with('success','Seat are selected. Continue to payment.');
    }
}
