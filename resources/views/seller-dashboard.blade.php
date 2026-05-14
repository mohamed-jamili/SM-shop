@extends('layouts.app')

@php
    $isEditing = (bool) $editingProduct;
    $productFormAction = $isEditing ? route('seller.products.update', $editingProduct) : route('seller.products.store');
@endphp

@section('title', 'SM-SHOP | Seller Dashboard')

@push('styles')
    <style>
        :root {
            --sidebar-width: 280px;
            --surface-bg: #fdfcfb;
            --card-bg: #ffffff;
            --border-subtle: #f1f5f9;
            --text-main: #0f172a;
            --text-secondary: #64748b;
            --accent-brand: #f97316;
            --accent-soft: #fff7ed;
        }

        .dashboard-shell {
            min-height: 100vh;
            background: var(--surface-bg);
        }

        .dashboard-main {
            margin-left: var(--sidebar-width);
            padding: 2.5rem;
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 1rem;
            margin-bottom: 2.5rem;
        }

        .header-content h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0 0 0.5rem;
            letter-spacing: -0.02em;
        }

        .header-content p {
            color: var(--text-secondary);
            font-size: 1rem;
            margin: 0;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .notification-action {
            position: relative;
            display: grid;
            place-items: center;
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: #fff;
            border: 1px solid #e2e8f0;
            color: #111;
            transition: all 0.2s ease;
        }

        .notification-action:hover {
            border-color: #f97316;
            color: #f97316;
        }

        .notification-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            background: #f97316;
            color: #fff;
            font-size: 0.72rem;
            font-weight: 800;
            border-radius: 999px;
            border: 2px solid #fff;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card-pro,
        .data-card,
        .alert-panel,
        .workspace-card {
            background: var(--card-bg);
            border: 1px solid var(--border-subtle);
            border-radius: 24px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01);
        }

        .stat-card-pro {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card-pro:hover,
        .alert-panel:hover {
            border-color: var(--accent-brand);
            transform: translateY(-2px);
        }

        .stat-card-header,
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-icon-wrap {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--accent-soft);
            color: var(--accent-brand);
            display: grid;
            place-items: center;
        }

        /* Color Picker Styles */
        .color-checkbox:checked + .color-circle {
            transform: scale(1.2);
            border-color: #f97316 !important;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
        }

        .color-checkbox-wrapper:hover .color-circle {
            transform: scale(1.1);
        }
            display: grid;
            place-items: center;
        }

        .stat-value {
            font-family: 'Outfit', sans-serif;
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
        }

        .stat-badge,
        .pill,
        .discount-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 999px;
        }

        .stat-badge {
            padding: 0.35rem 0.65rem;
        }

        .stat-badge.up {
            background: #f0fdf4;
            color: #16a34a;
        }

        .data-card {
            overflow: hidden;
        }

        .card-header {
            padding: 1.75rem 2rem;
            border-bottom: 1px solid var(--border-subtle);
        }

        .card-header h2,
        .alert-panel h3,
        .import-card h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.2rem;
            font-weight: 800;
            margin: 0;
            color: var(--text-main);
        }

        .saas-table {
            width: 100%;
            border-collapse: collapse;
        }

        .saas-table th {
            text-align: left;
            padding: 1rem 2rem;
            background: #fafafa;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .saas-table td {
            padding: 1.25rem 2rem;
            border-bottom: 1px solid var(--border-subtle);
            vertical-align: middle;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .product-thumb {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid var(--border-subtle);
        }

        .product-meta h4 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0 0 0.2rem;
        }

        .product-meta span {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .pill {
            padding: 0.4rem 0.8rem;
        }

        .pill-success {
            background: #f0fdf4;
            color: #16a34a;
        }

        .pill-warning {
            background: #fffbeb;
            color: #b45309;
        }

        .pill-danger {
            background: #fef2f2;
            color: #ef4444;
        }

        .pill-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .action-group {
            display: flex;
            gap: 0.5rem;
        }

        .btn-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            border: 1px solid var(--border-subtle);
            background: #fff;
            color: var(--text-secondary);
            display: grid;
            place-items: center;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-icon:hover {
            border-color: var(--accent-brand);
            color: var(--accent-brand);
            background: var(--accent-soft);
        }

        .btn-saas-primary {
            background: var(--accent-brand);
            color: #fff;
            padding: 0.75rem 1.35rem;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2);
        }

        .btn-saas-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(249, 115, 22, 0.3);
        }

        .alert-grid {
            display: grid;
            grid-template-columns: 1.15fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .alert-panel {
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .alert-panel p,
        .import-card p {
            margin: 0;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .alert-list {
            display: grid;
            gap: 0.85rem;
            margin-top: 1.25rem;
        }

        .alert-item {
            border: 1px solid #ffedd5;
            background: #fffaf5;
            border-radius: 18px;
            padding: 1rem 1.1rem;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            align-items: center;
        }

        .price-stack {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .price-current {
            font-weight: 800;
            color: var(--text-main);
        }

        .price-old {
            color: #94a3b8;
            text-decoration: line-through;
            font-size: 0.8rem;
        }

        .discount-chip {
            padding: 0.2rem 0.55rem;
            background: #fff7ed;
            color: #ea580c;
            width: fit-content;
        }

        .add-product-workspace {
            padding: 1rem;
        }

        .workspace-card {
            max-width: 1200px;
            margin: 0 auto;
            overflow: hidden;
        }

        .form-section {
            padding: 2.5rem;
        }

        .input-pro-group {
            margin-bottom: 1.5rem;
        }

        .input-pro-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.6rem;
        }

        .input-pro {
            width: 100%;
            background: #fcfcfd;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            color: var(--text-main);
            transition: all 0.2s;
        }

        .input-pro:focus {
            outline: none;
            border-color: var(--accent-brand);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.08);
        }

        .import-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            padding: 0 2.5rem 1rem;
        }

        .import-card {
            background: #fffaf5;
            border: 1px solid #fed7aa;
            border-radius: 20px;
            padding: 1.5rem;
        }

        @media (max-width: 1280px) {
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 1100px) {
            .alert-grid,
            .import-grid,
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 1024px) {
            .dashboard-main {
                margin-left: 0;
                padding: 1.5rem;
            }

            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 700px) {
            .stats-row {
                grid-template-columns: 1fr;
            }

            .saas-table th,
            .saas-table td,
            .card-header,
            .form-section {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-shell">
        <x-sidebar />

        <main class="dashboard-main">
            @if (!request()->routeIs('seller.addproduct') && !$editingProduct)
                <header class="dashboard-header">
                    <div class="header-content">
                        <p>Welcome back, {{ auth()->user()->name }}</p>
                        <h1>Seller Dashboard</h1>
                        <p>Track your business growth and manage your inventory in real-time.</p>
                    </div>

                    <div class="header-actions">
                        <a href="{{ route('notifications.index') }}" class="notification-action" title="View notifications">
                            <i data-lucide="bell" style="width: 20px; height: 20px;"></i>
                            @if(auth()->user()->unreadNotifications()->count() > 0)
                                <span class="notification-badge">{{ auth()->user()->unreadNotifications()->count() }}</span>
                            @endif
                        </a>
                        <div class="stat-badge up" style="padding: 0.6rem 1rem; background: #fff; border: 1px solid var(--border-subtle);">
                            <i data-lucide="shield-check" style="width: 18px;"></i>
                            <span>Verified Seller Account</span>
                        </div>
                    </div>
                </header>

                <div class="stats-row">
                    <div class="stat-card-pro">
                        <div class="stat-card-header">
                            <span class="stat-label">Active Products</span>
                            <div class="stat-icon-wrap"><i data-lucide="package" size="20"></i></div>
                        </div>
                        <h2 class="stat-value">{{ $stats['active_products'] }}</h2>
                        <div class="stat-badge up">
                            <i data-lucide="list-checks" size="14"></i>
                            <span>Available Now</span>
                        </div>
                    </div>

                    <div class="stat-card-pro">
                        <div class="stat-card-header">
                            <span class="stat-label">Pending Orders</span>
                            <div class="stat-icon-wrap" style="background: #eff6ff; color: #3b82f6;"><i data-lucide="shopping-cart" size="20"></i></div>
                        </div>
                        <h2 class="stat-value">{{ $stats['pending_order_items'] }}</h2>
                        <div class="stat-badge up" style="background: #eff6ff; color: #3b82f6;">
                            <i data-lucide="info" size="14"></i>
                            <span>Awaiting Action</span>
                        </div>
                    </div>

                    <div class="stat-card-pro">
                        <div class="stat-card-header">
                            <span class="stat-label">Inventory Value</span>
                            <div class="stat-icon-wrap" style="background: #f0fdf4; color: #16a34a;"><i data-lucide="dollar-sign" size="20"></i></div>
                        </div>
                        <h2 class="stat-value">${{ number_format($stats['inventory_value'], 2) }}</h2>
                        <div class="stat-badge up">
                            <i data-lucide="badge-dollar-sign" size="14"></i>
                            <span>Discount Aware</span>
                        </div>
                    </div>

                    <div class="stat-card-pro">
                        <div class="stat-card-header">
                            <span class="stat-label">Accepted Revenue</span>
                            <div class="stat-icon-wrap" style="background: #faf5ff; color: #a855f7;"><i data-lucide="credit-card" size="20"></i></div>
                        </div>
                        <h2 class="stat-value">${{ number_format($stats['accepted_revenue'], 2) }}</h2>
                        <div class="stat-badge up" style="background: #faf5ff; color: #a855f7;">
                            <i data-lucide="trending-up" size="14"></i>
                            <span>Confirmed Sales</span>
                        </div>
                    </div>
                </div>

                <div class="alert-grid">
                    <section class="alert-panel">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem;">
                            <div>
                                <h3>Low Stock Products</h3>
                                <p>Alerts are based on the minimum stock value configured per product.</p>
                            </div>
                            <span class="pill pill-warning"><span class="pill-dot"></span> {{ $lowStockProducts->count() }} alert{{ $lowStockProducts->count() === 1 ? '' : 's' }}</span>
                        </div>

                        <div class="alert-list">
                            @forelse($lowStockProducts->take(5) as $product)
                                <div class="alert-item">
                                    <div>
                                        <strong style="display: block; color: var(--text-main);">{{ $product->name }}</strong>
                                        <span style="color: var(--text-secondary); font-size: 0.84rem;">
                                            {{ $product->stock }} left, minimum stock {{ $product->minimum_stock }}
                                        </span>
                                    </div>
                                    <a href="{{ route('seller.home', ['edit' => $product->id]) }}#product-form-card" class="btn-icon" title="Update product">
                                        <i data-lucide="pencil" size="14"></i>
                                    </a>
                                </div>
                            @empty
                                <div class="alert-item" style="background: #fff; border-style: dashed;">
                                    <span style="color: var(--text-secondary); font-size: 0.9rem;">No products are currently below their configured minimum stock.</span>
                                </div>
                            @endforelse
                        </div>
                    </section>

                    <section class="alert-panel">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem;">
                            <div>
                                <h3>Recent Stock Notifications</h3>
                                <p>Automatic Laravel notifications created after qualifying purchases.</p>
                            </div>
                            <span class="pill pill-success"><span class="pill-dot"></span> {{ $unreadLowStockNotifications }} unread</span>
                        </div>

                        <div class="alert-list">
                            @forelse($lowStockNotifications as $notification)
                                <div class="alert-item" style="{{ $notification->read_at ? 'background: #fff; border-color: #e2e8f0;' : '' }}">
                                    <div>
                                        <strong style="display: block; color: var(--text-main);">{{ $notification->data['product_name'] ?? 'Stock alert' }}</strong>
                                        <span style="display: block; color: var(--text-secondary); font-size: 0.84rem;">
                                            {{ $notification->data['message'] ?? 'A stock notification was generated.' }}
                                        </span>
                                        <span style="display: block; color: #94a3b8; font-size: 0.78rem; margin-top: 0.35rem;">
                                            {{ $notification->created_at?->diffForHumans() }}
                                        </span>
                                    </div>

                                    @if(!$notification->read_at)
                                        <form action="{{ route('notifications.read', $notification) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-icon" title="Mark as read">
                                                <i data-lucide="check" size="14"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @empty
                                <div class="alert-item" style="background: #fff; border-style: dashed;">
                                    <span style="color: var(--text-secondary); font-size: 0.9rem;">No stock notifications yet. They will appear here automatically.</span>
                                </div>
                            @endforelse
                        </div>
                    </section>
                </div>

                <div class="data-card">
                    <div class="card-header">
                        <h2>Your Inventory</h2>
                        <a href="{{ route('seller.addproduct') }}" class="btn-saas-primary">
                            <i data-lucide="plus" size="18"></i>
                            <span>Add New Product</span>
                        </a>
                    </div>

                    <div class="table-container">
                        <table class="saas-table">
                            <thead>
                                <tr>
                                    <th>Product Details</th>
                                    <th>Category</th>
                                    <th>Pricing</th>
                                    <th>Stock Level</th>
                                    <th>Status</th>
                                    <th>Added Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>
                                            <div class="product-info">
                                                @if ($product->image_path)
                                                    <img src="{{ asset('storage/' . $product->image_path) }}" class="product-thumb" alt="{{ $product->name }}">
                                                @else
                                                    <div class="product-thumb" style="background: #f1f5f9; display: grid; place-items: center; color: #94a3b8;">
                                                        <i data-lucide="image" size="16"></i>
                                                    </div>
                                                @endif
                                                <div class="product-meta">
                                                    <span style="font-weight: 800; color: var(--text-main); display: block; margin-bottom: 0.25rem;">{{ $product->name }}</span>
                                                    @if($product->sizes || $product->colors)
                                                        <div style="display: flex; flex-wrap: wrap; gap: 4px; margin-top: 4px;">
                                                            @if($product->sizes)
                                                                @foreach(explode(',', $product->sizes) as $size)
                                                                    <span style="font-size: 0.65rem; background: #f1f5f9; color: #475569; padding: 2px 6px; border-radius: 4px; border: 1px solid #e2e8f0; font-weight: 700;">{{ trim($size) }}</span>
                                                                @endforeach
                                                            @endif
                                                            @if($product->colors)
                                                                @foreach(explode(',', $product->colors) as $color)
                                                                    <span style="font-size: 0.65rem; background: #fff7ed; color: #c2410c; padding: 2px 6px; border-radius: 4px; border: 1px solid #fed7aa; font-weight: 700;">{{ trim($color) }}</span>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    @endif
                                                    <span>SKU: SM-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span style="font-weight: 600; font-size: 0.9rem; color: #475569;">{{ $product->category?->name }}</span>
                                        </td>
                                        <td>
                                            <div class="price-stack">
                                                @if($product->has_discount)
                                                    <span style="font-weight: 800; color: #f97316; font-size: 1rem;">${{ number_format($product->final_price, 2) }}</span>
                                                    <div style="display: flex; align-items: center; gap: 6px;">
                                                        <span style="color: #94a3b8; text-decoration: line-through; font-size: 0.75rem;">${{ number_format($product->price, 2) }}</span>
                                                        <span style="background: #fff7ed; color: #ea580c; font-size: 0.65rem; font-weight: 800; padding: 1px 6px; border-radius: 999px; border: 1px solid #fed7aa;">-{{ $product->discount_label }}%</span>
                                                    </div>
                                                @else
                                                    <span style="font-weight: 800; color: var(--text-main); font-size: 1rem;">${{ number_format($product->price, 2) }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span style="font-weight: 600; color: {{ $product->is_low_stock ? '#ef4444' : '#64748b' }};">
                                                {{ $product->stock }} units
                                            </span>
                                            <span style="display: block; color: #94a3b8; font-size: 0.78rem;">Min: {{ $product->minimum_stock }}</span>
                                        </td>
                                        <td>
                                            @if (! $product->is_active)
                                                <span class="pill pill-danger"><span class="pill-dot"></span> Inactive</span>
                                            @elseif ($product->stock <= 0)
                                                <span class="pill pill-danger"><span class="pill-dot"></span> Out of Stock</span>
                                            @elseif ($product->is_low_stock)
                                                <span class="pill pill-warning"><span class="pill-dot"></span> Low Stock</span>
                                            @else
                                                <span class="pill pill-success"><span class="pill-dot"></span> Active</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span style="color: var(--text-secondary); font-size: 0.85rem;">{{ $product->created_at->format('M d, Y') }}</span>
                                        </td>
                                        <td>
                                            <div class="action-group">
                                                <a href="{{ route('seller.home', ['edit' => $product->id]) }}#product-form-card" 
                                                   class="btn-icon" 
                                                   title="Modifier le produit"
                                                   style="background: #eff6ff; color: #2563eb; border-color: #dbeafe;">
                                                    <i data-lucide="edit-3" size="16"></i>
                                                </a>
                                                <form action="{{ route('seller.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce produit définitivement ? Cette action est irréversible.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn-icon" 
                                                            style="background: #fef2f2; color: #ef4444; border-color: #fee2e2;" 
                                                            title="Supprimer définitivement">
                                                        <i data-lucide="trash-2" size="16"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align: center; padding: 4rem; color: var(--text-secondary);">
                                            <i data-lucide="box" size="40" style="margin-bottom: 1rem; opacity: 0.2;"></i>
                                            <p>No products in your inventory yet.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($products->hasPages())
                        <div style="padding: 1.5rem; border-top: 1px solid var(--border-subtle);">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            @endif

            @if (request()->routeIs('seller.addproduct') || $editingProduct)
                <div class="add-product-workspace">
                    <div class="workspace-card" id="product-form-card">
                        <header style="padding: 2.5rem 2.5rem 1rem;">
                            <h1 style="font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 800; color: var(--text-main); margin: 0;">
                                {{ $isEditing ? 'Edit Product' : 'Create New Product' }}
                            </h1>
                            <p style="color: var(--text-secondary); margin-top: 0.5rem; font-size: 1rem;">
                                Complete the details below to list your product in the global marketplace.
                            </p>
                        </header>

                        @unless($isEditing)
                            <div class="import-grid">
                                <div class="import-card">
                                    <h3>Bulk Import from Excel</h3>
                                    <p>Upload an Excel or CSV file to create many products at once. Manual product creation remains available below.</p>

                                    <form action="{{ route('seller.products.import') }}" method="POST" enctype="multipart/form-data" style="margin-top: 1.25rem;">
                                        @csrf
                                        <div class="input-pro-group">
                                            <label>Category for imported rows</label>
                                            <input type="text" name="category" class="input-pro" placeholder="Electronics" required>
                                        </div>
                                        <div class="input-pro-group">
                                            <label>Excel file</label>
                                            <input type="file" name="file" class="input-pro" accept=".xlsx,.xls,.csv" required>
                                        </div>
                                        <button type="submit" class="btn-saas-primary">
                                            <i data-lucide="file-spreadsheet" size="18"></i>
                                            <span>Import Products</span>
                                        </button>
                                    </form>
                                </div>

                                <div class="import-card" style="background: #fff; border-color: var(--border-subtle);">
                                    <h3>Expected Excel Columns</h3>
                                    <p>Keep the first row as headings and use this exact structure.</p>
                                    <div style="margin-top: 1rem; display: grid; gap: 0.75rem;">
                                        <div class="discount-chip" style="width: 100%; justify-content: center; background: #f8fafc; color: #475569;">
                                            name | description | price | stock | minimum_stock | discount
                                        </div>
                                        <div style="background: #f8fafc; border-radius: 16px; padding: 1rem; color: var(--text-secondary); font-size: 0.85rem; line-height: 1.6;">
                                            Example row:<br>
                                            <strong style="color: var(--text-main);">iPhone 14 | Apple phone | 9000 | 100 | 15 | 30</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endunless

                        <form action="{{ $productFormAction }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if ($isEditing)
                                @method('PUT')
                            @endif

                            <div class="form-section">
                                <div class="form-grid" style="display: grid; grid-template-columns: 1fr 400px; gap: 3rem;">
                                    <div>
                                        <div class="input-pro-group">
                                            <label>Product Title</label>
                                            <input type="text" name="name" class="input-pro" placeholder="e.g. Premium Wireless Headphones" value="{{ old('name', $editingProduct?->name) }}" required>
                                        </div>

                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                            <div class="input-pro-group">
                                                <label>Category</label>
                                                <select name="category" id="categorySelect" class="input-pro" onchange="handleCategoryChange()" required>
                                                    <option value="" disabled {{ !old('category', $editingProduct?->category?->name) ? 'selected' : '' }}>Select Category</option>
                                                    @foreach($categories as $cat)
                                                        <option value="{{ $cat->name }}" {{ old('category', $editingProduct?->category?->name) == $cat->name ? 'selected' : '' }}>
                                                            {{ $cat->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="input-pro-group">
                                                <label>Price ($)</label>
                                                <input type="number" name="price" id="formPrice" step="0.01" class="input-pro" placeholder="0.00" value="{{ old('price', $editingProduct?->price) }}" oninput="updatePricePreview()" required>
                                            </div>
                                        </div>

                                        <!-- Dynamic Extra Fields (Sizes & Colors) -->
                                        <div id="extra-fields" style="display: {{ in_array(old('category', $editingProduct?->category?->name), ['Mode', 'Électronique', 'Maison', 'Beauté', 'Sport', 'Livres', 'Bébé & Jouets']) ? 'block' : 'none' }}; margin-bottom: 1.5rem;">
                                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                                <div class="input-pro-group">
                                                    <label id="size-label">Available Sizes</label>
                                                    <div id="mode-sizes" style="display: {{ old('category', $editingProduct?->category?->name) == 'Mode' ? 'flex' : 'none' }}; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 0.5rem;">
                                                        @foreach(['S', 'M', 'L', 'XL', 'XXL'] as $sz)
                                                            <label style="display: flex; align-items: center; gap: 4px; background: #f8fafc; padding: 4px 10px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.8rem; cursor: pointer;">
                                                                <input type="checkbox" class="size-checkbox" value="{{ $sz }}" onchange="updateSizesInput()" {{ str_contains(old('sizes', $editingProduct?->sizes ?? ''), $sz) ? 'checked' : '' }}> {{ $sz }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                    <input type="text" name="sizes" id="sizes-input" class="input-pro" placeholder="e.g. S, M, L or 42, 44" value="{{ old('sizes', $editingProduct?->sizes) }}">
                                                    <small style="color: #94a3b8; font-size: 0.75rem;">Separate with commas</small>
                                                </div>
                                                <div class="input-pro-group">
                                                    <label>Available Colors</label>
                                                    <div id="color-presets" style="display: flex; gap: 0.6rem; flex-wrap: wrap; margin-bottom: 0.8rem; padding: 0.5rem; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                                                        @php
                                                            $commonColors = [
                                                                'Black' => '#000000',
                                                                'White' => '#ffffff',
                                                                'Red' => '#ef4444',
                                                                'Blue' => '#3b82f6',
                                                                'Green' => '#22c55e',
                                                                'Yellow' => '#eab308',
                                                                'Grey' => '#64748b',
                                                                'Pink' => '#ec4899',
                                                                'Purple' => '#a855f7',
                                                                'Orange' => '#f97316'
                                                            ];
                                                        @endphp
                                                        @foreach($commonColors as $name => $hex)
                                                            <label class="color-checkbox-wrapper" title="{{ $name }}" style="cursor: pointer; position: relative;">
                                                                <input type="checkbox" class="color-checkbox" value="{{ $name }}" onchange="updateColorsInput()" {{ str_contains(old('colors', $editingProduct?->colors ?? ''), $name) ? 'checked' : '' }} style="display: none;">
                                                                <div class="color-circle" style="width: 28px; height: 28px; border-radius: 50%; background: {{ $hex }}; border: 2px solid {{ $name == 'White' ? '#e2e8f0' : 'transparent' }}; transition: all 0.2s; box-shadow: 0 2px 5px rgba(0,0,0,0.1);"></div>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                    <input type="text" name="colors" id="colors-input" class="input-pro" placeholder="Selected colors will appear here" value="{{ old('colors', $editingProduct?->colors) }}">
                                                    <small style="color: #94a3b8; font-size: 0.75rem;">You can also type custom colors</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                            <div class="input-pro-group">
                                                <label>Stock Quantity</label>
                                                <input type="number" name="stock" class="input-pro" placeholder="0" value="{{ old('stock', $editingProduct?->stock) }}" required>
                                            </div>
                                            <div class="input-pro-group">
                                                <label>Minimum Stock Alert</label>
                                                <input type="number" name="minimum_stock" class="input-pro" placeholder="15" min="0" value="{{ old('minimum_stock', $editingProduct?->minimum_stock ?? 15) }}">
                                            </div>
                                        </div>

                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                                            <div class="input-pro-group">
                                                <label>Discount (%)</label>
                                                <input type="number" name="discount" id="formDiscount" step="0.01" class="input-pro" placeholder="0" min="0" max="100" value="{{ old('discount', $editingProduct?->discount ?? 0) }}" oninput="updatePricePreview()">
                                                
                                                <!-- Real-time Price Preview -->
                                                <div id="price-preview-container" style="margin-top: 0.75rem; padding: 0.75rem; background: #fff7ed; border: 1px dashed #fed7aa; border-radius: 12px; display: none;">
                                                    <p style="font-size: 0.75rem; font-weight: 700; color: #9a3412; margin-bottom: 0.25rem; text-transform: uppercase; letter-spacing: 0.05em;">Preview Price</p>
                                                    <div style="display: flex; align-items: baseline; gap: 8px;">
                                                        <span id="preview-old-price" style="color: #94a3b8; text-decoration: line-through; font-size: 0.9rem;"></span>
                                                        <span id="preview-new-price" style="color: #f97316; font-weight: 900; font-size: 1.25rem;"></span>
                                                        <span id="preview-discount-badge" style="background: #f97316; color: #fff; font-size: 0.7rem; font-weight: 800; padding: 2px 6px; border-radius: 999px; margin-left: auto;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-pro-group">
                                                <label>Condition</label>
                                                <select name="condition" class="input-pro">
                                                    <option value="New" {{ old('condition') == 'New' ? 'selected' : '' }}>New</option>
                                                    <option value="Used" {{ old('condition') == 'Used' ? 'selected' : '' }}>Used</option>
                                                    <option value="Refurbished" {{ old('condition') == 'Refurbished' ? 'selected' : '' }}>Refurbished</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="input-pro-group">
                                            <label>Detailed Description</label>
                                            <textarea name="description" class="input-pro" style="min-height: 200px;" placeholder="Tell buyers about your product's features, benefits and specifications...">{{ old('description', $editingProduct?->description) }}</textarea>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="input-pro-group">
                                            <label>Product Display Image</label>
                                            <div onclick="document.getElementById('product_image_form').click()"
                                                style="border: 2px dashed #cbd5e1; border-radius: 20px; padding: 2.5rem 1.5rem; text-align: center; cursor: pointer; background: #fafafa; transition: all 0.2s;"
                                                onmouseover="this.style.borderColor='var(--accent-brand)'; this.style.background='#fff7ed'"
                                                onmouseout="this.style.borderColor='#cbd5e1'; this.style.background='#fafafa'">

                                                <input type="file" name="image" id="product_image_form" style="display: none;" accept="image/*" onchange="previewProductImage(event)">

                                                <div id="image-preview-container" style="width: 100px; height: 100px; margin: 0 auto 1.5rem; border-radius: 16px; background: #fff; border: 1px solid #e2e8f0; display: grid; place-items: center; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);">
                                                    @if($isEditing && $editingProduct?->image_path)
                                                        <img src="{{ asset('storage/' . $editingProduct->image_path) }}" alt="{{ $editingProduct->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    @else
                                                        <i data-lucide="upload-cloud" size="32" style="color: #94a3b8;"></i>
                                                    @endif
                                                </div>

                                                <p style="font-weight: 700; color: var(--text-main); margin-bottom: 0.25rem;">Upload Image</p>
                                                <p style="font-size: 0.8rem; color: var(--text-secondary);">Supports JPG, PNG up to 5MB</p>
                                            </div>
                                        </div>

                                        <div style="background: var(--accent-soft); border: 1px solid #fed7aa; border-radius: 16px; padding: 1.5rem; margin-top: 2rem;">
                                            <div style="display: flex; gap: 0.75rem; color: #9a3412;">
                                                <i data-lucide="alert-circle" size="20" style="flex-shrink: 0;"></i>
                                                <div>
                                                    <p style="font-size: 0.85rem; font-weight: 700; margin: 0 0 0.25rem;">Seller Tip</p>
                                                    <p style="font-size: 0.8rem; margin: 0; line-height: 1.4; opacity: 0.8;">Set a realistic minimum stock and discount so the dashboard can alert you early and display the final sale price correctly.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="display: flex; gap: 1rem; margin-top: 3rem;">
                                            <a href="{{ route('seller.home') }}" style="flex: 1; text-align: center; padding: 0.85rem; border-radius: 12px; border: 1px solid #e2e8f0; color: var(--text-main); text-decoration: none; font-weight: 700; font-size: 0.95rem;">Cancel</a>
                                            <button type="submit" class="btn-saas-primary" style="flex: 1;">
                                                {{ $isEditing ? 'Update Listing' : 'Publish Product' }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </main>
    </div>

    <script>
        function handleCategoryChange() {
            const select = document.getElementById('categorySelect');
            const extraFields = document.getElementById('extra-fields');
            const modeSizes = document.getElementById('mode-sizes');
            const sizeLabel = document.getElementById('size-label');

            if (!select || !extraFields) return;

            const selectedValue = select.value;
            console.log("Category changed to:", selectedValue);

            // Normalize values for comparison
            const normalized = selectedValue.trim();
            
            // List of categories that should trigger the extra fields
            const triggerCategories = [
                'Mode', 
                'Électronique', 
                'Electronics', 
                'Maison', 
                'Beauté', 
                'Sport', 
                'Livres', 
                'Bébé & Jouets'
            ];
            
            const shouldShow = triggerCategories.some(cat => 
                cat.toLowerCase() === normalized.toLowerCase()
            );

            if (shouldShow) {
                extraFields.style.display = 'block';
                
                if (normalized.toLowerCase() === 'mode') {
                    modeSizes.style.display = 'flex';
                    sizeLabel.innerText = 'Size (Select or Type)';
                } else {
                    modeSizes.style.display = 'none';
                    sizeLabel.innerText = 'Available Sizes';
                }
            } else {
                extraFields.style.display = 'none';
            }
        }

        function updateSizesInput() {
            const checkboxes = document.querySelectorAll('.size-checkbox');
            const sizesInput = document.getElementById('sizes-input');
            
            let selected = [];
            checkboxes.forEach(cb => {
                if (cb.checked) selected.push(cb.value);
            });
            
            sizesInput.value = selected.join(', ');
        }

        function updateColorsInput() {
            const checkboxes = document.querySelectorAll('.color-checkbox');
            const colorsInput = document.getElementById('colors-input');
            
            let selected = [];
            checkboxes.forEach(cb => {
                if (cb.checked) selected.push(cb.value);
            });
            
            colorsInput.value = selected.join(', ');
        }

        function previewProductImage(event) {
            const input = event.target;

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewContainer = document.getElementById('image-preview-container');
                    if (previewContainer) {
                        previewContainer.innerHTML = '<img src="' + e.target.result + '" style="width: 100%; height: 100%; object-fit: cover;">';
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function updatePricePreview() {
            const priceInput = document.getElementById('formPrice');
            const discountInput = document.getElementById('formDiscount');
            const container = document.getElementById('price-preview-container');
            const oldPriceEl = document.getElementById('preview-old-price');
            const newPriceEl = document.getElementById('preview-new-price');
            const badgeEl = document.getElementById('preview-discount-badge');

            if (!priceInput || !discountInput || !container) return;

            const price = parseFloat(priceInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;

            if (price > 0 && discount > 0) {
                const finalPrice = price - (price * (discount / 100));
                
                oldPriceEl.innerText = '$' + price.toFixed(2);
                newPriceEl.innerText = '$' + finalPrice.toFixed(2);
                badgeEl.innerText = '-' + discount + '% OFF';
                
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
            // Trigger initial states
            if (document.getElementById('categorySelect')) handleCategoryChange();
            updatePricePreview();
        });
    </script>
@endsection
