@extends('layouts.app')

@section('content')
<div class="container">
  <h2>🎬 Daftar Film</h2>
  <a href="{{ route('admin.movies.create') }}" class="btn btn-primary mb-3">+ Tambah Film</a>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Poster</th>
        <th>Judul</th>
        <th>Tanggal Rilis</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($movies as $movie)
      <tr>
        <td><img src="{{ $movie->poster_url }}" style="width:80px; border-radius:5px"></td>
        <td>{{ $movie->title }}</td>
        <td>{{ $movie->release_date->format('d M Y') }}</td>
        <td>
           <a href="{{ route('admin.showtimes.index', ['movie_id' => $movie->id]) }}#add-form"
              class="btn btn-sm btn-primary me-1">Showtimes</a>
          <a href="{{ route('admin.movies.edit', $movie) }}" class="btn btn-sm btn-warning">Edit</a>
          <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" style="display:inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
          </form>
        </td>
      </tr>
      @empty
      <tr><td colspan="4" class="text-center">Belum ada film</td></tr>
      @endforelse
    </tbody>
  </table>

  {{ $movies->links() }}
</div>
@endsection
