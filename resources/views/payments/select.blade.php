@extends('layouts.app')

@section('content')
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-12 col-md-6">
      <div class="card">
        <div class="card-body">
          <h3 class="card-title">Pilih Metode Pembayaran</h3>
          <p class="text-muted">Booking ID: {{ $booking->id }} — Total: Rp {{ number_format($booking->total_price ?? 0,0,',','.') }}</p>

          <form method="POST" action="{{ route('payments.process', $booking) }}">
            @csrf
            <div class="mb-3">
              <button type="submit" name="method" value="qris" class="btn btn-primary w-100 mb-2">QRIS</button>
              <button type="submit" name="method" value="debit" class="btn btn-outline-primary w-100">Debit Card</button>
            </div>
          </form>

          <p class="small text-muted">(Ini placeholder — metode pembayaran tidak terintegrasi.)</p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
