@extends('layouts.app')

@section('title', 'SM-SHOP | Cart')

@push('styles')
    <style>
        body {
            background-color: #f8fafc; /* Very light grey background */
            margin: 0;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            margin-left: 280px; /* Sidebar width */
            padding: 2rem 3rem;
            transition: all 0.3s;
        }

        /* Top Header Area (Search) */
        .cart-top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }
        .cart-search-wrapper {
            position: relative;
            flex: 1;
            max-width: 600px;
        }
        .cart-search-icon {
            position: absolute;
            left: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            width: 18px; height: 18px;
        }
        .cart-search-input {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 3rem;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: #fff;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.3s;
        }
        .cart-search-input:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }
        .cart-header-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .header-icon-btn {
            position: relative;
            color: #64748b;
            text-decoration: none;
            display: grid;
            place-items: center;
            width: 40px; height: 40px;
            border-radius: 50%;
            background: #fff;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }
        .header-icon-btn:hover {
            color: #0f172a;
            border-color: #cbd5e1;
        }
        .cart-badge {
            position: absolute;
            top: -5px; right: -5px;
            background: #f97316;
            color: #fff;
            font-size: 0.7rem;
            font-weight: 800;
            width: 18px; height: 18px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            border: 2px solid #f8fafc;
        }

        /* Cart Layout */
        .cart-layout {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 2.5rem;
        }

        /* Cart Header */
        .cart-title-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 2rem;
        }
        .cart-title-row h1 {
            font-size: 2rem;
            font-weight: 900;
            color: #0f172a;
            font-family: 'Outfit', sans-serif;
            margin: 0 0 0.5rem 0;
            letter-spacing: -0.02em;
        }
        .cart-title-row h1 span {
            color: #64748b;
            font-weight: 600;
            font-size: 1.5rem;
        }
        .cart-title-row p {
            color: #64748b;
            font-size: 1rem;
            margin: 0;
        }
        .btn-clear-cart {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: none;
            border: none;
            color: #64748b;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            padding: 0.5rem;
            transition: color 0.2s;
        }
        .btn-clear-cart:hover {
            color: #ef4444;
        }

        /* Cart Items */
        .cart-items-list {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }
        .cart-item-card {
            background: #fff;
            border-radius: 16px;
            padding: 1.5rem;
            display: grid;
            grid-template-columns: 100px 1fr auto;
            gap: 1.5rem;
            border: 1px solid #f1f5f9;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            position: relative;
        }
        .cart-item-img {
            width: 100px;
            height: 100px;
            background: #f8fafc;
            border-radius: 12px;
            object-fit: cover;
        }
        .cart-item-placeholder {
            width: 100px;
            height: 100px;
            background: #f8fafc;
            border-radius: 12px;
            display: grid;
            place-items: center;
            color: #cbd5e1;
        }
        .cart-item-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .cart-item-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 0.3rem 0;
            font-family: 'Outfit', sans-serif;
        }
        .cart-item-variant {
            color: #64748b;
            font-size: 0.9rem;
            margin: 0 0 0.8rem 0;
        }
        .cart-item-price {
            color: #f97316;
            font-weight: 800;
            font-size: 1.1rem;
        }
        
        .cart-item-controls {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-end;
        }
        .btn-remove-item {
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 0.3rem;
            transition: color 0.2s;
        }
        .btn-remove-item:hover {
            color: #ef4444;
        }
        .qty-selector {
            display: flex;
            align-items: center;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            height: 36px;
        }
        .qty-btn {
            background: none;
            border: none;
            width: 32px;
            height: 100%;
            display: grid;
            place-items: center;
            color: #64748b;
            cursor: pointer;
            font-size: 1.1rem;
            transition: background 0.2s;
        }
        .qty-btn:hover {
            background: #f1f5f9;
            color: #0f172a;
        }
        .qty-input {
            width: 40px;
            height: 100%;
            border: none;
            text-align: center;
            font-weight: 700;
            color: #0f172a;
            font-size: 0.95rem;
            border-left: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
            pointer-events: none; /* Make it readonly visually */
        }
        .qty-input:focus {
            outline: none;
        }
        .cart-item-total {
            font-size: 1.2rem;
            font-weight: 900;
            color: #0f172a;
        }

        .continue-shopping {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #475569;
            font-weight: 600;
            text-decoration: none;
            margin-top: 2rem;
            transition: color 0.2s;
        }
        .continue-shopping:hover {
            color: #0f172a;
        }

        /* Order Summary */
        .summary-card {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            border: 1px solid #f1f5f9;
            position: sticky;
            top: 2rem;
        }
        .summary-title {
            font-size: 1.3rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 1.5rem 0;
            font-family: 'Outfit', sans-serif;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            color: #475569;
            font-size: 0.95rem;
        }
        .summary-row.total {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f1f5f9;
            color: #0f172a;
            font-weight: 900;
            font-size: 1.5rem;
            align-items: center;
        }
        .summary-row.total .currency {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 600;
            margin-right: 0.3rem;
        }
        .free-shipping-notice {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #10b981; /* Emerald green */
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        .btn-checkout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: #f97316;
            color: #fff;
            border: none;
            border-radius: 12px;
            width: 100%;
            padding: 1.1rem;
            font-size: 1rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 1rem;
        }
        .btn-checkout:hover {
            background: #ea580c;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.25);
        }

        .alt-payments {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
            margin-bottom: 2rem;
        }
        .btn-alt-pay {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            width: 100%;
            padding: 0.9rem;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-alt-pay:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }
        .btn-alt-pay img {
            height: 20px;
            object-fit: contain;
        }

        .guarantees-list {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f1f5f9;
        }
        .guarantee-item {
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
        }
        .guarantee-icon {
            color: #f97316;
            width: 20px; height: 20px;
            flex-shrink: 0;
            margin-top: 0.1rem;
        }
        .guarantee-text h4 {
            margin: 0 0 0.2rem 0;
            font-size: 0.9rem;
            font-weight: 700;
            color: #0f172a;
        }
        .guarantee-text p {
            margin: 0;
            font-size: 0.8rem;
            color: #64748b;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .cart-layout {
                grid-template-columns: 1fr;
            }
            .summary-card {
                position: static;
            }
        }
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 1.5rem;
            }
            .cart-item-card {
                grid-template-columns: 1fr;
                gap: 1rem;
                text-align: center;
            }
            .cart-item-img {
                margin: 0 auto;
            }
            .cart-item-controls {
                flex-direction: row;
                align-items: center;
                margin-top: 1rem;
            }
            .cart-header-actions {
                display: none; /* simplify mobile top bar */
            }
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-container">
        <!-- Reusing the exact same sidebar -->
        <x-sidebar />

        <main class="main-content">
            <!-- Top Search Header -->
            <header class="cart-top-header">
                <div class="cart-search-wrapper">
                    <i data-lucide="search" class="cart-search-icon"></i>
                    <input type="text" class="cart-search-input" placeholder="Search for products, categories...">
                </div>
                <div class="cart-header-actions">
                    <a href="{{ route('buyer.checkout') }}" class="header-icon-btn">
                        <i data-lucide="shopping-cart" style="width: 18px;"></i>
                        @if($cartCount > 0)
                            <span class="cart-badge">{{ $cartCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('buyer.home', ['tab'=>'profile']) }}" class="header-icon-btn">
                        <i data-lucide="user" style="width: 18px;"></i>
                    </a>
                </div>
            </header>

            <!-- Cart Header -->
            <div class="cart-title-row">
                <div>
                    <h1>Your Cart <span>({{ $cartCount }})</span></h1>
                    <p>Review your items and proceed to checkout.</p>
                </div>
                
                @if($cartCount > 0)
                <form action="{{ route('buyer.cart.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-clear-cart">
                        <i data-lucide="trash-2" style="width: 16px;"></i> Clear Cart
                    </button>
                </form>
                @endif
            </div>

            <div class="cart-layout">
                <!-- Left Column: Items -->
                <div class="cart-items-section">
                    @if($cartCount === 0)
                        <div style="background: #fff; padding: 4rem 2rem; border-radius: 16px; text-align: center; border: 1px solid #f1f5f9;">
                            <i data-lucide="shopping-bag" style="width: 64px; height: 64px; color: #e2e8f0; margin-bottom: 1rem;"></i>
                            <h3 style="margin: 0 0 0.5rem; color: #0f172a; font-family: 'Outfit'; font-size: 1.5rem;">Your cart is empty</h3>
                            <p style="color: #64748b; margin: 0 0 1.5rem;">Looks like you haven't added anything yet.</p>
                            <a href="{{ route('buyer.home') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #f97316; color: #fff; padding: 0.8rem 1.5rem; border-radius: 10px; font-weight: 700; text-decoration: none;">
                                Start Shopping
                            </a>
                        </div>
                    @else
                        <div class="cart-items-list">
                            @foreach($cartItems as $cartItem)
                                <div class="cart-item-card">
                                    @if($cartItem['image_url'])
                                        <img src="{{ $cartItem['image_url'] }}" alt="{{ $cartItem['name'] }}" class="cart-item-img">
                                    @else
                                        <div class="cart-item-placeholder">
                                            <i data-lucide="package" style="width: 32px; height: 32px;"></i>
                                        </div>
                                    @endif

                                    <div class="cart-item-info">
                                        <h3 class="cart-item-title">{{ $cartItem['name'] }}</h3>
                                        <p class="cart-item-variant">{{ $cartItem['category'] ?? 'Standard' }}</p>
                                        <div class="cart-item-price">
                                            ${{ number_format($cartItem['price'], 2) }}
                                            @if(!empty($cartItem['has_discount']))
                                                <span style="display: block; color: #94a3b8; font-size: 0.82rem; text-decoration: line-through;">
                                                    ${{ number_format($cartItem['original_price'], 2) }}
                                                </span>
                                                <span style="display: inline-flex; margin-top: 0.35rem; background: #fff7ed; color: #ea580c; border-radius: 999px; padding: 0.2rem 0.5rem; font-size: 0.72rem; font-weight: 800;">
                                                    -{{ rtrim(rtrim(number_format($cartItem['discount'], 2, '.', ''), '0'), '.') }}%
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="cart-item-controls">
                                        <!-- Delete Item Form -->
                                        <form action="{{ route('buyer.cart.destroy', $cartItem['id']) }}" method="POST" style="align-self: flex-end; margin-bottom: auto;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-remove-item">
                                                <i data-lucide="trash-2" style="width: 18px;"></i>
                                            </button>
                                        </form>

                                        <!-- Quantity Form (styled as a pill) -->
                                        <div style="display: flex; align-items: center; gap: 2rem;">
                                            <div class="qty-selector">
                                                <!-- We use a mini form for minus and plus to instantly update cart -->
                                                <form action="{{ route('buyer.cart.update', $cartItem['id']) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="quantity" value="{{ max(1, $cartItem['quantity'] - 1) }}">
                                                    <button type="submit" class="qty-btn" {{ $cartItem['quantity'] <= 1 ? 'disabled' : '' }}>-</button>
                                                </form>
                                                
                                                <input type="text" class="qty-input" value="{{ $cartItem['quantity'] }}" readonly>
                                                
                                                <form action="{{ route('buyer.cart.update', $cartItem['id']) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="quantity" value="{{ $cartItem['quantity'] + 1 }}">
                                                    <button type="submit" class="qty-btn" {{ $cartItem['quantity'] >= $cartItem['stock'] ? 'disabled' : '' }}>+</button>
                                                </form>
                                            </div>

                                            <div class="cart-item-total">
                                                ${{ number_format($cartItem['price'] * $cartItem['quantity'], 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <a href="{{ route('buyer.home') }}" class="continue-shopping">
                        <i data-lucide="arrow-left" style="width: 16px;"></i> Continue Shopping
                    </a>
                </div>

                <!-- Right Column: Summary -->
                <div>
                    <div class="summary-card">
                        <h2 class="summary-title">Order Summary</h2>
                        
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <strong>${{ number_format($cartTotal, 2) }}</strong>
                        </div>
                        <div class="summary-row">
                            <span>Shipping</span>
                            @if($cartTotal > 150)
                                <strong>$0.00</strong>
                            @else
                                <strong>$5.99</strong>
                            @endif
                        </div>

                        <div class="summary-row total">
                            <span>Total</span>
                            <div>
                                <span class="currency">USD</span>
                                ${{ number_format($cartTotal > 150 ? $cartTotal : $cartTotal + 5.99, 2) }}
                            </div>
                        </div>

                        <div class="free-shipping-notice">
                            <i data-lucide="truck" style="width: 16px;"></i>
                            <span>Free shipping on orders over $150</span>
                        </div>

                        <!-- We will use a modal for the actual checkout form to match the UI perfectly -->
                        <a href="{{ route('buyer.checkout.shipping') }}" class="btn-checkout">
                            <i data-lucide="lock" style="width: 16px;"></i> Proceed to Checkout
                        </a>

                        <div class="guarantees-list">
                            <div class="guarantee-item">
                                <i data-lucide="shield-check" class="guarantee-icon"></i>
                                <div class="guarantee-text">
                                    <h4>Secure Checkout</h4>
                                    <p>Your data is protected</p>
                                </div>
                            </div>
                            <div class="guarantee-item">
                                <i data-lucide="refresh-cw" class="guarantee-icon"></i>
                                <div class="guarantee-text">
                                    <h4>Easy Returns</h4>
                                    <p>30-day return policy</p>
                                </div>
                            </div>
                            <div class="guarantee-item">
                                <i data-lucide="headphones" class="guarantee-icon"></i>
                                <div class="guarantee-text">
                                    <h4>24/7 Support</h4>
                                    <p>We're here to help</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

@endsection
