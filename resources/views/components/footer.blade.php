<footer class="footer-premium">
  <div class="footer-container">
    <div class="footer-grid">
      <!-- Col 1 -->
      <div class="footer-col">
        <h3 class="auth-logo" style="font-size: 1.5rem; margin-bottom: 1.5rem;">SM-<span>SHOP</span></h3>
        <p style="color: var(--text-muted); margin-bottom: 2rem; line-height: 1.6;">
          SM-SHOP helps you create your online store, reach customers, and grow your business with ease.
        </p>
        <div style="display: flex; gap: 1rem;">
          <a href="#" style="color: var(--accent);"><i data-lucide="instagram"></i></a>
          <a href="#" style="color: var(--accent);"><i data-lucide="twitter"></i></a>
          <a href="#" style="color: var(--accent);"><i data-lucide="linkedin"></i></a>
        </div>
      </div>

      <!-- Col 2 -->
      <div class="footer-col">
        <h4 style="margin-bottom: 2rem; font-weight: 800;">Platform</h4>
        <ul style="list-style: none; display: flex; flex-direction: column; gap: 1rem;">
          <li><a href="#" class="link-item no-underline">Pricing</a></li>
          <li><a href="#" class="link-item no-underline">Enterprises</a></li>
          <li><a href="#" class="link-item no-underline">Features</a></li>
          <li><a href="#" class="link-item no-underline">Security</a></li>
        </ul>
      </div>

      <!-- Col 3 -->
      <div class="footer-col">
        <h4 style="margin-bottom: 2rem; font-weight: 800;">Company</h4>
        <ul style="list-style: none; display: flex; flex-direction: column; gap: 1rem;">
          <li><a href="#" class="link-item no-underline">About Us</a></li>
          <li><a href="#" class="link-item no-underline">Careers</a></li>
          <li><a href="#" class="link-item no-underline">Privacy Policy</a></li>
          <li><a href="#" class="link-item no-underline">Terms of Service</a></li>
        </ul>
      </div>

      <!-- Col 4 -->
      <div class="footer-col">
        <h4 style="margin-bottom: 2rem; font-weight: 800;">Contact</h4>
        <div style="color: var(--text-muted); line-height: 1.8;">
          <p style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.8rem;">
            <i data-lucide="mail" size="16"></i> 
            <a href="mailto:contact@sm-shop.com" style="color: inherit; text-decoration: none;">contact@smâ€‘shop.com</a>
          </p>
          <p style="display: flex; align-items: center; gap: 0.5rem;">
            <i data-lucide="phone" size="16"></i> 
            <a href="tel:+212600123456" style="color: inherit; text-decoration: none;">+212 600 123 456</a>
          </p>
        </div>
      </div>
    </div>

    <div style="margin-top: 5rem; padding-top: 2rem; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; color: var(--text-muted); font-size: 0.9rem;">
      <p>&copy; 2026 SM-SHOP Inc. All rights reserved.</p>
      <div style="display: flex; gap: 2rem;">
        <a href="#" style="color: #000; text-decoration: none; opacity: 0.7;">Privacy Policy</a>
        <a href="#" style="color: #000; text-decoration: none; opacity: 0.7;">Terms of Service</a>
      </div>
    </div>
  </div>
</footer>

<style>
  .no-underline {
    text-decoration: none !important;
  }
  .footer-premium {
    background: transparent !important;
    border-top: 1px solid var(--border-color);
    padding: 4rem 2rem 2rem;
    color: var(--text-primary);
  }

  .footer-container {
    max-width: 1200px;
    margin: 0 auto;
  }

  .footer-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 3rem;
    margin-bottom: 3rem;
  }

  .footer-col {
    display: flex;
    flex-direction: column;
  }

  @media (max-width: 768px) {
    .footer-grid {
      gap: 2rem;
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 480px) {
    .footer-grid {
      grid-template-columns: 1fr;
    }
  }
</style>

