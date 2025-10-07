@extends('layouts.app')
@section('content')
<style>
  .seat-btn{padding:.35rem .5rem;border:1px solid #888;border-radius:6px;background:#fff;cursor:pointer;font-size:.9rem}
  .seat-btn.booked{background:#f8d7da;border-color:#dc3545;color:#842029;cursor:not-allowed}
  .seat-btn.selected{background:#d1e7dd;border-color:#198754;color:#0f5132}
  .legend{display:inline-block;padding:.2rem .5rem;margin-right:.5rem;border-radius:4px;border:1px solid #aaa;font-size:.85rem}
  .legend.kosong{background:#fff}
  .legend.pilih{background:#d1e7dd}
  .legend.terisi{background:#f8d7da}
  #screen{background:#222;color:#fff;border-radius:6px}
</style>

<div class="container">
  <h2 class="mb-3">Pilih Kursi — {{ $showtime->start_at->format('d M Y H:i') }}</h2>

  <div class="mb-2">
    <span class="legend kosong">Kosong</span>
    <span class="legend pilih">Dipilih</span>
    <span class="legend terisi">Terisi</span>
  </div>
  <div id="screen" class="mb-3 py-2 text-center">LAYAR</div>

  {{-- Grid A–G x 18 --}}
  <div id="seat-grid" style="display:grid;row-gap:.5rem;">
    @for($r=1; $r<=7; $r++)
      <div style="display:flex;justify-content:center;gap:.4rem;">
        @for($c=1; $c<=18; $c++)
          @php $seat = $seats->firstWhere(fn($s)=>$s->row==$r && $s->col==$c); @endphp
          @if($seat)
            <button type="button" class="seat-btn"
                    data-seat-id="{{ $seat->id }}"
                    data-seat-code="{{ $seat->code }}">
              {{ $seat->code }}
            </button>
          @else
            <span style="width:36px;height:30px;display:inline-block;"></span>
          @endif
        @endfor
      </div>
    @endfor
  </div>

  <form id="book-form" method="POST" action="{{ route('seats.book',$showtime) }}" class="mt-3">
    @csrf
    <input type="hidden" name="seat_ids" id="seat_ids">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:1rem;">
      <div>
        <strong>Dipilih:</strong> <span id="chosen"></span><br>
        <strong>Total:</strong> Rp <span id="total">0</span>
      </div>
      <button class="seat-btn" style="border-color:#0d6efd;color:#0d6efd">Checkout</button>
    </div>
  </form>

  @if(session('error'))<div class="alert alert-danger mt-3">{{ session('error') }}</div>@endif
  @if(session('success'))<div class="alert alert-success mt-3">{{ session('success') }}</div>@endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const price  = {{ (int)$showtime->price }};
  const grid   = document.getElementById('seat-grid');
  if (!grid) { console.warn('seat-grid not found'); return; }

  const chosen = new Set();

  function updateSummary(){
    const codes = Array.from(document.querySelectorAll('.seat-btn'))
      .filter(b => chosen.has(+b.dataset.seatId))
      .map(b => b.dataset.seatCode);
    document.getElementById('chosen').textContent = codes.join(', ');
    document.getElementById('total').textContent  = (codes.length * price).toLocaleString('id-ID');
    document.getElementById('seat_ids').value     = JSON.stringify(Array.from(chosen));
  }

  async function refreshAvailability(){
    try{
      const res  = await fetch("{{ route('seats.availability',$showtime) }}");
      if(!res.ok) throw new Error('HTTP '+res.status);
      const data = await res.json();
      const booked = new Set(data.booked || []);
      document.querySelectorAll('.seat-btn').forEach(btn=>{
        const id = +btn.dataset.seatId;
        btn.classList.remove('booked','selected');
        btn.disabled = false;
        if (booked.has(id)) { btn.classList.add('booked'); btn.disabled = true; }
        else if (chosen.has(id)) { btn.classList.add('selected'); }
      });
    }catch(e){ console.error('Availability error:', e); }
  }

  grid.addEventListener('click', (e)=>{
    const btn = e.target.closest('.seat-btn');
    if(!btn || btn.disabled) return;
    const id = +btn.dataset.seatId;
    if (chosen.has(id)) chosen.delete(id); else chosen.add(id);
    updateSummary(); refreshAvailability();
  });

  refreshAvailability();
  setInterval(refreshAvailability, 3000);
  updateSummary();
});
</script>
@endpush

