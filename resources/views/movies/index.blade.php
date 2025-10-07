@extends('layouts.app')

@section('content')
<div class="container py-4">

  <h1 class="mb-4">Now Showing</h1>
  @if($now->count())
    <div class="d-flex flex-wrap gap-3">
      @foreach($now as $m)
        <div class="text-center" style="width:160px">
          <img src="{{ $m->poster_url }}" alt="{{ $m->title }}"
               style="width:160px;height:240px;object-fit:cover;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.2)">
          <div class="mt-2 fw-semibold">{{ $m->title }}</div>
          @if($m->end_date)<small class="text-muted">s.d. {{ $m->end_date->format('d M Y') }}</small>@endif
        </div>
      @endforeach
    </div>
  @else
    <p class="text-muted">No movies are currently playing</p>
  @endif

  <h1 class="mt-5 mb-4">Coming Soon</h1>
  @if($upcom->count())
    <div class="d-flex flex-wrap gap-3">
      @foreach($upcom as $m)
        <div class="text-center" style="width:160px">
          <img src="{{ $m->poster_url }}" alt="{{ $m->title }}"
               style="width:160px;height:240px;object-fit:cover;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.2)">
          <div class="mt-2 fw-semibold">{{ $m->title }}</div>
          <small class="text-muted">Rilis {{ $m->release_date->format('d M Y') }}</small>
        </div>
      @endforeach
    </div>
  @else
    <p class="text-muted">No release date</p>
  @endif

</div>
@endsection
