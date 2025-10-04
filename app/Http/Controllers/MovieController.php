<?php

namespace App\Http\Controllers;

use App\Models\Movie;

class MovieController extends Controller
{
    public function index()
    {
        $now   = Movie::nowShowing()->orderBy('release_date','desc')->get();
        $upcom = Movie::upcoming()->orderBy('release_date')->get();

        return view('movies.index', compact('now','upcom'));
    }
}
