@extends('layouts.app')

@section('title', 'SM-SHOP | Checkout')

@push('styles')
    <style>
        body { background-color: #f8fafc; margin: 0; }

        .dashboard-container { display: flex; min-height: 100vh; }

        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        /* Top Bar */
        .checkout-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.2rem 3rem;
            border-bottom: 1px solid #f1f5f9;
            background: #fff;
        }
        .back-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #475569;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: color 0.2s;
        }
        .back-link:hover { color: #0f172a; }
        .secure-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 600;
        }
        .topbar-user {
            width: 34px; height: 34px;
            background: #f1f5f9;
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: #64748b;
            text-decoration: none;
            border: 1px solid #e2e8f0;
        }

        /* Main Body */
        .checkout-body {
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 0;
            flex: 1;
        }

        /* Left: Form Side */
        .checkout-form-side {
            padding: 3rem;
            border-right: 1px solid #f1f5f9;
        }

        .checkout-title {
            font-size: 2rem;
            font-weight: 900;
            color: #0f172a;
            font-family: 'Outfit', sans-serif;
            margin: 0 0 0.5rem 0;
            letter-spacing: -0.02em;
        }
        .checkout-subtitle {
            color: #64748b;
            font-size: 0.95rem;
            margin: 0 0 2.5rem 0;
        }

        /* Progress Steps */
        .progress-steps {
            display: flex;
            align-items: center;
            gap: 0;
            margin-bottom: 2.5rem;
        }
        .step {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .step-num {
            width: 32px; height: 32px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: 0.85rem;
            font-weight: 800;
            flex-shrink: 0;
        }
        .step.active .step-num {
            background: #f97316;
            color: #fff;
        }
        .step.inactive .step-num {
            background: #f1f5f9;
            color: #94a3b8;
            border: 1px solid #e2e8f0;
        }
        .step-label { font-size: 0.9rem; }
        .step.active .step-label strong { color: #0f172a; display: block; font-weight: 700; }
        .step.active .step-label span { color: #64748b; font-size: 0.8rem; }
        .step.inactive .step-label strong { color: #94a3b8; display: block; font-weight: 600; }
        .step.inactive .step-label span { color: #cbd5e1; font-size: 0.8rem; }
        .step-connector {
            flex: 1;
            height: 1px;
            background: #e2e8f0;
            margin: 0 1rem;
        }

        /* Form Section */
        .form-section-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 1.5rem 0;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .form-row.single { grid-template-columns: 1fr; }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }
        .form-group label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .form-group input,
        .form-group select {
            padding: 0.9rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            background: #fff;
            font-size: 0.95rem;
            color: #0f172a;
            outline: none;
            transition: all 0.2s;
            appearance: auto;
        }
        .form-group input:focus,
        .form-group select:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        }
        .form-group input::placeholder { color: #cbd5e1; }

        /* Checkbox */
        .save-address-row {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin: 1.5rem 0 2rem 0;
        }
        .save-address-row input[type="checkbox"] {
            width: 18px; height: 18px;
            accent-color: #f97316;
            cursor: pointer;
        }
        .save-address-row label {
            font-size: 0.9rem;
            color: #475569;
            cursor: pointer;
            font-weight: 500;
        }

        /* Continue Button */
        .btn-continue {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.8rem;
            background: #f97316;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 1.1rem 2rem;
            font-size: 1rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }
        .btn-continue:hover {
            background: #ea580c;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.3);
            color: #fff;
        }

        /* Right: Summary Side */
        .checkout-summary-side {
            padding: 3rem 2.5rem;
            background: #fafafa;
        }
        .summary-side-title {
            font-size: 1.2rem;
            font-weight: 800;
            color: #0f172a;
            font-family: 'Outfit', sans-serif;
            margin: 0 0 2rem 0;
        }

        .summary-items-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .summary-item {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .summary-item-img {
            width: 60px; height: 60px;
            border-radius: 10px;
            object-fit: cover;
            background: #f1f5f9;
        }
        .summary-item-placeholder {
            width: 60px; height: 60px;
            border-radius: 10px;
            background: #f1f5f9;
            display: grid;
            place-items: center;
            color: #cbd5e1;
            flex-shrink: 0;
        }
        .summary-item-info { flex: 1; }
        .summary-item-name {
            font-weight: 700;
            color: #0f172a;
            font-size: 0.95rem;
            margin: 0 0 0.2rem;
        }
        .summary-item-variant { color: #64748b; font-size: 0.8rem; margin: 0; }
        .summary-item-qty { color: #94a3b8; font-size: 0.8rem; margin: 0; }
        .summary-item-price {
            font-weight: 800;
            color: #0f172a;
            font-size: 1rem;
        }

        .summary-totals { margin-bottom: 1.5rem; }
        .summary-line-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.8rem;
            font-size: 0.95rem;
            color: #475569;
        }
        .summary-line-row.total {
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
            font-size: 1.3rem;
            font-weight: 900;
            color: #0f172a;
            align-items: center;
        }
        .total-currency {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 600;
            margin-right: 0.2rem;
        }

        .free-ship-note {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #10b981;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 2rem;
        }

        .guarantee-row {
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
            margin-bottom: 1.2rem;
        }
        .guarantee-row-icon { color: #f97316; flex-shrink: 0; }
        .guarantee-row-text h4 { margin: 0 0 0.2rem; font-size: 0.9rem; font-weight: 700; color: #0f172a; }
        .guarantee-row-text p { margin: 0; font-size: 0.8rem; color: #64748b; }

        @media (max-width: 1024px) {
            .checkout-body { grid-template-columns: 1fr; }
            .main-content { margin-left: 0; }
        }
    </style>
@endpush

@section('content')
<div class="dashboard-container">
    <x-sidebar />

    <div class="main-content">
        <!-- Top Bar -->
        <div class="checkout-topbar">
            <a href="{{ route('buyer.checkout') }}" class="back-link">
                <i data-lucide="arrow-left" style="width: 16px;"></i>
                Back to Cart
            </a>
            <div style="display: flex; align-items: center; gap: 1.5rem;">
                <div class="secure-badge">
                    <i data-lucide="lock" style="width: 16px;"></i>
                    Secure Checkout
                </div>
                <a href="{{ route('buyer.home', ['tab' => 'profile']) }}" class="topbar-user">
                    <i data-lucide="user" style="width: 16px;"></i>
                </a>
            </div>
        </div>

        <!-- Main Body -->
        <div class="checkout-body">
            <!-- Left: Form -->
            <div class="checkout-form-side">
                <h1 class="checkout-title">Checkout</h1>
                <p class="checkout-subtitle">Complete your order by providing your details and payment information.</p>

                <!-- Progress Steps -->
                <div class="progress-steps">
                    <div class="step active">
                        <div class="step-num">1</div>
                        <div class="step-label">
                            <strong>Shipping</strong>
                            <span>Address</span>
                        </div>
                    </div>
                    <div class="step-connector"></div>
                    <div class="step inactive">
                        <div class="step-num">2</div>
                        <div class="step-label">
                            <strong>Payment</strong>
                            <span>Method</span>
                        </div>
                    </div>
                    <div class="step-connector"></div>
                    <div class="step inactive">
                        <div class="step-num">3</div>
                        <div class="step-label">
                            <strong>Review</strong>
                            <span>Order</span>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address Form -->
                <h2 class="form-section-title">Shipping Address</h2>

                <form action="{{ route('buyer.checkout.shipping.store') }}" method="POST" id="shippingForm">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="full_name" placeholder="John Doe" value="{{ auth()->user()->name ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" name="phone" placeholder="+1 234 567 8901">
                        </div>
                    </div>

                    <div class="form-row single">
                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="shipping_address" placeholder="123 Main Street" required>
                        </div>
                    </div>

                    <div class="form-row single">
                        <div class="form-group">
                            <label>Apartment, suite, etc. (optional)</label>
                            <input type="text" name="apartment" placeholder="Apt 4B">
                        </div>
                    </div>

                    <div class="form-row" style="grid-template-columns: 1fr 1fr 1fr;">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="shipping_city" placeholder="New York" required>
                        </div>
                        <div class="form-group">
                            <label>State / Province</label>
                            <select name="state">
                                <option>Select state</option>
                                <option>Casablanca</option>
                                <option>Rabat</option>
                                <option>Marrakech</option>
                                <option>Fes</option>
                                <option>Tanger</option>
                                <option>Agadir</option>
                                <option>New York</option>
                                <option>California</option>
                                <option>Texas</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>ZIP / Postal Code</label>
                            <input type="text" name="shipping_postal_code" placeholder="10001" required>
                        </div>
                    </div>

                    <div class="form-row single">
                        <div class="form-group">
                            <label>Country</label>
                            <select name="shipping_country">
                                <option>Morocco</option>
                                <option>United States</option>
                                <option>France</option>
                                <option>Canada</option>
                                <option>United Kingdom</option>
                                <option>Germany</option>
                                <option>Spain</option>
                            </select>
                        </div>
                    </div>

                    <div class="save-address-row">
                        <input type="checkbox" name="save_address" id="saveAddress" checked>
                        <label for="saveAddress">Save this address for future orders</label>
                    </div>

                    <input type="hidden" name="payment_method" value="cod">

                    <button type="submit" class="btn-continue">
                        Continue to Payment
                        <i data-lucide="arrow-right" style="width: 18px;"></i>
                    </button>
                </form>
            </div>

            <!-- Right: Order Summary -->
            <div class="checkout-summary-side">
                <h2 class="summary-side-title">Order Summary</h2>

                <div class="summary-items-list">
                    @foreach($cartItems as $item)
                        <div class="summary-item">
                            @if($item['image_url'])
                                <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" class="summary-item-img">
                            @else
                                <div class="summary-item-placeholder">
                                    <i data-lucide="package" style="width: 24px;"></i>
                                </div>
                            @endif
                            <div class="summary-item-info">
                                <p class="summary-item-name">{{ $item['name'] }}</p>
                                <p class="summary-item-variant">{{ $item['category'] ?? 'Standard' }}</p>
                                <p class="summary-item-qty">Qty: {{ $item['quantity'] }}</p>
                            </div>
                            <div class="summary-item-price">
                                ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                @if(!empty($item['has_discount']))
                                    <span style="display: block; color: #94a3b8; font-size: 0.78rem; text-decoration: line-through;">
                                        ${{ number_format($item['original_price'] * $item['quantity'], 2) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="summary-totals">
                    <div class="summary-line-row">
                        <span>Subtotal</span>
                        <span>${{ number_format($cartTotal, 2) }}</span>
                    </div>
                    <div class="summary-line-row">
                        <span>Shipping</span>
                        @if($cartTotal > 150)
                            <span>$0.00</span>
                        @else
                            <span>$5.99</span>
                        @endif
                    </div>
                    <div class="summary-line-row total">
                        <span>Total</span>
                        <div>
                            <span class="total-currency">USD</span>
                            ${{ number_format($cartTotal > 150 ? $cartTotal : $cartTotal + 5.99, 2) }}
                        </div>
                    </div>
                </div>

                <div class="free-ship-note">
                    <i data-lucide="truck" style="width: 16px;"></i>
                    Free shipping on orders over $150
                </div>

                <div class="guarantee-row">
                    <i data-lucide="shield-check" class="guarantee-row-icon" style="width: 20px;"></i>
                    <div class="guarantee-row-text">
                        <h4>Secure Checkout</h4>
                        <p>Your data is protected</p>
                    </div>
                </div>
                <div class="guarantee-row">
                    <i data-lucide="refresh-cw" class="guarantee-row-icon" style="width: 20px;"></i>
                    <div class="guarantee-row-text">
                        <h4>Easy Returns</h4>
                        <p>30-day return policy</p>
                    </div>
                </div>
                <div class="guarantee-row">
                    <i data-lucide="headphones" class="guarantee-row-icon" style="width: 20px;"></i>
                    <div class="guarantee-row-text">
                        <h4>24/7 Support</h4>
                        <p>We're here to help</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
