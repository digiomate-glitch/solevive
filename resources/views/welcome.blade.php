@extends('layouts.app')

@section('content')
  <!-- ============ HERO ============ -->
  @php
    $heroBg = $siteSetting?->home_hero_image 
      ? asset('storage/' . $siteSetting->homeHeroImageMedia?->path)
      : asset('assets/images/hero_landscape_hq.jpg');
  @endphp
  <section class="hero" style="background: radial-gradient(ellipse 60% 50% at 50% 8%, rgba(222,122,70,.35), transparent 60%), linear-gradient(180deg, rgb(0 0 0 / 45%), rgb(0 0 0 / 65%)), url('{{ $heroBg }}') center/cover no-repeat;">
    <div class="wrap hero-inner">
      <div class="eyebrow on-dark">{{ $siteSetting?->home_hero_top_text ?? 'Vietnam · Cambodia · Laos · Thailand' }}</div>
      <h1>{!! $siteSetting?->home_hero_headline ?? 'Journeys that leave you <span class="italic">better than they found you.</span>' !!}</h1>
      <p class="lede">{{ $siteSetting?->home_hero_subtitle ?? 'Solvive designs small-group and private luxury travel across Southeast Asia — for those seeking genuine connection, deep relaxation, and a spiritual renewal that outlasts the trip itself.' }}</p>
      <div class="cta-actions" style="justify-content:flex-start;">
        <a href="{{ url($siteSetting?->home_hero_btn1_link ?? '/small-group-tours') }}" class="btn btn-primary">{{ $siteSetting?->home_hero_btn1_text ?? 'Explore Small Group Tours' }}</a>
        <a href="{{ url($siteSetting?->home_hero_btn2_link ?? '/contact#consult') }}" class="btn btn-outline on-dark">{{ $siteSetting?->home_hero_btn2_text ?? 'Book a Free Consultation' }}</a>
      </div>
      <div class="hero-stats">
        <div><strong>{{ $siteSetting?->home_hero_stat1_value ?? 'Small Group' }}</strong><span>{{ $siteSetting?->home_hero_stat1_title ?? 'Group Journeys' }}</span></div>
        <div><strong>{{ $siteSetting?->home_hero_stat2_value ?? '4' }}</strong><span>{{ $siteSetting?->home_hero_stat2_title ?? 'Countries Explored' }}</span></div>
        <div><strong>{{ $siteSetting?->home_hero_stat3_value ?? '24/7' }}</strong><span>{{ $siteSetting?->home_hero_stat3_title ?? 'Local On-Call Support' }}</span></div>
      </div>
    </div>
    <div class="hero-scroll"><span>Scroll</span><span class="line"></span></div>
  </section>

  <!-- ============ INTRO / MISSION ============ -->
  <section class="section">
    <div class="wrap reveal center">
      <h2 style="font-weight:400; font-size:clamp(1.5rem, 3vw, 2.05rem); line-height:1.4; color:var(--ink);">
        A pause, intentionally designed. In a world of constant noise, we believe everyone deserves an intentional pause — a chance to step away, reflect, and return home not just with photographs, but with a renewed spirit and kindred friends who feel like family.
      </h2>
      <a href="{{ url('/about') }}" class="btn-ghost" style="margin-top:30px; display:inline-block;">Read Our Story →</a>
    </div>
  </section>

  <div class="divider reveal">
    <svg viewBox="0 0 220 34" xmlns="http://www.w3.org/2000/svg"><path d="M0 17 C40 17 40 4 80 4 C110 4 110 30 140 30 C170 30 170 17 220 17"/></svg>
  </div>

  <!-- ============ SMALL GROUP TOURS ============ -->
  <section class="section-tight">
    <div class="wrap">
      <div class="reveal" style="max-width:640px;">
        <div class="eyebrow">Luxury Small Group Tours</div>
        <h2>Travel among kindred spirits.</h2>
        <p class="lede">Guaranteed small-group departures — never more than a handful of fellow travelers, always an expert Resident Tour Director, always the finest properties in each destination.</p>
      </div>

      <div class="grid journey-grid" style="margin-top:52px;">
        @foreach($featuredTours as $index => $tour)
        @php 
            $badgeColor = $tour->badge_color ?: 'var(--brand, #c99355)';
            $borderColor = '#00877C';
        @endphp
        <article class="card reveal" style="display:flex; flex-direction:column; position:relative; {{ ($tour->featured_badge || $tour->banner_text) ? 'border: 3px solid ' . $borderColor . ';' : '' }}">
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
          <div class="card-body" style="flex:1; display:flex; flex-direction:column;">
            <div class="card-tag" style="color:var(--brand); margin-bottom:8px;">{{ $tour->duration_days }} DAYS &middot; {{ $tour->destinations_count }} DESTINATIONS</div>
            <a href="{{ url($tour->slug) }}" class="stretched-link" style="text-decoration:none; color:inherit;">
              <h3 style="margin-bottom:12px; font-size:1.4rem;">{{ $tour->title }}</h3>
            </a>
            
            <div style="font-size:0.75rem; color:#555; margin-bottom:16px;">
              <div style="margin-bottom:6px; font-weight:500;">{{ $tour->max_guests }} Guests Max</div>
              <div style="padding-bottom:16px; border-bottom:1px solid rgba(0,0,0,0.08);">
                {{ $tour->countries ?? 'Vietnam &middot; Cambodia &middot; Laos &middot; Thailand' }}
              </div>
            </div>

            <p class="card-desc" style="flex:1; margin-bottom:24px;">{{ Str::limit(strip_tags($tour->hero_text ?? $tour->overview_desc), 120) }}</p>
            
            <div class="card-foot" style="margin-top:auto;">
              <div><span class="price-from" style="font-size:0.65rem; color:#777; text-transform:uppercase; display:block; margin-bottom:2px;">FROM</span><span class="price-num" style="display:block; font-size:1.1rem; font-weight:500; color:var(--ink);">{{ $tour->price }}</span></div>
              <a href="{{ url($tour->slug) }}" class="btn-ghost" style="text-transform:uppercase; font-size:0.75rem; font-weight:700; letter-spacing:0.05em; color:var(--brand);">VIEW JOURNEY &rarr;</a>
            </div>
            
            <div style="background: rgba(0,0,0,0.04); padding: 12px; margin-top: 20px; font-size: 0.75rem; border-radius: 4px; color: #555;">
              Payment plans are available and deposits as low as $200
            </div>
          </div>
        </article>
        @endforeach
      </div>

      <div class="center" style="margin-top:48px;">
        <a href="{{ url('/small-group-tours') }}" class="btn btn-outline">View All Small Group Tours</a>
      </div>
    </div>
  </section>

  <!-- ============ PRIVATE TOURS SPLIT ============ -->
  <section class="section" style="background:var(--sand);">
    <div class="wrap grid split reveal">
      <div class="split-media ratio-1-1">
        <img src="{{ asset('assets/images/private_tours_1785995341874.jpg') }}" alt="Tailormade Private Journeys" style="width:100%; height:100%; object-fit:cover; border-radius:4px;">
      </div>
      <div>
        <div class="eyebrow">Luxury Private Tours</div>
        <h2>Your itinerary. Your pace. Your people.</h2>
        <p class="lede">For families, couples and private parties who want the Solvive standard of restorative luxury — entirely tailored, with pre-set dates for ease or fully bespoke design from the ground up.</p>
        <ul class="highlight-list" style="margin:26px 0;">
          <li><strong>Thailand Family Adventure</strong> — 10 days, from $6,495 per person</li>
          <li><strong>Ultimate Thailand Adventure</strong> — 11 days, from $13,395 per person</li>
          <li><strong>The Luxury Tented Camps of Southeast Asia</strong> — 15 days, from $38,795 per person</li>
        </ul>
        <a href="{{ url('/private-tours') }}" class="btn btn-primary">Explore Private Tours</a>
      </div>
    </div>
  </section>

  <!-- ============ VALUES ============ -->
  <section class="section">
    <div class="wrap">
      <div class="center reveal" style="max-width:680px; margin:0 auto 56px;">
        <div class="eyebrow" style="justify-content:center;">Why Solvive</div>
        <h2>Quality over quantity. Trust over transaction.</h2>
        <p class="lede center">Every journey we design leaves our travelers — and the places they visit — better than we found them.</p>
      </div>
      <div class="grid pillars reveal">
        <div class="pillar"><span class="pillar-num">I.</span><h4>Human Connection</h4><p>The deepest memories come from people, not places — locals, fellow travelers, and yourself.</p></div>
        <div class="pillar"><span class="pillar-num">II.</span><h4>Authenticity</h4><p>Family kitchens, hidden temples, village markets and sacred rituals — never a tourist trap.</p></div>
        <div class="pillar"><span class="pillar-num">III.</span><h4>Restorative Travel</h4><p>We build in quiet, reflection and rest — not just sightseeing.</p></div>
        <div class="pillar"><span class="pillar-num">IV.</span><h4>Trust &amp; Safety</h4><p>24/7 local support and guides equipped for anything. You are never alone.</p></div>
      </div>
      <div class="center" style="margin-top:36px;">
        <a href="{{ url('/about#values') }}" class="btn-ghost">See All Our Values →</a>
      </div>
    </div>
  </section>

  <div class="divider reveal">
    <svg viewBox="0 0 220 34" xmlns="http://www.w3.org/2000/svg"><path d="M0 17 C40 17 40 4 80 4 C110 4 110 30 140 30 C170 30 170 17 220 17"/></svg>
  </div>

  <!-- ============ QUOTE ============ -->
  <section class="section-tight">
    <div class="wrap center reveal">
      <p class="quote-block">"Travel should leave you better than it found you."</p>
    </div>
  </section>

  <!-- ============ CTA BAND ============ -->
  <section class="cta-band">
    <div class="wrap reveal">
      <div class="eyebrow on-dark" style="justify-content:center;">Begin the Conversation</div>
      <h2>Let's design your Southeast Asia.</h2>
      <p class="lede center" style="color:var(--cream-dim,#E7DFCB); opacity:.85;">Book a free, no-obligation consultation with our travel specialists — or send us a quick question first.</p>
      <div class="cta-actions">
        <a href="{{ url('/contact#consult') }}" class="btn btn-primary">Book a Free Consultation</a>
        <a href="{{ url('/contact#inquire') }}" class="btn btn-outline on-dark">Ask a Question</a>
      </div>
    </div>
  </section>
@endsection
