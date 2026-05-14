@extends('layouts.app')

@section('title', 'SM-SHOP | Order Confirmed')

@push('styles')
<style>
    body { background-color: #f8fafc; margin: 0; }

    .dashboard-container { display: flex; min-height: 100vh; }

    .main-content {
        flex: 1;
        margin-left: 280px;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 3rem 2rem;
    }

    /* Top Search Bar */
    .confirm-topbar {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 3rem;
        background: #fff;
        border-bottom: 1px solid #f1f5f9;
        position: fixed;
        top: 0;
        left: 280px;
        right: 0;
        z-index: 50;
    }
    .topbar-search {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.6rem 1rem;
        width: 320px;
        color: #94a3b8;
        font-size: 0.9rem;
    }
    .topbar-right {
        display: flex;
        align-items: center;
        gap: 1.2rem;
    }
    .cart-icon-btn {
        position: relative;
        width: 38px; height: 38px;
        border-radius: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        display: grid;
        place-items: center;
        color: #64748b;
        text-decoration: none;
    }
    .cart-badge {
        position: absolute;
        top: -6px; right: -6px;
        background: #f97316;
        color: #fff;
        font-size: 0.65rem;
        font-weight: 800;
        width: 18px; height: 18px;
        border-radius: 50%;
        display: grid;
        place-items: center;
    }
    .user-avatar-btn {
        width: 38px; height: 38px;
        border-radius: 50%;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        display: grid;
        place-items: center;
        color: #64748b;
        text-decoration: none;
    }

    /* Confirmation Card */
    .confirm-wrapper {
        margin-top: 5rem;
        width: 100%;
        max-width: 680px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 2rem;
    }

    /* Success Icon */
    .success-icon {
        width: 90px; height: 90px;
        border-radius: 50%;
        background: rgba(16, 185, 129, 0.1);
        display: grid;
        place-items: center;
    }
    .success-icon-inner {
        width: 60px; height: 60px;
        border-radius: 50%;
        background: rgba(16, 185, 129, 0.2);
        display: grid;
        place-items: center;
        color: #10b981;
    }

    /* Title */
    .confirm-title {
        text-align: center;
    }
    .confirm-title h1 {
        font-size: 1.8rem;
        font-weight: 900;
        color: #0f172a;
        font-family: 'Outfit', sans-serif;
        margin: 0 0 0.5rem;
        letter-spacing: -0.02em;
    }
    .confirm-title p {
        color: #64748b;
        font-size: 1rem;
        margin: 0 0 1rem;
    }
    .order-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(16, 185, 129, 0.08);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: #059669;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 0.5rem 1.2rem;
        border-radius: 100px;
    }
    .confirm-email {
        text-align: center;
        color: #64748b;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }
    .confirm-email strong { color: #0f172a; }

    /* Order Details Box */
    .details-card {
        width: 100%;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
    }
    .details-card-header {
        padding: 1.2rem 1.8rem;
        border-bottom: 1px solid #f1f5f9;
        font-weight: 800;
        font-size: 1rem;
        color: #0f172a;
    }
    .details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        padding: 1.5rem 1.8rem;
        gap: 1rem;
    }
    .detail-item {}
    .detail-item-icon {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #94a3b8;
        font-size: 0.8rem;
        margin-bottom: 0.4rem;
    }
    .detail-item-label { font-size: 0.8rem; color: #94a3b8; margin-bottom: 0.3rem; }
    .detail-item-value { font-weight: 700; color: #0f172a; font-size: 0.95rem; }
    .detail-item-sub { font-size: 0.8rem; color: #64748b; margin-top: 0.1rem; }

    /* What Happens Next */
    .next-card {
        width: 100%;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
    }
    .next-card-header {
        padding: 1.2rem 1.8rem;
        border-bottom: 1px solid #f1f5f9;
        font-weight: 800;
        font-size: 1rem;
        color: #0f172a;
    }
    .next-steps {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        padding: 2rem 1.8rem;
        gap: 1rem;
        text-align: center;
    }
    .next-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.8rem;
        position: relative;
    }
    .next-step:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 28px;
        right: -50%;
        width: 100%;
        height: 2px;
        border-top: 2px dashed #e2e8f0;
        z-index: 0;
    }
    .next-step-icon {
        width: 56px; height: 56px;
        border-radius: 50%;
        background: rgba(16, 185, 129, 0.1);
        display: grid;
        place-items: center;
        color: #10b981;
        position: relative;
        z-index: 1;
    }
    .next-step h4 { font-size: 0.9rem; font-weight: 800; color: #0f172a; margin: 0 0 0.3rem; }
    .next-step p { font-size: 0.8rem; color: #64748b; margin: 0; line-height: 1.4; }

    /* Bottom Buttons */
    .confirm-actions {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        padding-bottom: 2rem;
    }
    .btn-continue-shopping {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.9rem 1.8rem;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        color: #475569;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        background: #fff;
        transition: all 0.2s;
    }
    .btn-continue-shopping:hover { background: #f8fafc; color: #0f172a; }
    .btn-view-orders {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.9rem 2rem;
        background: #f97316;
        border-radius: 12px;
        color: #fff;
        font-weight: 800;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.3s;
    }
    .btn-view-orders:hover {
        background: #ea580c;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
        color: #fff;
    }

    @media (max-width: 1024px) {
        .main-content { margin-left: 0; padding-top: 5rem; }
        .confirm-topbar { left: 0; }
        .details-grid, .next-steps { grid-template-columns: 1fr; }
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <x-sidebar />

    <div class="main-content">
        <!-- Top Search Bar -->
        <div class="confirm-topbar">
            <div class="topbar-search">
                <i data-lucide="search" style="width: 16px; flex-shrink: 0;"></i>
                Search for products, categories...
            </div>
            <div class="topbar-right">
                <a href="{{ route('buyer.checkout') }}" class="cart-icon-btn">
                    <i data-lucide="shopping-cart" style="width: 18px;"></i>
                    <span class="cart-badge">0</span>
                </a>
                <a href="{{ route('buyer.home', ['tab' => 'profile']) }}" class="user-avatar-btn">
                    <i data-lucide="user" style="width: 16px;"></i>
                </a>
            </div>
        </div>

        <!-- Confirmation Content -->
        <div class="confirm-wrapper">
            <!-- Success Icon -->
            <div class="success-icon">
                <div class="success-icon-inner">
                    <i data-lucide="check" style="width: 28px; stroke-width: 3;"></i>
                </div>
            </div>

            <!-- Title & Order Number -->
            <div class="confirm-title">
                <h1>Thank you for your order!</h1>
                <p>Your order has been placed successfully.</p>
                <div class="order-badge">
                    <i data-lucide="shield-check" style="width: 14px;"></i>
                    Order #SM{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}
                </div>
                <p class="confirm-email" style="margin-top: 1rem;">
                    A confirmation email has been sent to<br>
                    <strong>{{ auth()->user()->email }}</strong>
                </p>
            </div>

            <!-- Order Details -->
            <div class="details-card">
                <div class="details-card-header">Order Details</div>
                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-item-icon">
                            <i data-lucide="calendar" style="width: 14px;"></i>
                            Order Date
                        </div>
                        <div class="detail-item-value">{{ $order->ordered_at ? $order->ordered_at->format('M d, Y') : now()->format('M d, Y') }}</div>
                        <div class="detail-item-sub">{{ $order->ordered_at ? $order->ordered_at->format('h:i A') : now()->format('h:i A') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-item-icon">
                            <i data-lucide="credit-card" style="width: 14px;"></i>
                            Payment Method
                        </div>
                        <div class="detail-item-value">
                            @php
                                $pm = $order->payment_method;
                                $label = match($pm) {
                                    'paypal'    => 'PayPal',
                                    'apple_pay' => 'Apple Pay',
                                    'card'      => 'Credit / Debit Card',
                                    default     => ucfirst($pm),
                                };
                            @endphp
                            {{ $label }}
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-item-icon">
                            <i data-lucide="truck" style="width: 14px;"></i>
                            Shipping Method
                        </div>
                        <div class="detail-item-value">Standard Shipping</div>
                        <div class="detail-item-sub" style="color: #10b981; font-weight: 700;">
                            {{ $order->total_amount > 150 ? 'Free' : '$5.99' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- What Happens Next -->
            <div class="next-card">
                <div class="next-card-header">What happens next?</div>
                <div class="next-steps">
                    <div class="next-step">
                        <div class="next-step-icon">
                            <i data-lucide="package" style="width: 24px;"></i>
                        </div>
                        <h4>Order Confirmed</h4>
                        <p>We've received your order.</p>
                    </div>
                    <div class="next-step">
                        <div class="next-step-icon">
                            <i data-lucide="box" style="width: 24px;"></i>
                        </div>
                        <h4>Order Processing</h4>
                        <p>We're preparing your items.</p>
                    </div>
                    <div class="next-step">
                        <div class="next-step-icon">
                            <i data-lucide="truck" style="width: 24px;"></i>
                        </div>
                        <h4>Order Shipped</h4>
                        <p>You'll receive a confirmation once it's on the way.</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="confirm-actions">
                <a href="{{ route('buyer.home') }}" class="btn-continue-shopping">
                    <i data-lucide="arrow-left" style="width: 16px;"></i>
                    Continue Shopping
                </a>
                <a href="{{ route('buyer.home', ['tab' => 'orders']) }}" class="btn-view-orders">
                    View My Orders
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
