<footer class="site-footer">
  <div class="wrap">
    <div class="grid footer-top">
      <div class="footer-brand">
        <a href="{{ url('/') }}">
          @php $siteSettings = \App\Models\SiteSetting::first(); @endphp
          @if($siteSettings && $siteSettings->footer_logo)
            <img src="{{ asset('storage/' . $siteSettings->footerLogoMedia?->path) }}" alt="Solvive Travel" style="max-width: 150px;">
          @else
            <img src="{{ asset('assets/images/logo.png') }}" alt="Solvive Travel" style="max-width: 150px;">
          @endif
        </a>
        <p>{{ $siteSettings->footer_text ?? 'Transformative small-group and private journeys across Southeast Asia — for travelers seeking connection, renewal, and the sacred pause.' }}</p>
        <div class="footer-social">
          @php $target = $siteSettings->social_open_new_tab ? 'target="_blank" rel="noopener noreferrer"' : ''; @endphp
          @if($siteSettings->social_ig)
          <a href="{{ $siteSettings->social_ig }}" aria-label="Instagram" {!! $target !!}>IG</a>
          @endif
          @if($siteSettings->social_fb)
          <a href="{{ $siteSettings->social_fb }}" aria-label="Facebook" {!! $target !!}>FB</a>
          @endif
          @if($siteSettings->social_p)
          <a href="{{ $siteSettings->social_p }}" aria-label="Pinterest" {!! $target !!}>P</a>
          @endif
          @if($siteSettings->social_li)
          <a href="{{ $siteSettings->social_li }}" aria-label="LinkedIn" {!! $target !!}>IN</a>
          @endif
          @if($siteSettings->social_tw)
          <a href="{{ $siteSettings->social_tw }}" aria-label="Twitter" {!! $target !!}>X</a>
          @endif
          @if($siteSettings->social_yt)
          <a href="{{ $siteSettings->social_yt }}" aria-label="YouTube" {!! $target !!}>YT</a>
          @endif
        </div>
      </div>
      <div class="footer-col">
        <h5>Journeys</h5>
        <ul>
          <li><a href="{{ url('/small-group-tours') }}">Small Group Tours</a></li>
          <li><a href="{{ url('/private-tours') }}">Private Tours</a></li>
          <li><a href="{{ url('/angkor-wat-and-icons-of-southeast-asia') }}">Angkor Wat &amp; Icons</a></li>
          <li><a href="{{ url('/cruising-the-mekong-and-angkor-wat') }}">Mekong River Cruise</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h5>Studio</h5>
        <ul>
          <li><a href="{{ url('/about') }}">Our Story</a></li>
          <li><a href="{{ url('/about#values') }}">Values</a></li>
          <li><a href="{{ url('/contact') }}">Contact</a></li>
          <li><a href="{{ url('/contact#faq') }}">FAQ</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h5>Begin Your Journey</h5>
        <ul>
          <li><a href="{{ url('/contact#consult') }}">Book a Free Consultation</a></li>
          <li><a href="{{ url('/contact#inquire') }}">Send an Inquiry</a></li>
        </ul>
        @if($siteSettings->address || $siteSettings->phone_number || $siteSettings->email_id)
        <div style="margin-top: 2rem;">
          <h5>Contact Info</h5>
          @if($siteSettings->address)
          <p style="margin-bottom: 0.5rem; color: var(--cream-dim); display: flex; align-items: flex-start; gap: 8px;">
            <svg style="width: 16px; height: 16px; margin-top: 4px; flex-shrink: 0; color: var(--brand);" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span>{!! nl2br(e($siteSettings->address)) !!}</span>
          </p>
          @endif
          @if($siteSettings->phone_number)
          <p style="margin-bottom: 0.5rem; display: flex; align-items: center; gap: 8px;">
            <svg style="width: 16px; height: 16px; flex-shrink: 0; color: var(--brand);" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            <a href="tel:{{ $siteSettings->phone_number }}" style="color: var(--cream-dim);">{{ $siteSettings->phone_number }}</a>
          </p>
          @endif
          @if($siteSettings->email_id)
          <p style="margin-bottom: 0.5rem; display: flex; align-items: center; gap: 8px;">
            <svg style="width: 16px; height: 16px; flex-shrink: 0; color: var(--brand);" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            <a href="mailto:{{ $siteSettings->email_id }}" style="color: var(--brand);">{{ $siteSettings->email_id }}</a>
          </p>
          @endif
        </div>
        @endif
      </div>
    </div>
    <div class="footer-bottom">
      <span>&copy; <span id="year"></span> {{ $siteSettings->copyright_text ?? 'Solvive Travel. All rights reserved.' }}</span>
      <span>{{ $siteSettings->bottom_right_text ?? 'Journeys crafted in partnership with trusted luxury tour operators.' }}</span>
    </div>
  </div>
</footer>
