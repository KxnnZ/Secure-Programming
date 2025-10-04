@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Edit Film</h2>
  <form method="POST" action="{{ route('admin.movies.update', $movie) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label>Judul</label>
      <input type="text" name="title" class="form-control" value="{{ $movie->title }}" required>
    </div>

    <div class="mb-3">
      <label>Sinopsis</label>
      <textarea name="synopsis" class="form-control" rows="3">{{ $movie->synopsis }}</textarea>
    </div>

    <div class="mb-3">
      <label>Tanggal Rilis</label>
      <input type="date" name="release_date" class="form-control" value="{{ $movie->release_date->format('Y-m-d') }}" required>
    </div>

    <div class="mb-3">
      <label>Tanggal Selesai (opsional)</label>
      <input type="date" name="end_date" class="form-control" value="{{ optional($movie->end_date)->format('Y-m-d') }}">
    </div>

    <div class="mb-3">
      <label>Poster</label>
      <input type="file" name="poster" class="form-control" accept="image/*">
      <small class="text-muted">Kosongkan jika tidak ingin mengganti poster.</small>
      <div class="mt-2">
        <img src="{{ $movie->poster_url }}" style="width:120px; border-radius:8px">
      </div>
    </div>

    <div class="mb-3">
      <label>Durasi (menit)</label>
      <input type="number" name="duration" class="form-control" min="1" max="600" value="{{ $movie->duration }}" required>
    </div>


    <button class="btn btn-primary">Update</button>
    <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">Kembali</a>
  </form>
</div>
@endsection
