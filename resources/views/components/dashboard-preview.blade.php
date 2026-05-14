<section class="dashboard-preview-section">
  <div class="preview-container">
    <div class="preview-text reveal">
      <span class="section-badge">Command Center</span>
      <h2 class="section-title">A dashboard that <br /><span>does the work for you.</span></h2>
      <p class="section-subtitle">Manage inventory, fulfill orders, and track global growth from a single, beautiful
        interface.</p>
    </div>

    <div class="mockup-stage reveal" style="transition-delay: 0.2s">
      <div class="main-mockup">
        <!-- Mockup Header -->
        <div class="mockup-nav">
          <div class="dot-group">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
          </div>
          <div class="mockup-search"></div>
        </div>

        <!-- Mockup Sidebar -->
        <div class="mockup-layout">
          <div class="mockup-side">
            <div class="side-item active"></div>
            @for ($i = 0; $i < 4; $i++)
              <div class="side-item"></div>
            @endfor
          </div>

          <!-- Mockup Content -->
          <div class="mockup-main">
            <div class="mockup-stats-row">
              @for ($i = 0; $i < 4; $i++)
                <div class="mockup-stat-card">
                  <div class="stat-loading-sm"></div>
                  <div class="stat-loading-lg"></div>
                </div>
              @endfor
            </div>
            <div class="mockup-chart-large">
              <div class="chart-line-bg"></div>
              <div class="chart-glow-line" style="width: 80%;"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Floating Widget 1 -->
      <div class="floating-widget widget-sales reveal" style="transition-delay: 0.5s">
        <div class="widget-icon"><i data-lucide="dollar-sign"></i></div>
        <div class="widget-info">
          <span>Total Revenue</span>
          <strong>$42,890</strong>
        </div>
      </div>

      <!-- Floating Widget 2 -->
      <div class="floating-widget widget-growth reveal" style="transition-delay: 0.7s">
        <div class="widget-icon growth"><i data-lucide="bar-chart"></i></div>
        <div class="widget-info">
          <span>Customer Growth</span>
          <strong>+12.4%</strong>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  .dashboard-preview-section {
    padding: 6rem 2rem;
    overflow: hidden;
  }

  .preview-container {
    max-width: 1200px;
    margin: 0 auto;
  }

  .preview-text {
    text-align: center;
    margin-bottom: 5rem;
  }

  .mockup-stage {
    position: relative;
    max-width: 1000px;
    margin: 0 auto;
  }

  .main-mockup {
    background: #fff;
    border-radius: 24px;
    border: 1px solid rgba(0, 0, 0, 0.08);
    box-shadow: 0 40px 100px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    position: relative;
    z-index: 1;
  }

  .mockup-nav {
    height: 50px;
    background: #fdfaf6;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    display: flex;
    align-items: center;
    padding: 0 1.5rem;
    justify-content: space-between;
  }

  .dot-group {
    display: flex;
    gap: 6px;
  }

  .dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.1);
  }

  .mockup-search {
    width: 200px;
    height: 24px;
    background: rgba(0, 0, 0, 0.03);
    border-radius: 6px;
  }

  .mockup-layout {
    display: flex;
    height: 500px;
  }

  .mockup-side {
    width: 200px;
    border-right: 1px solid rgba(0, 0, 0, 0.05);
    padding: 2rem 1.2rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    background: #fdfaf6;
  }

  .side-item {
    height: 12px;
    border-radius: 4px;
    background: rgba(0, 0, 0, 0.04);
  }

  .side-item.active {
    background: var(--accent);
    width: 80%;
  }

  .mockup-main {
    flex: 1;
    padding: 2.5rem;
    background: #fff;
  }

  .mockup-stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    margin-bottom: 2.5rem;
  }

  .mockup-stat-card {
    padding: 1.5rem;
    border-radius: 16px;
    background: #fdfaf6;
    border: 1px solid rgba(0, 0, 0, 0.04);
  }

  .stat-loading-sm {
    height: 10px;
    width: 40%;
    background: rgba(0, 0, 0, 0.04);
    margin-bottom: 10px;
    border-radius: 4px;
  }

  .stat-loading-lg {
    height: 16px;
    width: 70%;
    background: rgba(0, 0, 0, 0.06);
    border-radius: 4px;
  }

  .mockup-chart-large {
    height: 250px;
    background: #fdfaf6;
    border-radius: 20px;
    border: 1px solid rgba(0, 0, 0, 0.04);
    position: relative;
    overflow: hidden;
  }

  .chart-glow-line {
    position: absolute;
    bottom: 40%;
    left: 0;
    height: 3px;
    background: linear-gradient(90deg, transparent, var(--accent), transparent);
    box-shadow: 0 0 20px rgba(217, 119, 6, 0.3);
  }

  .floating-widget {
    position: absolute;
    background: #fff;
    padding: 1.2rem 1.8rem;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 1.2rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.04);
    z-index: 10;
  }

  .widget-sales {
    top: 15%;
    right: -40px;
  }

  .widget-growth {
    bottom: 20%;
    left: -40px;
  }

  .widget-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: rgba(217, 119, 6, 0.1);
    color: var(--accent-deep);
    display: grid;
    place-items: center;
  }

  .widget-info span {
    display: block;
    font-size: 0.8rem;
    color: var(--text-muted);
    font-weight: 600;
  }

  .widget-info strong {
    font-size: 1.2rem;
    color: #000;
    font-weight: 800;
  }

  @keyframes floatSoft {

    0%,
    100% {
      transform: translateY(0);
    }

    50% {
      transform: translateY(-15px);
    }
  }

  .floating-widget {
    animation: floatSoft 8s ease-in-out infinite;
  }
</style>