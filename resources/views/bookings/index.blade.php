@extends('layouts.app')
@section('content')
<div class="container">
  <h2 class="mb-3">Riwayat Pesanan</h2>

  @if($bookings->isEmpty())
    <div class="alert alert-info">Belum ada pesanan.</div>
  @else
    <div class="table-responsive">
      <table class="table table-dark table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>Film / Showtime</th>
            <th>Teater</th>
            <th>Kursi</th>
            <th>Total</th>
            <th>Status</th>
            <th>Waktu</th>
          </tr>
        </thead>
        <tbody>
          @foreach($bookings as $b)
            <tr>
              <td>{{ $b->id }}</td>
              <td>
                @if($b->showtime && $b->showtime->movie)
                  <strong>{{ $b->showtime->movie->title }}</strong><br>
                  <small>{{ $b->showtime->start_at?->format('d M Y H:i') }}</small>
                @else
                  -
                @endif
              </td>
              <td>{{ $b->showtime->theater->name ?? '-' }}</td>
              <td>
                @if($b->seats->isNotEmpty())
                  {{ $b->seats->pluck('seat_id')->join(', ') }}
                @else
                  -
                @endif
              </td>
              <td>Rp {{ number_format($b->total_price,0,',','.') }}</td>
              <td>{{ ucfirst($b->status) }}</td>
              <td>{{ $b->booked_at?->format('d M Y H:i') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{ $bookings->links() }}
  @endif
</div>
@endsection
