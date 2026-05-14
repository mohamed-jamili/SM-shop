<section class="marquee-premium">
  <div class="marquee-header">
    <p>Join hundreds of creators already selling online.</p>
  </div>

  <div class="marquee-wrapper">
    <div class="marquee-content">
      <div class="marquee-track">
        @php
          $sponsors = ['LANE', 'Glossier.', 'JB HI-FI', 'MATTEL', 'Quiksilver', 'staples', 'DOLLAR SHAVE CLUB'];
        @endphp
        
        {{-- Repeat twice for infinite effect --}}
        @foreach(array_merge($sponsors, $sponsors) as $name)
          <div class="marquee-item">
            {{ $name }}
          </div>
        @endforeach
      </div>
    </div>

    <!-- Gradient Fades -->
    <div class="marquee-fade-left"></div>
    <div class="marquee-fade-right"></div>
  </div>
</section>
