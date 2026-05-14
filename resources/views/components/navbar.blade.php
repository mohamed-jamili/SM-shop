<nav class="pro-navbar" id="main-nav">
  <div class="nav-container">
    <div class="nav-top">
      <div class="nav-left">
        <div class="logo">
          <img src="{{ asset('images/sm-logo.jpg') }}" alt="SM-SHOP Logo"
            style="width: 40px; height: 40px; object-fit: contain; border-radius: 6px;">
          <span>SM-SHOP</span>
        </div>
      </div>

      <div class="nav-center">
        <div class="nav-links">
          <a href="#features">Features</a>
          <a href="#enterprise">Enterprise</a>
          <a href="#pricing">Pricing</a>
          <div class="pro-dropdown" id="navResourcesDropdown">
            <a href="javascript:void(0)" class="drop-trigger" onclick="toggleDropdown('navResourcesMenu')">
              Resources <i data-lucide="chevron-down" style="width: 14px; height: 14px;"></i>
            </a>
            <div class="pro-dropdown-menu" id="navResourcesMenu" style="left: 0; right: auto;">
              <a href="#" class="pro-dropdown-item">Documentation</a>
              <a href="#" class="pro-dropdown-item">API Reference</a>
              <a href="#" class="pro-dropdown-item">Community</a>
            </div>
          </div>
        </div>
      </div>

      <div class="nav-right">
        @guest
          <a href="{{ route('login') }}" class="login-link">Login</a>
          <a href="{{ route('register') }}" class="btn-get-started">Get Started</a>
        @else
          <a href="{{ route('dashboard') }}" class="login-link">Dashboard</a>
          <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-logout-nav">
              Logout
            </button>
          </form>
        @endguest
      </div>
    </div>
  </div>
</nav>

<script>
  function toggleDropdown(id) {
    const menu = document.getElementById(id);
    const isOpen = menu.classList.contains('show');
    document.querySelectorAll('.pro-dropdown-menu').forEach(m => m.classList.remove('show'));
    if (!isOpen) menu.classList.add('show');
  }

  function applyNavSort(val) {
    document.getElementById('navSortInput').value = val;
    document.getElementById('navSortForm').submit();
  }

  window.addEventListener('click', (e) => {
    if (!e.target.closest('.pro-dropdown')) {
      document.querySelectorAll('.pro-dropdown-menu').forEach(m => m.classList.remove('show'));
    }
  });
</script>

<style>
  .pro-navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 2000;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(15px);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.4s;
    color: #0f172a;
    font-family: 'Plus Jakarta Sans', sans-serif;
  }

  .nav-container {
    max-width: 1440px;
    margin: 0 auto;
    padding: 0 4rem;
    display: flex;
    flex-direction: column;
  }

  .nav-top {
    display: grid;
    grid-template-columns: 1fr auto 1fr;
    align-items: center;
    padding: 1rem 0;
  }

  .logo {
    display: flex;
    align-items: center;
    gap: 0.7rem;
    font-size: 1.4rem;
    font-weight: 900;
    color: #0f172a;
    font-family: 'Outfit', sans-serif;
    letter-spacing: -0.02em;
  }

  .logo-icon {
    color: #f97316;
    width: 28px;
    height: 28px;
  }

  .nav-links {
    display: flex;
    align-items: center;
    gap: 2.5rem;
  }

  .nav-links a {
    text-decoration: none;
    color: #475569;
    font-weight: 700;
    font-size: 0.95rem;
    transition: all 0.2s;
  }

  .nav-links a:hover {
    color: #f97316;
  }

  .nav-right {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    justify-content: flex-end;
  }

  .login-link {
    font-weight: 700;
    color: #475569;
    text-decoration: none;
    transition: color 0.2s;
  }

  .login-link:hover {
    color: #0f172a;
  }

  .btn-get-started {
    text-decoration: none;
    background: #0f172a;
    color: #fff;
    padding: 0.8rem 1.8rem;
    border-radius: 14px;
    font-weight: 800;
    font-size: 0.9rem;
    transition: all 0.3s;
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.1);
  }

  .btn-get-started:hover {
    background: #f97316;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(249, 115, 22, 0.2);
  }

  .btn-logout-nav {
    border: 1px solid #e2e8f0;
    background: #fff;
    color: #0f172a;
    padding: 0.8rem 1.2rem;
    border-radius: 14px;
    font-weight: 800;
    font-size: 0.9rem;
    transition: all 0.3s;
  }

  .btn-logout-nav:hover {
    border-color: #f97316;
    color: #f97316;
    transform: translateY(-2px);
  }

  .pro-dropdown {
    position: relative;
  }

  .pro-dropdown-menu {
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    background: #fff;
    border: 1px solid #f1f1f1;
    border-radius: 16px;
    padding: 0.6rem;
    min-width: 220px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
    display: none;
    z-index: 3000;
    animation: dropdownPop 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  }

  .pro-dropdown-menu.show {
    display: block;
  }

  @keyframes dropdownPop {
    from {
      opacity: 0;
      transform: scale(0.95) translateY(-10px);
    }

    to {
      opacity: 1;
      transform: scale(1) translateY(0);
    }
  }

  .pro-dropdown-item {
    padding: 0.8rem 1.2rem;
    border-radius: 12px;
    font-size: 0.95rem;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    display: block;
  }

  .pro-dropdown-item:hover {
    background: #f8fafc;
    color: #f97316;
  }

  @media (max-width: 1024px) {
    .nav-links {
      display: none;
    }

    .nav-container {
      padding: 0 1.5rem;
    }
  }
</style>
