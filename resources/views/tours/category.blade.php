@extends('layouts.app')

@section('title', $category->name . ' | Solvive Travel')

@section('content')
  <section class="page-hero" style="background-image: linear-gradient(180deg, rgb(0 0 0 / 45%), rgb(0 0 0 / 65%)), url('{{ asset('assets/images/hero_landscape_hq.jpg') }}'); background-repeat: no-repeat; background-size: cover; background-position: center;">
    <div class="wrap">
      <div class="crumbs"><a href="{{ url('/') }}">Home</a> / {{ $category->name }}</div>
      <div class="eyebrow on-dark">Luxury {{ $category->name }}</div>
      <h1>{{ $category->name == 'Small Group Tours' ? 'Guaranteed departures. Never a crowd.' : 'Your itinerary. Your pace. Your people.' }}</h1>
      <p class="lede" style="max-width:58ch;">{{ $category->description ?? 'Discover our carefully curated luxury journeys through Southeast Asia.' }}</p>
    </div>
  </section>

  <section class="section">
    <div class="wrap">
      <div class="grid journey-grid">

        @foreach($tours as $tour)
        @php 
            $badgeColor = $tour->badge_color ?: 'var(--brand, #c99355)';
            $borderColor = '#00877C';
        @endphp
        <article class="card reveal" style="position:relative; {{ ($tour->featured_badge || $tour->banner_text) ? 'border: 3px solid ' . $borderColor . ';' : '' }}">
          @if($tour->featured_badge)
          <div style="position:absolute; top:15px; right:15px; background:{{ $badgeColor }}; color:#fff; font-size:0.7rem; font-weight:700; padding:6px 10px; text-transform:uppercase; letter-spacing:0.05em; z-index:2; border-radius:2px;">
            &#9733; {{ $tour->featured_badge }}
          </div>
          @endif
          <div class="card-image-wrap ratio-4-5">
            <a href="{{ url($tour->slug) }}" style="display: block; width: 100%; height: 100%;">
              <img src="{{ $tour->hero_image ? asset('storage/' . $tour->heroMedia?->path) : asset('assets/images/placeholder.jpg') }}" alt="{{ $tour->title }}">
            </a>
          </div>
          @if($tour->banner_text)
          <div style="background-color: #00877C; color: white; text-align: center; font-weight: bold; font-size: 0.8rem; padding: 10px; text-transform: uppercase; letter-spacing: 0.05em;">
            {{ $tour->banner_text }}
          </div>
          @endif
          <div class="card-body">
            <div class="card-tag">{{ $tour->duration_days }} Days · {{ $tour->destinations_count }} Destinations · {{ $tour->max_guests }}</div>
            <a href="{{ url($tour->slug) }}" class="stretched-link" style="text-decoration:none; color:inherit;">
              <h3>{{ $tour->title }}</h3>
            </a>
            <p class="card-desc">{{ Str::limit(strip_tags($tour->hero_text), 150) }}</p>
            <div class="card-foot">
              <div><span class="price-from">From</span><span class="price-num">{{ $tour->price }}</span></div>
              <a href="{{ url($tour->slug) }}" class="btn-ghost">View Journey →</a>
            </div>
          </div>
        </article>
        @endforeach

      </div>
    </div>
  </section>

  <section class="section-tight" style="background:var(--sand);">
    <div class="wrap">
      <div class="center reveal" style="max-width:700px; margin:0 auto 44px;">
        <div class="eyebrow" style="justify-content:center;">Included On Every Journey</div>
        <h2>What travels with you.</h2>
      </div>
      <ul class="grid incl-grid reveal" style="max-width:820px; margin:0 auto;">
        <li>English-speaking Resident Tour Director &amp; local guides</li>
        <li>Airport meet-and-greet with private transfers</li>
        <li>Travelling Bell Boy® bag transfer service</li>
        <li>Mid-journey Traveller's Valet® laundry service</li>
        <li>Internet access throughout</li>
        <li>Daily breakfast, along with many meals</li>
        <li>Entrance fees, taxes and gratuities (except Resident Tour Director)</li>
        <li>Round-the-clock, on-call support from our travel experts</li>
      </ul>
    </div>
  </section>

  <section class="cta-band">
    <div class="wrap reveal">
      <div class="eyebrow on-dark" style="justify-content:center;">Not Sure Which Journey Fits?</div>
      <h2>Let's find your Southeast Asia.</h2>
      <div class="cta-actions">
        <a href="{{ url('contact#consult') }}" class="btn btn-primary">Book a Free Consultation</a>
      </div>
    </div>
  </section>
@endsection
