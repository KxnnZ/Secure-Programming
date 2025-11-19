@extends('layouts.app')
  @push('styles')
  <style>
    /* Movies page minor polish */
    .featured-card{max-width:100%;width:100%;border-radius:10px;overflow:hidden;transition:transform .18s ease,box-shadow .18s ease;cursor:pointer;display:flex;flex-direction:column;height:100%}
    .featured-card:hover{transform:translateY(-8px);box-shadow:0 28px 60px rgba(0,0,0,.6)}
    .featured-card .card-img-top{height:420px;object-fit:cover;display:block;width:100%}
    .featured-card .card-body{padding:.75rem .75rem;flex:0 0 auto;margin-top:auto}
    .featured-card .card-body .featured-badge{display:inline-block;background:rgba(13,110,253,0.95);color:#fff;padding:.18rem .45rem;border-radius:6px;font-size:.75rem;font-weight:600;margin-bottom:.4rem}
    .featured-card .card-body .featured-title{font-weight:700;font-size:0.95rem;margin-top:0.15rem}
    .featured-card .card-body .featured-sub{font-size:0.78rem;color:rgba(255,255,255,0.85);margin-top:0.25rem}
    .featured-card .card-body .featured-excerpt{font-size:0.88rem;color:rgba(255,255,255,0.92);margin-top:.5rem;line-height:1.2rem;max-height:5.0rem;overflow:hidden;display:-webkit-box;-webkit-line-clamp:4;-webkit-box-orient:vertical;text-overflow:ellipsis}

    .movies-grid .poster-card{display:inline-block;text-align:center}
    .poster-img{width:180px;height:270px;object-fit:cover;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.2);display:block;margin:0 auto;transition:transform .18s ease,box-shadow .18s ease,border-color .18s ease}
    /* subtle default border to separate posters from background */
    .poster-img{border:1px solid rgba(255,255,255,0.04)}
    .poster-card .fw-semibold{max-width:160px;display:block;white-space:normal}

    /* Hover effect for posters */
    .poster-card:hover .poster-img{transform:translateY(-6px) scale(1.03);box-shadow:0 8px 24px rgba(0,0,0,.45);border:2px solid rgba(13,110,253,0.9);border-radius:12px}

    /* Featured card overlay to make text readable */
    .featured-card{position:relative}
    .featured-card .card-body{background:linear-gradient(180deg, rgba(0,0,0,0) 20%, rgba(0,0,0,0.85) 100%);color:#fff}
    .featured-card .card-title{color:#ddd}

    /* Slightly tighter grid spacing for polish */
    .movies-grid{gap:18px}

    /* ensure asides don't push content on small width and make side banners full-height */
    @media(min-width:768px){
      aside.col-md-2.aside-left, aside.col-md-2.aside-right{padding-left:.75rem;padding-right:.75rem;max-width:220px;height:100vh;padding-top:0;padding-bottom:0;align-items:stretch;position:sticky;top:0;overflow:auto;background:linear-gradient(180deg, rgba(13,110,253,0.04), rgba(0,0,0,0.16))}
      main.col-md-8{flex:1 1 auto;padding-left:.75rem;padding-right:.75rem;border-left:1px solid rgba(255,255,255,0.03);border-right:1px solid rgba(255,255,255,0.03)}
      /* Now Showing: responsive grid that fits posters neatly and is centered between borders */
      .movies-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:22px;align-items:start;justify-items:center;max-width:1200px;margin:0 auto}
      .movies-grid .poster-card{max-width:180px;width:100%;direction:ltr}
      .movies-grid .poster-img{width:100%;height:270px}
    }
  </style>
  @endpush
@section('content')
<div class="container py-4">

  <div class="row align-items-start">
    <aside class="col-md-2 aside-left d-none d-md-flex justify-content-center align-items-start">
      @if(!empty($featured[0]))
        @php $f = $featured[0]; @endphp
        <a href="{{ route('movies.show',$f) }}" class="text-decoration-none">
          <div class="card featured-card bg-black text-light mb-3">
            <img src="{{ $f->poster_url }}" class="card-img-top" alt="{{ $f->title }}">
            <div class="card-body p-2">
              <span class="featured-badge">Featured</span>
              <div class="featured-title">{{ $f->title }}</div>
              @if(!empty($f->synopsis))
                <div class="featured-excerpt">{{ \Illuminate\Support\Str::limit($f->synopsis, 350) }}</div>
              @endif
              @if($f->end_date)
                <div class="featured-sub">s.d. {{ $f->end_date->format('d M Y') }}</div>
              @endif
              <div class="mt-2"><span class="btn btn-sm btn-primary">Lihat</span></div>
            </div>
          </div>
        </a>
      @endif
    </aside>

    <main class="col-12 col-md-8 px-md-3">
      <h1 class="mb-4">Now Showing</h1>
      @if($now->count())
        <div class="movies-grid gap-3">
          @foreach($now as $m)
           <a href="{{ route('movies.show', $m) }}" class="text-decoration-none poster-card" style="color:inherit">
            <div class="text-center">
              <img src="{{ $m->poster_url }}" alt="{{ $m->title }}" class="poster-img">
              <div class="mt-2 fw-semibold">{{ $m->title }}</div>
              @if($m->end_date)
                <small class="text-muted">s.d. {{ $m->end_date->format('d M Y') }}</small>
              @endif
            </div>
           </a>
          @endforeach
        </div>
      @else
        <p class="text-muted">No movies are currently playing</p>
      @endif

      <h1 class="mt-5 mb-4">Coming Soon</h1>
      @if($upcom->count())
        <div class="movies-grid gap-3">
          @foreach($upcom as $m)
            <div class="text-center poster-card">
              <img src="{{ $m->poster_url }}" alt="{{ $m->title }}" class="poster-img">
              <div class="mt-2 fw-semibold">{{ $m->title }}</div>
              <small class="text-muted">Rilis {{ $m->release_date->format('d M Y') }}</small>
            </div>
          @endforeach
        </div>
      @else
        <p class="text-muted">No release date</p>
      @endif
    </main>

    <aside class="col-md-2 aside-right d-none d-md-flex justify-content-center align-items-start">
      @if(!empty($featured[1]))
        @php $f = $featured[1]; @endphp
        <a href="{{ route('movies.show',$f) }}" class="text-decoration-none">
          <div class="card featured-card bg-black text-light mb-3">
            <img src="{{ $f->poster_url }}" class="card-img-top" alt="{{ $f->title }}">
            <div class="card-body p-2">
              <span class="featured-badge">Featured</span>
              <div class="featured-title">{{ $f->title }}</div>
              @if(!empty($f->synopsis))
                <div class="featured-excerpt">{{ \Illuminate\Support\Str::limit($f->synopsis, 350) }}</div>
              @endif
              @if($f->end_date)
                <div class="featured-sub">s.d. {{ $f->end_date->format('d M Y') }}</div>
              @endif
              <div class="mt-2"><span class="btn btn-sm btn-primary">Lihat</span></div>
            </div>
          </div>
        </a>
      @endif
    </aside>
  </div>

</div>
  
@endsection
