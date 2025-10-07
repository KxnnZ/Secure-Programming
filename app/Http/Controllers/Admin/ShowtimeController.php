<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Showtime, Movie, Theater, Booking};
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ShowtimeController extends Controller
{
    public function index()
    {
        $showtimes = Showtime::with(['movie','theater'])
            ->orderByDesc('start_at')->paginate(20);

        $movies   = Movie::orderBy('title')->get(['id','title']);
        $theaters = Theater::orderBy('name')->get(['id','name']);

        return view('admin.showtimes.index', compact('showtimes','movies','theaters'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'movie_id'   => ['required','exists:movies,id'],
            'theater_id' => ['required','exists:theaters,id'],
            'start_at'   => ['required','date','after:now'],
            'price'      => ['required','integer','min:0'],
        ]);

       
        $data['start_at'] = Carbon::parse($data['start_at'], config('app.timezone','Asia/Jakarta'));

        Showtime::create($data);

        return back()->with('success','Showtime berhasil ditambahkan.');
    }

    public function destroy(Showtime $showtime)
    {
        if ($showtime->bookings()->exists()) {
            return back()->with('error','Tidak bisa menghapus: showtime sudah punya booking.');
        }
        $showtime->delete();
        return back()->with('success','Showtime dihapus.');
    }
}
