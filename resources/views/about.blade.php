@extends('layouts.app')

@section('title', 'About Solvive Travel | Our Mission, Purpose & Values')

@section('meta_desc', 'Solvive Travel exists to create transformative journeys across Southeast Asia where travelers find genuine connection, deep relaxation, and spiritual renewal. Discover our story and values.')

@section('content')
  <section class="page-hero" style="background-image: linear-gradient(180deg, rgb(0 0 0 / 45%), rgb(0 0 0 / 65%)), url('{{ asset('assets/images/Luxury%20Tented%20Camps%20of%20Southeast%20Asia-img.webp') }}'); background-repeat: no-repeat; background-size: cover; background-position: center;">
    <div class="wrap">
      <div class="crumbs"><a href="{{ url('/') }}">Home</a> / About</div>
      <div class="eyebrow on-dark">Our Story</div>
      <h1>We believe travel should leave you <span class="italic">better than it found you.</span></h1>
      <p class="lede" style="max-width:56ch;">Solvive exists for solo travelers, couples and small parties seeking something more than an itinerary — a genuine pause, built with intention.</p>
    </div>
  </section>

  <section class="section">
    <div class="wrap grid two-col-text reveal">
      <div>
        <div class="eyebrow">Mission</div>
        <h2>Transformative journeys, by design.</h2>
      </div>
      <div>
        <p class="lede">To create transformative journeys across Asia where travelers find genuine connection, deep relaxation, and spiritual renewal — because travel should leave you better than it found you.</p>
      </div>
    </div>
  </section>

  <div class="divider reveal"><svg viewBox="0 0 220 34"><path d="M0 17 C40 17 40 4 80 4 C110 4 110 30 140 30 C170 30 170 17 220 17"/></svg></div>

  <section class="section-tight">
    <div class="wrap grid split reverse reveal">
      <div class="card-image-wrap ratio-4-5"><img src="{{ asset('assets/images/hero_landscape_hq.jpg') }}" alt="Purpose"></div>
      <div>
        <div class="eyebrow">Purpose</div>
        <h2>An intentional pause in a noisy world.</h2>
        <p class="lede">We exist to create transformative group journeys across Southeast Asia where solo travelers find genuine connection, deep relaxation, and spiritual renewal. In a world of constant noise and busyness, everyone deserves a chance to step away, reflect, and return home not just with photos, but with a renewed spirit and kindred friends who feel like family.</p>
      </div>
    </div>
  </section>

  <section class="section" style="background:var(--sand);">
    <div class="wrap grid split reveal">
      <div class="card-image-wrap ratio-4-5"><img src="{{ asset('assets/images/Luxury%20Tented%20Camps%20of%20Southeast%20Asia-img.webp') }}" alt="Our Values"></div>
      <div>
        <div class="eyebrow">Values</div>
        <h2>Quality over quantity. Trust over transaction. Community over isolation.</h2>
        <p class="lede">Our work is guided by a commitment to genuine human connection, authentic local experiences, and restorative travel. Every journey we design leaves our travelers, and the places they visit, better than we found them.</p>
      </div>
    </div>
  </section>

  <section class="section" id="values">
    <div class="wrap">
      <div class="center reveal" style="max-width:640px; margin:0 auto 56px;">
        <div class="eyebrow" style="justify-content:center;">Our Core Values</div>
        <h2>Eight commitments behind every itinerary.</h2>
      </div>

      <div class="grid two-col-text" style="row-gap:48px;">
        <div class="reveal">
          <span class="pillar-num" style="display:block; margin-bottom:14px;">I.</span>
          <h3>Human Connection</h3>
          <p>Travel is about people, not just places. We believe the deepest memories come from the connections we make: with locals, with fellow travelers, and with ourselves. Every journey we design creates space for genuine relationships to form.</p>
        </div>
        <div class="reveal">
          <span class="pillar-num" style="display:block; margin-bottom:14px;">II.</span>
          <h3>Authenticity</h3>
          <p>We avoid tourist traps and cookie-cutter itineraries. Through our local guides, we open doors to real experiences — family kitchens, hidden temples, village markets and sacred rituals that tourists rarely see. We honor the cultures we visit.</p>
        </div>
        <div class="reveal">
          <span class="pillar-num" style="display:block; margin-bottom:14px;">III.</span>
          <h3>Restorative Travel</h3>
          <p>We believe travel should leave you better than it found you. Our journeys are designed for renewal — mentally, physically and spiritually. We build in quiet, reflection and rest, not just sightseeing.</p>
        </div>
        <div class="reveal">
          <span class="pillar-num" style="display:block; margin-bottom:14px;">IV.</span>
          <h3>Trust &amp; Safety</h3>
          <p>Solo travelers need to feel safe. We build trust through transparency, 24/7 local support, and guides equipped to handle any situation — from a lost passport to a medical emergency. When you travel with us, you're never alone.</p>
        </div>
        <div class="reveal">
          <span class="pillar-num" style="display:block; margin-bottom:14px;">V.</span>
          <h3>Community</h3>
          <p>We create spaces where solo travelers become kindred spirits. Our small groups foster intimacy, shared experiences and friendships that last long after the journey ends.</p>
        </div>
        <div class="reveal">
          <span class="pillar-num" style="display:block; margin-bottom:14px;">VI.</span>
          <h3>Quality Over Quantity</h3>
          <p>We choose quality over scale — smaller groups, handpicked accommodations, carefully vetted experiences and local guides who are experts in their craft. We'd rather serve a dozen guests exceptionally than forty adequately.</p>
        </div>
        <div class="reveal">
          <span class="pillar-num" style="display:block; margin-bottom:14px;">VII.</span>
          <h3>Cultural Respect &amp; Sustainability</h3>
          <p>We travel with humility. We support local businesses, hire local guides, and ensure our presence benefits the communities we visit. We leave a positive footprint, not just memories.</p>
        </div>
        <div class="reveal">
          <span class="pillar-num" style="display:block; margin-bottom:14px;">VIII.</span>
          <h3>Simplicity &amp; Ease</h3>
          <p>We handle the logistics so our guests don't have to. From airport transfers to meal planning to emergency support, we take care of the details so our travelers can simply show up and be present.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="cta-band">
    <div class="wrap reveal">
      <div class="eyebrow on-dark" style="justify-content:center;">Ready When You Are</div>
      <h2>Let's talk about the journey you need.</h2>
      <div class="cta-actions">
        <a href="{{ url('contact#consult') }}" class="btn btn-primary">Book a Free Consultation</a>
        <a href="{{ url('small-group-tours') }}" class="btn btn-outline on-dark">Browse Journeys</a>
      </div>
    </div>
  </section>
@endsection
