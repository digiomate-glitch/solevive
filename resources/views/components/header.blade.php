<header class="site-header">
  <div class="wrap">
    <a href="{{ url('/') }}" class="brand">
      @php $siteSettings = \App\Models\SiteSetting::first(); @endphp
      @if($siteSettings && $siteSettings->header_logo)
        <img src="{{ asset('storage/' . $siteSettings->headerLogoMedia?->path) }}" alt="Solvive Travel">
      @else
        <img src="{{ asset('assets/images/logo.png') }}" alt="Solvive Travel">
      @endif
    </a>
    <nav class="main-nav">
      <ul>
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ url('/about') }}">About</a></li>
        <li class="has-dropdown">
          <a href="{{ url('/small-group-tours') }}">Small Group Tours</a>
          <div class="dropdown">
            @foreach($navSmallGroupTours as $tour)
            <a href="{{ url($tour->slug) }}" @if($tour->title == 'An Epic Voyage Around Southeast Asia') style="background-color: rgba(212, 175, 55, 0.15); border-left: 3px solid #d4af37;" @endif>
              {{ $tour->title }}
              @if($tour->title == 'An Epic Voyage Around Southeast Asia')
                <span style="display: inline-block; background: #d4af37; color: #fff; font-size: 0.65em; padding: 2px 6px; border-radius: 3px; margin-left: 8px; vertical-align: middle; text-transform: uppercase; letter-spacing: 1px; font-weight: bold;">Featured</span>
              @endif
              <span class="dd-meta">{{ $tour->duration_days }} Days · From {{ $tour->price }}</span>
            </a>
            @endforeach
          </div>
        </li>
        <li class="has-dropdown">
          <a href="{{ url('/private-tours') }}">Private Tours</a>
          <div class="dropdown">
            @foreach($navPrivateTours as $tour)
            <a href="{{ url($tour->slug) }}">{{ $tour->title }}<span class="dd-meta">{{ $tour->duration_days }} Days · From {{ $tour->price }}</span></a>
            @endforeach
          </div>
        </li>
        <li><a href="{{ url('/contact') }}">Contact</a></li>
      </ul>
    </nav>
    <div class="nav-cta">
      <a href="{{ url('/contact#consult') }}" class="btn btn-primary">Book a Consultation</a>
    </div>
    <button class="hamburger" aria-label="Toggle menu"><span></span><span></span><span></span></button>
  </div>
</header>
