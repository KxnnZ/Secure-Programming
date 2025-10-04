@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Tambah Film Baru</h2>
  <form method="POST" action="{{ route('admin.movies.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
      <label>Judul</label>
      <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Sinopsis</label>
      <textarea name="synopsis" class="form-control" rows="3"></textarea>
    </div>

    <div class="mb-3">
      <label>Tanggal Rilis</label>
      <input type="date" name="release_date" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Tanggal Selesai (opsional)</label>
      <input type="date" name="end_date" class="form-control">
    </div>

    <div class="mb-3">
      <label>Poster</label>
      <input type="file" name="poster" class="form-control" accept="image/*">
    </div>
    
    <div class="mb-3">
        <label>Durasi (menit)</label>
        <input type="number" name="duration" class="form-control" min="1" max="600" required>
    </div>


    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">Batal</a>
  </form>
</div>
@endsection
