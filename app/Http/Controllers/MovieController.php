<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Showtime;

class MovieController extends Controller
{
    public function index()
    {
        // "Now Showing": sudah rilis (release_date <= today) dan belum berakhir (end_date null atau >= today)
        $today = now()->startOfDay();

        $now = Movie::query()
            ->when(true, function ($q) use ($today) {
                $q->where(function($q) use ($today) {
                    $q->whereNull('release_date')->orWhereDate('release_date', '<=', $today);
                })->where(function($q) use ($today) {
                    $q->whereNull('end_date')->orWhereDate('end_date', '>=', $today);
                });
            })
            ->orderBy('title')
            ->get();

        // "Coming Soon": rilis di masa depan
        $upcom = Movie::query()
            ->whereNotNull('release_date')
            ->whereDate('release_date', '>', $today)
            ->orderBy('release_date')
            ->get();

        return view('movies.index', compact('now','upcom'));
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
