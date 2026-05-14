<section class="trusted-brands reveal">
  <div class="trusted-pill">
    <p class="brands-label">TRUSTED BY ENTREPRENEURS WORLDWIDE</p>
    <div class="brands-track">
      <div class="brand-item"><i data-lucide="send"></i> Acme</div>
      <div class="brand-item"><i data-lucide="circle-dashed"></i> circle</div>
      <div class="brand-item"><i data-lucide="cloud"></i> cloud</div>
      <div class="brand-item"><i data-lucide="zap"></i> Boltshift</div>
      <div class="brand-item"><i data-lucide="triangle"></i> Volt</div>
      <div class="brand-item"><i data-lucide="box"></i> Spherule</div>
    </div>
  </div>
</section>

<style>
  .trusted-brands {
    padding: 3rem 0;
    display: flex;
    justify-content: center;
    background: transparent;
  }

  .trusted-pill {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(0, 0, 0, 0.05);
    border-radius: 24px;
    padding: 2rem 4rem;
    max-width: 1200px;
    width: 90%;
  }

  body.light-mode .trusted-pill {
    background: rgba(0, 0, 0, 0.02);
    border: 1px solid rgba(0, 0, 0, 0.05);
  }

  .brands-label {
    text-align: center;
    color: #555;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 2rem;
  }

  .brands-track {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
  }

  .brand-item {
    font-size: 1.2rem;
    font-weight: 600;
    color: #777;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: color 0.3s;
  }

  .brand-item i {
    width: 20px;
    height: 20px;
  }

  body.light-mode .brand-item {
    color: #888;
  }

  .brand-item:hover {
    color: var(--accent);
  }
</style>