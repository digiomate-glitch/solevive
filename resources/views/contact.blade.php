@extends('layouts.app')

@section('title', 'Contact Solvive Travel | Book a Free Consultation')

@section('meta_desc', 'Book a free consultation with a Solvive Travel specialist, or send us a quick question about our luxury small-group and private journeys across Southeast Asia.')

@section('content')
  <section class="page-hero" style="background-image: linear-gradient(180deg, rgb(0 0 0 / 45%), rgb(0 0 0 / 65%)), url('{{ asset('assets/images/bespoke_travel_hq.jpg') }}'); background-repeat: no-repeat; background-size: cover; background-position: center;">
    <div class="wrap">
      <div class="crumbs"><a href="{{ url('/') }}">Home</a> / Contact</div>
      <div class="eyebrow on-dark">Let's Talk</div>
      <h1>Begin the conversation.</h1>
      <p class="lede" style="max-width:56ch;">Book a free, no-obligation consultation with a Solvive specialist, or send us a quick question first — either way, we typically reply within one business day.</p>
    </div>
  </section>

  <section class="section-tight">
    <div class="wrap">
      <div class="contact-tabs reveal">
        <button class="contact-tab active" data-target="panel-consult">Book a Free Consultation</button>
        <button class="contact-tab" data-target="panel-inquire">Ask a Question</button>
      </div>

      <!-- ===== CONSULTATION PANEL ===== -->
      <div class="contact-panel active" id="panel-consult">
        <div id="consult" style="position:relative; top:-110px;"></div>
        <div class="grid split reveal" style="align-items:flex-start;">
          <div>
            <div class="eyebrow">Free Consultation</div>
            <h2>Talk through your journey, no obligation.</h2>
            <p class="lede">Pick a time that works for you. A Solvive travel specialist will walk through destinations, dates, group or private travel, and budget — and answer anything on your mind before you commit to a booking.</p>
            <ul class="highlight-list">
              <li><strong>30 minutes</strong>, by video or phone.</li>
              <li>No pressure, no obligation to book.</li>
              <li>Come with questions about any small-group or private journey — or none at all.</li>
            </ul>
          </div>
          <div class="consult-panel">
            <div class="calendly-inline-widget" data-url="https://calendly.com/solvivetravel" style="min-width:280px;height:700px;"></div>
            <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
          </div>
        </div>
      </div>

      <!-- ===== INQUIRY PANEL ===== -->
      <div class="contact-panel" id="panel-inquire">
        <div id="inquire" style="position:relative; top:-110px;"></div>
        <div class="grid split reveal" style="align-items:flex-start;">
          <div>
            <div class="eyebrow">Just Have a Question?</div>
            <h2>Send us a quick note.</h2>
            <p class="lede">Not ready for a call? Tell us what's on your mind — a specific journey, dates you're eyeing, or something you want clarified before booking a consultation — and we'll respond by email.</p>
            <ul class="highlight-list">
              <li>Typical response time: <strong>within one business day.</strong></li>
              <li>No commitment — this is just a conversation starter.</li>
            </ul>
          </div>
          <div class="consult-panel">
            @if(session('success'))
            <div class="form-success show" style="display:block; margin-bottom:20px; padding:15px; background:rgba(0,128,0,0.1); color:green; border-radius:4px; font-weight:bold;">
              {{ session('success') }}
            </div>
            @endif
            
            <form id="inquiry-form" method="POST" action="{{ route('inquiry.store') }}#inquire">
              @csrf
              <div class="grid form-grid">
                <div class="field">
                  <label for="name">Full Name <span style="color:var(--coral);">*</span></label>
                  <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                  @error('name')<div style="color:red; font-size:0.8rem; margin-top:5px;">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                  <label for="email">Email Address <span style="color:var(--coral);">*</span></label>
                  <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                  @error('email')<div style="color:red; font-size:0.8rem; margin-top:5px;">{{ $message }}</div>@enderror
                </div>
                <div class="field">
                  <label for="phone">Phone (Optional)</label>
                  <input type="tel" id="phone" name="phone" value="{{ old('phone') }}">
                  @error('phone')<div style="color:red; font-size:0.8rem; margin-top:5px;">{{ $message }}</div>@enderror
                </div>
                <div class="field" style="max-width:100%;">
                  <label for="journey">Journey of Interest</label>
                  <select id="journey" name="journey" style="width:100%;">
                    <option value="" @if(old('journey') == '') selected @endif>Not sure yet</option>
                    <option @if(old('journey') == 'Angkor Wat & Icons of Southeast Asia') selected @endif>Angkor Wat &amp; Icons of Southeast Asia</option>
                    <option @if(old('journey') == 'Cruising the Mekong & Angkor Wat') selected @endif>Cruising the Mekong &amp; Angkor Wat</option>
                    <option @if(old('journey') == 'An Epic Voyage Around Southeast Asia') selected @endif>An Epic Voyage Around Southeast Asia</option>
                    <option @if(old('journey') == 'Thailand Family Adventure') selected @endif>Thailand Family Adventure</option>
                    <option @if(old('journey') == 'Ultimate Thailand Adventure') selected @endif>Ultimate Thailand Adventure</option>
                    <option @if(old('journey') == 'The Luxury Tented Camps of Southeast Asia') selected @endif>The Luxury Tented Camps of Southeast Asia</option>
                    <option @if(old('journey') == 'Something Fully Custom') selected @endif>Something Fully Custom</option>
                  </select>
                  @error('journey')<div style="color:red; font-size:0.8rem; margin-top:5px;">{{ $message }}</div>@enderror
                </div>
                <div class="field full">
                  <label for="message">Your Question</label>
                  <textarea id="message" name="message">{{ old('message') }}</textarea>
                  @error('message')<div style="color:red; font-size:0.8rem; margin-top:5px;">{{ $message }}</div>@enderror
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Send Inquiry</button>
              <p class="form-note">By submitting, you agree to be contacted by Solvive Travel about your inquiry.</p>
            </form>
          </div>
        </div>
      </div>

    </div>
  </section>

  <div class="divider reveal"><svg viewBox="0 0 220 34"><path d="M0 17 C40 17 40 4 80 4 C110 4 110 30 140 30 C170 30 170 17 220 17"/></svg></div>

  <section class="section" style="padding-top:0;">
    <div class="wrap grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 30px;">
      @php $siteSettings = \App\Models\SiteSetting::first(); @endphp
      @if($siteSettings)
        @if($siteSettings->phone_number)
        <div class="card reveal" style="padding: 30px; text-align: center; border: 1px solid var(--border);">
          <h3 style="margin-bottom: 15px; font-size:1.1rem; text-transform:uppercase; letter-spacing:0.05em; color:var(--dark);">Call Us</h3>
          <p><a href="tel:{{ $siteSettings->phone_number }}" style="color: var(--brand); font-size: 1.1rem; text-decoration: none;">{{ $siteSettings->phone_number }}</a></p>
        </div>
        @endif
        @if($siteSettings->email_id)
        <div class="card reveal" style="padding: 30px; text-align: center; border: 1px solid var(--border);">
          <h3 style="margin-bottom: 15px; font-size:1.1rem; text-transform:uppercase; letter-spacing:0.05em; color:var(--dark);">Email Us</h3>
          <p><a href="mailto:{{ $siteSettings->email_id }}" style="color: var(--brand); font-size: 1.1rem; text-decoration: none;">{{ $siteSettings->email_id }}</a></p>
        </div>
        @endif
        @if($siteSettings->address)
        <div class="card reveal" style="padding: 30px; text-align: center; border: 1px solid var(--border);">
          <h3 style="margin-bottom: 15px; font-size:1.1rem; text-transform:uppercase; letter-spacing:0.05em; color:var(--dark);">Visit Us</h3>
          <p style="color: var(--brand); line-height: 1.6;">{!! nl2br(e($siteSettings->address)) !!}</p>
        </div>
        @endif
        @if($siteSettings->social_ig || $siteSettings->social_fb || $siteSettings->social_p || $siteSettings->social_li || $siteSettings->social_tw || $siteSettings->social_yt)
        <div class="card reveal" style="padding: 30px; text-align: center; border: 1px solid var(--border);">
          <h3 style="margin-bottom: 15px; font-size:1.1rem; text-transform:uppercase; letter-spacing:0.05em; color:var(--dark);">Follow Us</h3>
          <div class="footer-social" style="justify-content: center; margin-top: 10px;">
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
        @endif
      @endif
    </div>
  </section>

  <!-- ===== FAQ ===== -->
  <section class="section" id="faq" style="background:var(--sand);">
    <div class="wrap">
      <div class="reveal" style="max-width:640px; margin-bottom:20px;">
        <div class="eyebrow">Frequently Asked</div>
        <h2>Before you book.</h2>
      </div>

      <div class="reveal">
        <div class="faq-item">
          <button class="faq-q">What's the difference between a small group and a private tour?<span class="plus">+</span></button>
          <div class="faq-a"><p>Small group journeys run on guaranteed, pre-set departure dates with a maximum group size and a shared itinerary — ideal for solo travelers who want built-in community. Private tours are exclusively for your own party, with the itinerary, pace and dates shaped entirely around you.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q">Do I need to book a consultation before I can reserve a trip?<span class="plus">+</span></button>
          <div class="faq-a"><p>No — but we recommend it. A short call lets us confirm dates, room configurations and any special requests before you commit, so there are no surprises later.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q">Is solo travel really comfortable on a small group journey?<span class="plus">+</span></button>
          <div class="faq-a"><p>Yes — our small groups are intentionally kept intimate so that solo travelers naturally become part of the group rather than tacked onto it. You'll never be the odd one out.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q">What's included in the published price?<span class="plus">+</span></button>
          <div class="faq-a"><p>Inclusions vary by journey and are listed in full on each tour's page — generally guides, transfers, entrance fees, taxes, gratuities and a number of meals. International flights to the region are not included unless stated.</p></div>
        </div>
        <div class="faq-item">
          <button class="faq-q">Can a private journey be built entirely from scratch?<span class="plus">+</span></button>
          <div class="faq-a"><p>Absolutely. The three tailormade journeys on our Private Tours page are starting points — every element can be reshaped, and we can also design something completely new around your dates and interests.</p></div>
        </div>
      </div>
    </div>
  </section>

  <section class="cta-band">
    <div class="wrap reveal">
      <div class="eyebrow on-dark" style="justify-content:center;">Still Deciding?</div>
      <h2>Browse the journeys first.</h2>
      <div class="cta-actions">
        <a href="{{ url('small-group-tours') }}" class="btn btn-primary">Small Group Tours</a>
        <a href="{{ url('private-tours') }}" class="btn btn-outline on-dark">Private Tours</a>
      </div>
    </div>
  </section>
@endsection
