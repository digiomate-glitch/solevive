@extends('layouts.app')

@section('title', $tour->seo_title ? $tour->seo_title : ($tour->title . ' | Solvive Travel'))

@if($tour->seo_desc)
    @section('meta_desc', $tour->seo_desc)
@endif

@if($tour->primary_keyword || $tour->focus_keyword)
    @section('meta_keywords', implode(', ', array_filter([$tour->primary_keyword, $tour->focus_keyword])))
@endif

@section('content')
  <section class="detail-hero" style="background-image: linear-gradient(180deg, rgb(0 0 0 / 45%), rgb(0 0 0 / 65%)), url('{{ $tour->hero_image ? asset('storage/' . $tour->heroMedia?->path) : asset('assets/images/hero_landscape_hq.jpg') }}'); background-repeat: no-repeat; background-size: cover; background-position: center;">
    <div class="wrap">
      <div class="crumbs"><a href="{{ url('/') }}">Home</a> / {{ $tour->title }}</div>
      <div class="eyebrow on-dark">Luxury Tour</div>
      <h1>{{ $tour->title }}</h1>
      <div class="lede" style="max-width:60ch; color:var(--cream-dim,#E7DFCB); opacity:.88;">{!! $tour->hero_text !!}</div>
      <div class="detail-facts">
        @if(is_array($tour->facts) && count($tour->facts) > 0)
            @foreach($tour->facts as $fact)
                <div><strong>{{ $fact['top'] ?? '' }}</strong><span>{{ $fact['bottom'] ?? '' }}</span></div>
            @endforeach
        @else
            <div><strong>{{ $tour->duration_days }}</strong><span>Days</span></div>
            <div><strong>{{ $tour->destinations_count }}</strong><span>Destinations</span></div>
            <div><strong>{{ $tour->max_guests }}</strong><span>Guests Max</span></div>
            <div><strong>{{ $tour->price }}</strong><span>From, Per Person</span></div>
        @endif
      </div>
      @if($tour->banner_text)
      <div style="background-color: #00877C; color: white; display: inline-block; font-weight: bold; font-size: 0.9rem; padding: 12px 24px; margin-top: 30px; text-transform: uppercase; letter-spacing: 0.05em; border-radius: 2px;">
        {{ $tour->banner_text }}
      </div>
      @endif
    </div>
  </section>

  <section class="section">
    <div class="wrap grid tour-body">
      <div>
        @if($tour->overview_image)
        <img src="{{ asset('storage/' . $tour->overviewMedia?->path) }}" alt="{{ $tour->title }}" class="reveal" style="margin-bottom:50px; width:100%; border-radius:4px; aspect-ratio:16/9; object-fit:cover;">
        @endif

        <div class="reveal">
          <div class="eyebrow">Overview</div>
          <h2>{{ $tour->overview_heading ?? 'A meticulously crafted experience' }}</h2>
          <div class="lede ck-content">{!! $tour->overview_desc !!}</div>
        </div>

        @if($tour->highlights->count() > 0)
        <div class="divider reveal"><svg viewBox="0 0 220 34"><path d="M0 17 C40 17 40 4 80 4 C110 4 110 30 140 30 C170 30 170 17 220 17"/></svg></div>
        <div class="reveal">
          <div class="eyebrow">Journey Highlights</div>
          <h2>{{ $tour->highlights_heading ?? 'What awaits you.' }}</h2>
          <ul class="highlight-list">
            @foreach($tour->highlights as $highlight)
            @php
                $content = $highlight->content;
                if (str_contains($content, '<li>')) {
                    $content = str_replace(['<ul>', '</ul>', '<ol>', '</ol>'], '', $content);
                } else {
                    $content = '<li>' . strip_tags($content, '<strong><em><b><i><a><br><span>') . '</li>';
                }
            @endphp
            {!! $content !!}
            @endforeach
          </ul>
        </div>
        @endif

        @if($tour->differences->count() > 0)
        <div class="divider reveal"><svg viewBox="0 0 220 34"><path d="M0 17 C40 17 40 4 80 4 C110 4 110 30 140 30 C170 30 170 17 220 17"/></svg></div>
        <div class="reveal">
          <div class="eyebrow">The A&amp;K Difference</div>
          <h2>{{ $tour->differences_heading ?? 'Why Choose an A&K Small Group Journey?' }}</h2>
          <ul class="highlight-list">
            @foreach($tour->differences as $difference)
            @php
                $content = $difference->content;
                if (str_contains($content, '<li>')) {
                    $content = str_replace(['<ul>', '</ul>', '<ol>', '</ol>'], '', $content);
                } else {
                    $content = '<li>' . strip_tags($content, '<strong><em><b><i><a><br><span>') . '</li>';
                }
            @endphp
            {!! $content !!}
            @endforeach
          </ul>
        </div>
        @endif

        @if($tour->inclusions->count() > 0)
        <div class="divider reveal"><svg viewBox="0 0 220 34"><path d="M0 17 C40 17 40 4 80 4 C110 4 110 30 140 30 C170 30 170 17 220 17"/></svg></div>
        <div class="reveal">
          <div class="eyebrow">What's Included</div>
          <h2>{{ $tour->inclusions_heading ?? 'Every detail, handled.' }}</h2>
          <ul class="grid incl-grid">
            @foreach($tour->inclusions as $inclusion)
            @php
                $content = $inclusion->content;
                if (str_contains($content, '<li>')) {
                    $content = str_replace(['<ul>', '</ul>', '<ol>', '</ol>'], '', $content);
                } else {
                    $content = '<li>' . strip_tags($content, '<strong><em><b><i><a><br><span>') . '</li>';
                }
            @endphp
            {!! $content !!}
            @endforeach
          </ul>
        </div>
        @endif

        @if($tour->accommodations->count() > 0)
        <div class="divider reveal"><svg viewBox="0 0 220 34"><path d="M0 17 C40 17 40 4 80 4 C110 4 110 30 140 30 C170 30 170 17 220 17"/></svg></div>
        <div class="reveal">
          <div class="eyebrow">Where You'll Stay</div>
          <h2>{{ $tour->accommodations_heading ?? 'Exceptional Properties.' }}</h2>
          @foreach($tour->accommodations as $hotel)
          <div class="stay-card">
            <div class="card-image-wrap ratio-1-1 stay-thumb">
              <img src="{{ $hotel->image ? asset('storage/' . $hotel->media?->path) : asset('assets/images/placeholder.jpg') }}" alt="{{ $hotel->hotel_name }}">
            </div>
            <div>
              <h4>{{ $hotel->hotel_name }}</h4>
              <div class="ck-content">{!! $hotel->description !!}</div>
            </div>
          </div>
          @endforeach
        </div>
        @endif

        @if($tour->additionalInfos->count() > 0)
        <div class="divider reveal"><svg viewBox="0 0 220 34"><path d="M0 17 C40 17 40 4 80 4 C110 4 110 30 140 30 C170 30 170 17 220 17"/></svg></div>
        <div class="reveal">
          <div class="eyebrow">Good to Know</div>
          <h2>{{ $tour->additional_infos_heading ?? 'Additional information.' }}</h2>
          <ul class="grid incl-grid">
            @foreach($tour->additionalInfos as $info)
            @php
                $content = $info->content;
                if (str_contains($content, '<li>')) {
                    $content = str_replace(['<ul>', '</ul>', '<ol>', '</ol>'], '', $content);
                } else {
                    $content = '<li>' . strip_tags($content, '<strong><em><b><i><a><br><span>') . '</li>';
                }
            @endphp
            {!! $content !!}
            @endforeach
          </ul>
        </div>
        @endif

      </div>

      <!-- THE STICKY SIDEBAR -->
      <aside>
        <div class="side-card reveal">
          <div class="eyebrow" style="margin-bottom:.4em;">From</div>
          <div class="price-num">{{ $tour->price }}</div>
          <p class="form-note" style="margin:.4em 0 0;">per person, land &amp; internal air</p>
          <ul class="side-facts">
            <li><span>Duration</span><b>{{ $tour->duration_days }} Days</b></li>
            <li><span>Destinations</span><b>{{ $tour->destinations_count }}</b></li>
            <li><span>Group Size</span><b>{{ $tour->max_guests }}</b></li>
            @if($tour->countries)
            <li style="border-top: 1px solid rgba(0,0,0,0.08); padding-top: 10px; margin-top: 10px;">
              <span>Countries</span><b style="line-height:1.4;">{{ $tour->countries }}</b>
            </li>
            @endif
          </ul>
          <a href="{{ url('contact#consult') }}" class="btn btn-primary">Book a Free Consultation</a>
          <a href="{{ url('contact#inquire') }}" class="btn btn-outline">Ask a Question</a>
        </div>
      </aside>

    </div>
  </section>

  @if($primaryCategory && $relatedTours->isNotEmpty())
  <section class="section" style="background:var(--sand);">
    <div class="wrap">
      <div class="eyebrow" style="color:var(--brand); margin-bottom:.5em;">YOU MAY ALSO LIKE</div>
      <h2 style="margin-bottom:2em;">More {{ strtolower($primaryCategory->name ?? 'journeys') }}.</h2>
      
      <div class="grid journey-grid">
        @foreach($relatedTours as $related)
        @php 
            $badgeColor = $related->badge_color ?: 'var(--brand, #c99355)';
            $borderColor = '#00877C';
        @endphp
        <article class="card reveal" style="display:flex; flex-direction:column; position:relative; {{ ($related->featured_badge || $related->banner_text) ? 'border: 3px solid ' . $borderColor . ';' : '' }}">
          @if($related->featured_badge)
          <div style="position:absolute; top:15px; right:15px; background:{{ $badgeColor }}; color:#fff; font-size:0.7rem; font-weight:700; padding:6px 10px; text-transform:uppercase; letter-spacing:0.05em; z-index:2; border-radius:2px;">
            &#9733; {{ $related->featured_badge }}
          </div>
          @endif
          <div class="card-image-wrap ratio-4-5">
            <a href="{{ url($related->slug) }}" style="display: block; width: 100%; height: 100%;">
              <img src="{{ $related->hero_image ? asset('storage/' . $related->heroMedia?->path) : asset('assets/images/placeholder.jpg') }}" alt="{{ $related->title }}">
            </a>
          </div>
          @if($related->banner_text)
          <div style="background-color: #00877C; color: white; text-align: center; font-weight: bold; font-size: 0.8rem; padding: 10px; text-transform: uppercase; letter-spacing: 0.05em;">
            {{ $related->banner_text }}
          </div>
          @endif
          <div class="card-body" style="flex:1; display:flex; flex-direction:column;">
            <div class="card-tag">{{ $related->duration_days }} DAYS · {{ $related->max_guests }} GUESTS MAX</div>
            <a href="{{ url($related->slug) }}" class="stretched-link" style="text-decoration:none; color:inherit;">
              <h3>{{ $related->title }}</h3>
            </a>
            <div class="card-foot" style="margin-top:auto;">
              <div><span class="price-from">FROM</span><span class="price-num" style="display:block;">{{ $related->price }}</span></div>
              <a href="{{ url($related->slug) }}" class="btn-ghost" style="text-transform:uppercase; font-size:0.8rem; font-weight:600; letter-spacing:0.05em; color:var(--brand);">VIEW &rarr;</a>
            </div>
            <div style="background: rgba(0,0,0,0.04); padding: 12px; margin-top: 20px; font-size: 0.8rem; border-radius: 4px; color: #555;">
              Payment plans are available and deposits as low as $200
            </div>
          </div>
        </article>
        @endforeach

        @if($primaryCategory->slug == 'small-group-tours')
        <article class="card reveal" style="display:flex; flex-direction:column;">
          <div class="card-image-wrap ratio-4-5">
            <img src="{{ $tour->hero_image ? asset('storage/' . $tour->heroMedia?->path) : asset('assets/images/placeholder.jpg') }}" alt="Travel Privately">
          </div>
          <div class="card-body" style="flex:1; display:flex; flex-direction:column;">
            <div class="card-tag">{{ $tour->duration_days }} DAYS · PRIVATE</div>
            <h3>Prefer to travel privately?</h3>
            <p class="card-desc" style="flex:1;">This same route, tailored exclusively for your party.</p>
            <div class="card-foot" style="margin-top:auto;">
              <a href="{{ url('private-tours') }}" class="btn-ghost stretched-link" style="text-transform:uppercase; font-size:0.8rem; font-weight:600; letter-spacing:0.05em; color:var(--brand);">SEE PRIVATE TOURS &rarr;</a>
            </div>
          </div>
        </article>
        @elseif($primaryCategory->slug == 'private-tours')
        <article class="card reveal" style="display:flex; flex-direction:column;">
          <div class="card-image-wrap ratio-4-5">
            <img src="{{ $tour->hero_image ? asset('storage/' . $tour->heroMedia?->path) : asset('assets/images/placeholder.jpg') }}" alt="Small Group Tours">
          </div>
          <div class="card-body" style="flex:1; display:flex; flex-direction:column;">
            <div class="card-tag">{{ $tour->duration_days }} DAYS · SMALL GROUP</div>
            <h3>Prefer a small group?</h3>
            <p class="card-desc" style="flex:1;">Join our scheduled departures with like-minded travellers.</p>
            <div class="card-foot" style="margin-top:auto;">
              <a href="{{ url('small-group-tours') }}" class="btn-ghost stretched-link" style="text-transform:uppercase; font-size:0.8rem; font-weight:600; letter-spacing:0.05em; color:var(--brand);">SEE SMALL GROUP TOURS &rarr;</a>
            </div>
          </div>
        </article>
        @endif

      </div>
    </div>
  </section>
  @endif

@endsection
