@php
    $user = auth()->user();
    $cartCount = session('cart_count', 0);
@endphp

<aside class="dashboard-sidebar">
    <div class="sidebar-brand-wrapper">
        <a href="{{ route('home') }}" class="sidebar-brand">
            <img src="{{ asset('images/sm-logo.jpg') }}" alt="SM-SHOP Logo"
                style="width: 50px; height: 50px; object-fit: contain; border-radius: 8px;">
            <div class="brand-text">
                <strong>SM-SHOP</strong>
                <span>Marketplace Console</span>
            </div>
        </a>
    </div>

    <div class="sidebar-content">
        <nav class="sidebar-nav">
            @auth
                @if($user->isSeller())
                    <a class="nav-item {{ request()->routeIs('seller.home') ? 'active' : '' }}"
                        href="{{ route('seller.home') }}">
                        <div class="nav-icon-box"><i data-lucide="house"></i></div>
                        <span>Home</span>
                    </a>
                    <a class="nav-item {{ request()->routeIs('seller.addproduct') ? 'active' : '' }}"
                        href="{{ route('seller.addproduct') }}#product-form-card">
                        <div class="nav-icon-box"><i data-lucide="plus-circle"></i></div>
                        <span>Add Products</span>
                    </a>
                    <a class="nav-item {{ request()->routeIs('seller.sales') ? 'active' : '' }}"
                        href="{{ route('seller.sales') }}">
                        <div class="nav-icon-box"><i data-lucide="shopping-bag"></i></div>
                        <span>Sold Products</span>
                        @php
                            $pendingCount = \App\Models\OrderItem::where('seller_id', $user->id)->where('status', 'pending')->count();
                        @endphp
                        @if($pendingCount > 0)
                            <span class="nav-badge" style="background: #ef4444;">{{ $pendingCount }}</span>
                        @endif
                    </a>
                    <a class="nav-item {{ request()->routeIs('notifications.index') ? 'active' : '' }}"
                        href="{{ route('notifications.index') }}">
                        <div class="nav-icon-box"><i data-lucide="bell"></i></div>
                        <span>Notifications</span>
                        @php
                            $notificationCount = $user->unreadNotifications()->count();
                        @endphp
                        @if($notificationCount > 0)
                            <span class="nav-badge notification-badge" style="background: #f97316;">{{ $notificationCount }}</span>
                        @endif
                    </a>
                @else
                    <a class="nav-item {{ request()->routeIs('buyer.home') && !request()->get('tab') ? 'active' : '' }}"
                        href="{{ route('buyer.home') }}">
                        <div class="nav-icon-box"><i data-lucide="house"></i></div>
                        <span>Home</span>
                    </a>
                    <a class="nav-item {{ request()->get('tab') === 'orders' ? 'active' : '' }}"
                        href="{{ route('buyer.home', ['tab' => 'orders']) }}">
                        <div class="nav-icon-box"><i data-lucide="shopping-bag"></i></div>
                        <span>Orders</span>
                        @php
                            $acceptedOrdersCount = \App\Models\Order::where('buyer_id', $user->id)
                                ->whereNotNull('ordered_at')
                                ->whereIn('status', [
                                    \App\Models\Order::STATUS_PENDING,
                                    \App\Models\Order::STATUS_ACCEPTED,
                                    \App\Models\Order::STATUS_PARTIALLY_ACCEPTED,
                                    \App\Models\Order::STATUS_PREPARING,
                                    \App\Models\Order::STATUS_SHIPPING,
                                ])
                                ->count();
                        @endphp
                        @if($acceptedOrdersCount > 0)
                            <span class="nav-badge" style="background: #22c55e;">{{ $acceptedOrdersCount }}</span>
                        @endif
                    </a>
                    <a class="nav-item {{ request()->get('tab') === 'favorites' ? 'active' : '' }}"
                        href="{{ route('buyer.home', ['tab' => 'favorites']) }}">
                        <div class="nav-icon-box"><i data-lucide="heart"></i></div>
                        <span>Favorites</span>
                        <span id="favoritesCountBadge" class="nav-badge" style="display: none;">0</span>
                    </a>
                    <a class="nav-item {{ request()->routeIs('notifications.index') ? 'active' : '' }}"
                        href="{{ route('notifications.index') }}">
                        <div class="nav-icon-box"><i data-lucide="bell"></i></div>
                        <span>Notifications</span>
                        @php
                            $notificationCount = $user->unreadNotifications()->count();
                        @endphp
                        @if($notificationCount > 0)
                            <span class="nav-badge notification-badge" style="background: #f97316;">{{ $notificationCount }}</span>
                        @endif
                    </a>
                    <a class="nav-item {{ request()->routeIs('buyer.checkout') ? 'active' : '' }}"
                        href="{{ route('buyer.checkout') }}">
                        <div class="nav-icon-box"><i data-lucide="shopping-cart"></i></div>
                        <span>Cart</span>
                        @if(isset($cartCount) && $cartCount > 0)
                            <span class="nav-badge">{{ $cartCount }}</span>
                        @endif
                    </a>
                @endif
            @endauth
        </nav>

        @auth
            <div class="sidebar-section">
                <h4 class="section-title">ACCOUNT</h4>
                <nav class="sidebar-nav">
                    <a class="nav-item {{ (request()->routeIs('seller.profile') || request()->get('tab') === 'profile') ? 'active' : '' }}"
                        href="{{ $user->isSeller() ? route('seller.profile') : route('buyer.home', ['tab' => 'profile']) }}">
                        <div class="nav-icon-box"><i data-lucide="user"></i></div>
                        <span>Profile</span>
                    </a>
                    <a class="nav-item {{ request()->get('tab') === 'settings' ? 'active' : '' }}"
                        href="{{ route('buyer.home', ['tab' => 'settings']) }}">
                        <div class="nav-icon-box"><i data-lucide="settings"></i></div>
                        <span>Settings</span>
                    </a>
                    <a class="nav-item {{ (request()->routeIs('seller.help') || request()->get('tab') === 'help') ? 'active' : '' }}"
                        href="{{ $user->isSeller() ? route('seller.help') : route('buyer.home', ['tab' => 'help']) }}">
                        <div class="nav-icon-box"><i data-lucide="help-circle"></i></div>
                        <span>Help Center</span>
                    </a>
                </nav>
            </div>

            <div
                style="background: #fff8f1; border: 1px solid #ffedd5; border-radius: 20px; padding: 1.5rem; margin-top: 2rem;">
                <div style="color: #f97316; margin-bottom: 0.75rem;"><i data-lucide="crown"></i></div>
                <strong style="display: block; font-size: 0.95rem; color: #0f172a; margin-bottom: 0.5rem;">Grow your
                    business</strong>
                <p style="font-size: 0.8rem; color: #64748b; line-height: 1.5; margin-bottom: 1.25rem;">List quality
                    products and get more customers.</p>
                <a href="#"
                    style="display: block; background: #f97316; color: #fff; text-align: center; padding: 0.75rem; border-radius: 12px; font-weight: 800; font-size: 0.85rem; text-decoration: none;">Learn
                    More</a>
            </div>
        @else
            <div class="guest-card">
                <p>Unlock the full potential of <strong>SM-SHOP</strong>.</p>
                <div class="guest-actions">
                    <a href="{{ route('login') }}" class="btn-login-sidebar">Sign In</a>
                    <a href="{{ route('register') }}" class="btn-register-sidebar">Create Account</a>
                </div>
            </div>
        @endauth
    </div>

    <div class="sidebar-footer">
        @auth
            <div class="user-pill">
                @php
                    $avatarPath = null;
                    foreach (['jpg', 'jpeg', 'png', 'webp'] as $ext) {
                        if (file_exists(public_path('storage/avatars/' . $user->id . '.' . $ext))) {
                            $avatarPath = asset('storage/avatars/' . $user->id . '.' . $ext);
                            break;
                        }
                    }
                @endphp
                <div class="user-avatar"
                    style="{{ $avatarPath ? 'background-image: url(' . $avatarPath . '); background-size: cover; background-position: center;' : '' }}">
                    @if(!$avatarPath)
                        {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                    @endif
                </div>
                <div class="user-details">
                    <strong>{{ $user?->name }}</strong>
                    <span>{{ $user?->email }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin-left: auto;">
                    @csrf
                    <button type="submit" class="mini-logout" title="Logout">
                        <i data-lucide="log-out"></i>
                    </button>
                </form>
            </div>
        @else
            <div class="guest-footer">
                <i data-lucide="info"></i>
                <span>Browsing as Guest</span>
            </div>
        @endauth
    </div>
</aside>

<style>
    :root {
        --sidebar-bg: #ffffff;
        --sidebar-border: rgba(0, 0, 0, 0.05);
        --accent: #f97316;
        --text-main: #0f172a;
        --text-muted: #64748b;
        --nav-hover: #f8fafc;
        --nav-active: #fff7ed;
    }

    .dashboard-sidebar {
        width: 280px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        background: var(--sidebar-bg);
        border-right: 1px solid var(--sidebar-border);
        display: flex;
        flex-direction: column;
        padding: 2rem 1.25rem;
        z-index: 1000;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .sidebar-brand-wrapper {
        margin-bottom: 3rem;
    }

    .sidebar-brand {
        display: flex;
        align-items: center;
        gap: 1rem;
        text-decoration: none;
    }

    .brand-mark {
        width: 44px;
        height: 44px;
        background: #fff7ed;
        color: var(--accent);
        border-radius: 12px;
        display: grid;
        place-items: center;
        font-weight: 900;
        font-size: 1.2rem;
        font-family: 'Outfit', sans-serif;
    }

    .brand-text strong {
        display: block;
        font-size: 1.2rem;
        font-weight: 900;
        color: var(--text-main);
        letter-spacing: -0.02em;
        font-family: 'Outfit', sans-serif;
    }

    .brand-text span {
        font-size: 0.75rem;
        color: var(--text-muted);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .sidebar-content {
        flex: 1;
        overflow-y: auto;
        padding-right: 4px;
    }

    .sidebar-content::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar-content::-webkit-scrollbar-thumb {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .sidebar-nav {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 2.5rem;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.8rem 1rem;
        border-radius: 14px;
        text-decoration: none;
        color: var(--text-muted);
        font-weight: 700;
        font-size: 0.95rem;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .nav-icon-box {
        width: 24px;
        height: 24px;
        display: grid;
        place-items: center;
    }

    .nav-item:hover {
        background: var(--nav-hover);
        color: var(--text-main);
    }

    .nav-item.active {
        background: var(--nav-active);
        color: var(--accent);
    }

    .nav-badge {
        margin-left: auto;
        background: var(--accent);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 2px 8px;
        border-radius: 20px;
    }

    .sidebar-section {
        margin-top: 1rem;
    }

    .section-title {
        font-size: 0.75rem;
        font-weight: 800;
        color: #cbd5e1;
        letter-spacing: 0.1em;
        margin: 0 0 1rem 1rem;
        text-transform: uppercase;
    }

    .special-offer-card {
        background: #fffcf9;
        border: 1px solid #fff1e5;
        border-radius: 20px;
        padding: 1.5rem;
        margin-top: 1rem;
    }

    .offer-icon {
        width: 36px;
        height: 36px;
        background: #fff1e5;
        color: var(--accent);
        border-radius: 10px;
        display: grid;
        place-items: center;
        margin-bottom: 1rem;
    }

    .offer-content strong {
        display: block;
        font-size: 0.95rem;
        color: var(--text-main);
        margin-bottom: 0.2rem;
    }

    .offer-content p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-bottom: 1rem;
    }

    .btn-offer {
        display: block;
        background: var(--accent);
        color: #fff;
        text-align: center;
        padding: 0.75rem;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.9rem;
        text-decoration: none;
    }

    .sidebar-footer {
        margin-top: auto;
        padding-top: 1.5rem;
        border-top: 1px solid var(--sidebar-border);
    }

    .user-pill {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        background: #f8fafc;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
    }

    .user-avatar {
        width: 38px;
        height: 38px;
        background: #fff7ed;
        color: var(--accent);
        border-radius: 10px;
        display: grid;
        place-items: center;
        font-weight: 900;
        font-size: 1rem;
    }

    .user-details strong {
        display: block;
        font-size: 0.85rem;
        color: var(--text-main);
        max-width: 120px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .user-details span {
        display: block;
        font-size: 0.7rem;
        color: var(--text-muted);
        max-width: 120px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .mini-logout {
        border: 1px solid #e2e8f0;
        background: #fff;
        color: #94a3b8;
        cursor: pointer;
        padding: 0.45rem 0.7rem;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .mini-logout:hover {
        color: #ef4444;
        border-color: #fecaca;
        background: #fff5f5;
    }

    @media (max-width: 1024px) {
        .dashboard-sidebar {
            display: none;
        }
    }
</style>
