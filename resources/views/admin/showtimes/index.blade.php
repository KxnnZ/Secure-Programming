@extends('layouts.app')

@section('content')
<div class="container">
  <h2 class="mb-3">Manage Showtimes</h2>

  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
  @if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div>   @endif
  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
  @endif

  {{-- Form Tambah --}}
  <div class="card mb-4">
    <div class="card-body">
      <form method="POST" action="{{ route('admin.showtimes.store') }}" class="row g-3">
        @csrf
        <div class="col-md-4">
          <label class="form-label">Movie</label>
          <select name="movie_id" class="form-select" required>
            <option value="">-- Pilih Film --</option>
            @foreach($movies as $m)
              <option value="{{ $m->id }}">{{ $m->title }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label">Theater</label>
          <select name="theater_id" class="form-select" required>
            <option value="">-- Pilih Theater --</option>
            @foreach($theaters as $t)
              <option value="{{ $t->id }}">{{ $t->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label">Start at</label>
          <input type="datetime-local" name="start_at" class="form-control" required>
        </div>

        <div class="col-md-2">
          <label class="form-label">Price</label>
          <input type="number" name="price" min="0" class="form-control" placeholder="50000" required>
        </div>

        <div class="col-12">
          <button class="btn btn-primary">Add showtime</button>
        </div>
      </form>
    </div>
  </div>

  {{-- Tabel Data --}}
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Movie</th>
              <th>Theater</th>
              <th>Start</th>
              <th>Price</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          @forelse($showtimes as $s)
            <tr>
              <td>{{ $s->id }}</td>
              <td>{{ $s->movie->title ?? '-' }}</td>
              <td>{{ $s->theater->name ?? '-' }}</td>
              <td>{{ $s->start_at ? $s->start_at->format('d M Y H:i') : '-' }}</td>
              <td>Rp {{ number_format($s->price,0,',','.') }}</td>
              <td class="text-end">
                <a class="btn btn-sm btn-outline-primary"
                    href="{{ route('seats.index', $s) }}">
                    Select seat
                </a>
                <form method="POST" action="{{ route('admin.showtimes.destroy',$s) }}"
                      onsubmit="return confirm('Hapus showtime ini?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="6" class="text-center">no showtime yet</td></tr>
          @endforelse
          </tbody>
        </table>
      </div>

      {{ $showtimes->links() }}
    </div>
  </div>
</div>
@endsection
