@extends('layouts.app')

@section('content')
<div class="container">
  <h2 class="mb-3">{{ $movie->title }}</h2>

  @forelse ($showtimes as $s)
    <div class="card mb-2">
      <div class="card-body d-flex justify-content-between align-items-center">
        <div>
          <div><strong>{{ $s->theater->name ?? 'Theater' }}</strong></div>
          <small>{{ $s->start_at->format('d M Y H:i') }}</small>
          <div>Rp {{ number_format($s->price, 0, ',', '.') }}</div>
        </div>
        <a href="{{ route('seats.index', $s) }}" class="btn btn-primary">
          Pilih Kursi
        </a>
      </div>
    </div>
  @empty
    <p>Belum ada showtime untuk film ini.</p>
  @endforelse
</div>
@endsection
