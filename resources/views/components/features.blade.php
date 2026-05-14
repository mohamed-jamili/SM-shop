<section class="features-premium" id="features">
  <div class="features-container">
    <div class="features-header">
      <span class="section-badge">{{ __('Premium Features') }}</span>
      <h2 class="section-title">{{ __('Everything you need') }} <br /><span>{{ __('to grow your business.') }}</span>
      </h2>
      <p class="section-subtitle">{{ __('A suite of powerful tools designed for speed, scale, and performance.') }}</p>
    </div>

    <div class="features-grid-pro">
      <!-- Feature 1 -->
      <div class="feature-card-pro">
        <div class="feature-icon-wrapper">
          <i data-lucide="rocket"></i>
        </div>
        <h3 class="feature-card-title">{{ __('Instant Setup') }}</h3>
        <p class="feature-card-desc">
          {{ __('Launch your global store in under 60 seconds with AI-powered automation.') }}
        </p>
      </div>

      <!-- Feature 2 -->
      <div class="feature-card-pro">
        <div class="feature-icon-wrapper">
          <i data-lucide="bar-chart-2"></i>
        </div>
        <h3 class="feature-card-title">{{ __('Smart Analytics') }}</h3>
        <p class="feature-card-desc">{{ __('Understand your customers instantly with real-time insights.') }}</p>
      </div>

      <!-- Feature 3 -->
      <div class="feature-card-pro">
        <div class="feature-icon-wrapper">
          <i data-lucide="credit-card"></i>
        </div>
        <h3 class="feature-card-title">{{ __('Secure Payments') }}</h3>
        <p class="feature-card-desc">{{ __('Accept payments in 150+ currencies with enterprise-grade security.') }}</p>
      </div>

      <!-- Feature 4 -->
      <div class="feature-card-pro">
        <div class="feature-icon-wrapper">
          <i data-lucide="globe"></i>
        </div>
        <h3 class="feature-card-title">{{ __('Global Scale') }}</h3>
        <p class="feature-card-desc">{{ __('Ship internationally with localized checkout handled automatically.') }}</p>
      </div>

      <!-- Feature 5 -->
      <div class="feature-card-pro">
        <div class="feature-icon-wrapper">
          <i data-lucide="zap"></i>
        </div>
        <h3 class="feature-card-title">{{ __('Ultra Speed') }}</h3>
        <p class="feature-card-desc">
          {{ __('Enjoy the fastest mobile shopping experience with perfect Lighthouse scores.') }}
        </p>
      </div>

      <!-- Feature 6 -->
      <div class="feature-card-pro">
        <div class="feature-icon-wrapper">
          <i data-lucide="layers"></i>
        </div>
        <h3 class="feature-card-title">{{ __('Edge Commerce') }}</h3>
        <p class="feature-card-desc">
          {{ __('Scale instantly with serverless architecture that grows with your traffic.') }}
        </p>
      </div>
    </div>
  </div>

  <style>
    .features-premium {
      padding: 4rem 2rem;
      background: transparent !important;
    }

    .features-container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .features-header {
      text-align: center;
      margin-bottom: 4rem;
    }

    .section-badge {
      display: inline-block;
      background: rgba(167, 139, 250, 0.1);
      color: var(--accent);
      padding: 0.4rem 1rem;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
      margin-bottom: 1.5rem;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }

    .section-title {
      font-size: clamp(1.75rem, 4vw, 2.5rem);
      color: var(--text-primary);
      margin-bottom: 1rem;
      line-height: 1.2;
    }

    .section-title span {
      background: linear-gradient(90deg, #d97706, #b45309);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .section-subtitle {
      font-size: 1rem;
      color: var(--text-muted);
      max-width: 500px;
      margin: 0 auto;
    }

    .features-grid-pro {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
    }

    .feature-card-pro {
      background: rgba(255, 255, 255, 0.7);
      border: 1px solid rgba(0, 0, 0, 0.05);
      border-radius: 12px;
      padding: 2.5rem 2rem;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .feature-card-pro:hover {
      background: rgba(217, 119, 6, 0.05);
      border-color: rgba(217, 119, 6, 0.2);
      transform: translateY(-5px);
    }

    .feature-icon-wrapper {
      width: 50px;
      height: 50px;
      background: linear-gradient(135deg, #d97706, #b45309);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.5rem;
      color: #fff;
    }

    .feature-icon-wrapper i {
      width: 24px;
      height: 24px;
    }

    .feature-card-title {
      font-size: 1.1rem;
      font-weight: 600;
      margin-bottom: 0.8rem;
      color: var(--text-primary);
    }

    .feature-card-desc {
      font-size: 0.9rem;
      color: var(--text-muted);
      line-height: 1.6;
      margin: 0;
    }

    body.light-mode .feature-card-pro {
      background: rgba(0, 0, 0, 0.02);
      border-color: rgba(0, 0, 0, 0.08);
    }

    body.light-mode .feature-card-pro:hover {
      background: rgba(167, 139, 250, 0.08);
      border-color: rgba(167, 139, 250, 0.2);
    }

    @media (max-width: 768px) {
      .features-premium {
        padding: 3rem 1.5rem;
      }

      .features-header {
        margin-bottom: 3rem;
      }

      .features-grid-pro {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
      }

      .feature-card-pro {
        padding: 2rem 1.5rem;
      }
    }

    @media (max-width: 480px) {
      .features-premium {
        padding: 2rem 1rem;
      }

      .features-header {
        margin-bottom: 2rem;
      }

      .features-grid-pro {
        grid-template-columns: 1fr;
      }

      .section-title {
        font-size: 1.5rem;
      }

      .section-subtitle {
        font-size: 0.9rem;
      }
    }
  </style>
</section>