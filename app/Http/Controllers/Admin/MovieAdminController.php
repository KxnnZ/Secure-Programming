<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;

class MovieAdminController extends Controller
{
    /** 
     * Tampilkan daftar semua film
     */
    public function index()
    {
        $movies = Movie::latest()->paginate(10);
        return view('admin.movies.index', compact('movies'));
    }

    /**
     * Form tambah film baru
     */
    public function create()
    {
        return view('admin.movies.create');
    }

    /**
     * Simpan film baru ke database
     */
    public function store(Request $request)
    {
        // store()
        $data = $request->validate([
        'title'        => 'required|string|max:255',
        'synopsis'     => 'nullable|string',
        'release_date' => 'required|date',
        'end_date'     => 'nullable|date|after_or_equal:release_date',
        'duration'     => 'required|integer|min:1|max:600', // menit
        'poster'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('poster')) {
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        Movie::create($data);

        return redirect()->route('admin.movies.index')->with('success', 'Film berhasil ditambahkan.');
    }

    //form edit film
    public function edit(Movie $movie)
    {
        return view('admin.movies.edit', compact('movie'));
    }

    //update film
    public function update(Request $request, Movie $movie)
    {
        

        // update()
        $data = $request->validate([
        'title'        => 'required|string|max:255',
        'synopsis'     => 'nullable|string',
        'release_date' => 'required|date',
        'end_date'     => 'nullable|date|after_or_equal:release_date',
        'duration'     => 'required|integer|min:1|max:600',
        'poster'       => 'nullable|image|max:2048',
        ]);


        if ($request->hasFile('poster')) {
            if ($movie->poster_path) {
                Storage::disk('public')->delete($movie->poster_path);
            }
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        $movie->update($data);

        return redirect()->route('admin.movies.index')->with('success', 'Film berhasil diperbarui.');
    }

    // hapus film
    public function destroy(Movie $movie)
    {
        if ($movie->poster_path) {
            Storage::disk('public')->delete($movie->poster_path);
        }

        $movie->delete();

        return redirect()->route('admin.movies.index')->with('success', 'Film berhasil dihapus.');
    }
}
