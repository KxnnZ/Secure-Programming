<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Showtime;

class MovieController extends Controller
{
    public function index()
    {
        
        $now = Movie::nowShowing()->orderBy('title')->get();
        $upcom = Movie::upcoming()->orderBy('release_date')->get();

        $featured = Movie::nowShowing()->inRandomOrder()->limit(2)->get();

        return view('movies.index', compact('now','upcom','featured'));
    }

    public function show(Movie $movie)
    {
        $showtimes = Showtime::with('theater')
            ->where('movie_id', $movie->id)
            ->where('start_at', '>=', now())
            ->orderBy('start_at')
            ->get();

        if ($showtimes->count() === 1) {
            return redirect()->route('seats.index', $showtimes->first());
        }

        return view('movies.show', compact('movie','showtimes'));
    }
}
