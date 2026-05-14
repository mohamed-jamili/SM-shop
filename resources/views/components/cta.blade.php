<section class="cta-luxe reveal">
  <div class="cta-glow-bg"></div>
  <div class="cta-container">
    <div class="cta-card">
      <div class="cta-badge">Ready to Start?</div>
      <h2 class="cta-title">Start your business today. <br /><span style="color: #f97316;">no limits</span></h2>
      <p class="cta-subtitle">Join 1M+ merchants who are scaling their brands globally with SM-SHOP. no credit card
        required</p>

      <div class="cta-actions">
        <a href="{{ route('register') }}" class="btn-cta-gold">Get Started</a>
      </div>
    </div>
  </div>
</section>

<style>
  .cta-luxe {
    padding: 10rem 4rem;
    position: relative;
    overflow: hidden;
    background: transparent;
  }

  body.light-mode .cta-luxe {
    background: #fff;
  }

  .cta-glow-bg {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(217, 119, 6, 0.08) 0%, transparent 70%);
    filter: blur(60px);
    z-index: 1;
    pointer-events: none;
    animation: pulseGlow 10s ease-in-out infinite;
  }

  .cta-container {
    max-width: 1200px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
  }

  .cta-card {
    background: rgba(255, 255, 255, 0.7);
    border: 1px solid rgba(0, 0, 0, 0.05);
    backdrop-filter: blur(20px);
    padding: 6rem;
    border-radius: 40px;
    text-align: center;
    color: #000;
  }

  body.light-mode .cta-card {
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.02) 0%, rgba(0, 0, 0, 0.01) 100%);
    border: 1px solid rgba(0, 0, 0, 0.05);
    color: #000;
  }

  .cta-badge {
    display: inline-block;
    padding: 0.6rem 1.5rem;
    background: rgba(255, 215, 0, 0.1);
    color: var(--accent);
    border-radius: 0;
    font-size: 0.85rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 2rem;
  }

  .cta-title {
    font-size: 4rem;
    font-weight: 950;
    line-height: 1.1;
    letter-spacing: -2px;
    margin-bottom: 1.5rem;
  }

  .cta-title span {
    color: var(--accent);
  }

  .cta-subtitle {
    font-size: 1.3rem;
    color: var(--text-muted);
    max-width: 600px;
    margin: 0 auto 4rem;
    font-weight: 500;
  }

  .cta-actions {
    display: flex;
    justify-content: center;
    gap: 2rem;
  }

  .btn-cta-gold {
    background: #f97316;
    color: #fff;
    padding: 1rem 3.5rem;
    border-radius: 14px;
    text-decoration: none;
    font-weight: 800;
    font-size: 1.1rem;
    transition: all 0.3s;
    box-shadow: 0 10px 25px rgba(249, 115, 22, 0.25);
  }

  .btn-cta-gold:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(217, 119, 6, 0.3);
  }

  .btn-cta-outline {
    background: transparent;
    border: 1px solid #333;
    color: #fff;
    padding: 1.2rem 3rem;
    border-radius: 0;
    text-decoration: none;
    font-weight: 900;
    font-size: 1.1rem;
    transition: all 0.3s;
  }

  body.light-mode .btn-cta-outline {
    color: #000;
    border-color: #eee;
  }

  .btn-cta-outline:hover {
    border-color: #fff;
  }

  body.light-mode .btn-cta-outline:hover {
    background: #000;
    color: #fff;
  }
</style>