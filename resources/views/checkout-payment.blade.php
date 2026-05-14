@extends('layouts.app')

@section('title', 'SM-SHOP | Payment')

@push('styles')
    <style>
        body {
            background-color: #ffffff;
            margin: 0;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            margin-left: 280px;
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

        .back-link:hover {
            color: #0f172a;
        }

        .secure-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .topbar-user {
            width: 34px;
            height: 34px;
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
            margin: 0 0 0.4rem 0;
            letter-spacing: -0.02em;
        }

        .checkout-step-label {
            color: #64748b;
            font-size: 0.95rem;
            margin: 0 0 2.5rem 0;
        }

        .checkout-step-label strong {
            color: #f97316;
        }

        /* Payment Method Section */
        .payment-section-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 1.2rem 0;
        }

        .payment-options {
            display: flex;
            flex-direction: column;
            gap: 0;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .payment-option-row {
            display: flex;
            align-items: center;
            padding: 1.2rem 1.5rem;
            cursor: pointer;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.2s;
            position: relative;
        }

        .payment-option-row:last-child {
            border-bottom: none;
        }

        .payment-option-row:hover {
            background: #fafafa;
        }

        .payment-option-row.active {
            background: #fff;
        }

        .payment-radio {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #e2e8f0;
            display: grid;
            place-items: center;
            flex-shrink: 0;
            margin-right: 1rem;
            transition: border-color 0.2s;
        }

        .payment-option-row.active .payment-radio {
            border-color: #f97316;
        }

        .payment-radio-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #f97316;
            display: none;
        }

        .payment-option-row.active .payment-radio-dot {
            display: block;
        }

        .payment-option-label {
            font-weight: 700;
            color: #0f172a;
            font-size: 1rem;
            flex: 1;
        }

        .payment-option-logos {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-logo {
            height: 22px;
            border-radius: 4px;
        }

        /* Card Fields (expandable) */
        .card-fields {
            padding: 1.5rem;
            background: #fff;
            border-top: 1px solid #f1f5f9;
            display: none;
        }

        .card-fields.visible {
            display: block;
        }

        .field-group {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
            margin-bottom: 1rem;
        }

        .field-group label {
            font-size: 0.8rem;
            color: #94a3b8;
            font-weight: 500;
        }

        .field-group input {
            padding: 0.9rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            color: #0f172a;
            outline: none;
            transition: border-color 0.2s;
            background: #fff;
        }

        .field-group input:focus {
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.08);
        }

        .card-row {
            display: flex;
            gap: 1rem;
        }

        .card-row .field-group {
            flex: 1;
        }

        .save-card-row {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-top: 0.5rem;
        }

        .save-card-row input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: #f97316;
            cursor: pointer;
        }

        .save-card-row label {
            font-size: 0.9rem;
            color: #475569;
            cursor: pointer;
            font-weight: 500;
        }

        /* PayPal / Apple / Google logos inline */
        .paypal-text {
            font-weight: 900;
            font-size: 1.1rem;
            letter-spacing: -0.03em;
        }

        .paypal-text .p1 {
            color: #003087;
        }

        .paypal-text .p2 {
            color: #009cde;
        }

        .apple-pay-text {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            font-weight: 800;
            font-size: 1rem;
            color: #000;
        }

        .gpay-text {
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: -0.02em;
        }

        .gpay-text span:nth-child(1) {
            color: #4285f4;
        }

        .gpay-text span:nth-child(2) {
            color: #ea4335;
        }

        .gpay-text span:nth-child(3) {
            color: #fbbc05;
        }

        .gpay-text span:nth-child(4) {
            color: #34a853;
        }

        .gpay-text span:nth-child(5) {
            color: #4285f4;
        }

        /* Bottom navigation */
        .form-bottom-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
        }

        .btn-back-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #475569;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        .btn-back-link:hover {
            color: #0f172a;
        }

        .btn-review {
            display: flex;
            align-items: center;
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
        }

        .btn-review:hover {
            background: #ea580c;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.3);
        }

        .secure-footer {
            text-align: center;
            padding: 1.5rem;
            color: #94a3b8;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border-top: 1px solid #f1f5f9;
            margin-top: 2rem;
        }

        /* Right: Summary Side */
        .checkout-summary-side {
            padding: 3rem 2.5rem;
            background: #fafafa;
            border-left: 1px solid #f1f5f9;
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
            width: 60px;
            height: 60px;
            border-radius: 10px;
            object-fit: cover;
            background: #f1f5f9;
            flex-shrink: 0;
        }

        .summary-item-placeholder {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            background: #f1f5f9;
            display: grid;
            place-items: center;
            color: #cbd5e1;
            flex-shrink: 0;
        }

        .summary-item-info {
            flex: 1;
        }

        .summary-item-name {
            font-weight: 700;
            color: #0f172a;
            font-size: 0.95rem;
            margin: 0 0 0.2rem;
        }

        .summary-item-variant {
            color: #64748b;
            font-size: 0.8rem;
            margin: 0;
        }

        .summary-item-qty {
            color: #94a3b8;
            font-size: 0.8rem;
            margin: 0;
        }

        .summary-item-price {
            font-weight: 800;
            color: #0f172a;
            font-size: 1rem;
        }

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
            margin: 1.5rem 0;
        }

        .guarantee-row {
            display: flex;
            align-items: flex-start;
            gap: 0.8rem;
            margin-bottom: 1.2rem;
        }

        .guarantee-row-icon {
            color: #f97316;
            flex-shrink: 0;
        }

        .guarantee-row-text h4 {
            margin: 0 0 0.2rem;
            font-size: 0.9rem;
            font-weight: 700;
            color: #0f172a;
        }

        .guarantee-row-text p {
            margin: 0;
            font-size: 0.8rem;
            color: #64748b;
        }

        @media (max-width: 1024px) {
            .checkout-body {
                grid-template-columns: 1fr;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-container">
        <x-sidebar />

        <div class="main-content">
            <!-- Top Bar -->
            <div class="checkout-topbar">
                <div></div>
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
                <!-- Left: Payment Form -->
                <div class="checkout-form-side">
                    <h1 class="checkout-title">Payment</h1>
                    <p class="checkout-step-label">
                        <strong>Step 2 of 3</strong> • Choose a payment method and complete your order.
                    </p>

                    <!-- Progress Steps -->
                    <div class="progress-steps" style="display: flex; align-items: center; margin-bottom: 2.5rem;">
                        <div class="step" style="display: flex; align-items: center; gap: 0.6rem;">
                            <div
                                style="width: 32px; height: 32px; border-radius: 50%; background: #f97316; color: #fff; display: grid; place-items: center; font-size: 0.85rem; font-weight: 800; flex-shrink: 0;">
                                1</div>
                            <div>
                                <strong
                                    style="display: block; font-weight: 700; color: #0f172a; font-size: 0.9rem;">Shipping</strong>
                                <span style="color: #64748b; font-size: 0.8rem;">Address</span>
                            </div>
                        </div>
                        <div style="flex: 1; height: 1px; background: #e2e8f0; margin: 0 1rem;"></div>
                        <div class="step" style="display: flex; align-items: center; gap: 0.6rem;">
                            <div
                                style="width: 32px; height: 32px; border-radius: 50%; background: #f97316; color: #fff; display: grid; place-items: center; font-size: 0.85rem; font-weight: 800; flex-shrink: 0;">
                                2</div>
                            <div>
                                <strong
                                    style="display: block; font-weight: 700; color: #0f172a; font-size: 0.9rem;">Payment</strong>
                                <span style="color: #64748b; font-size: 0.8rem;">Method</span>
                            </div>
                        </div>
                        <div style="flex: 1; height: 1px; background: #e2e8f0; margin: 0 1rem;"></div>
                        <div class="step" style="display: flex; align-items: center; gap: 0.6rem;">
                            <div
                                style="width: 32px; height: 32px; border-radius: 50%; background: #f1f5f9; color: #94a3b8; border: 1px solid #e2e8f0; display: grid; place-items: center; font-size: 0.85rem; font-weight: 800; flex-shrink: 0;">
                                3</div>
                            <div>
                                <strong
                                    style="display: block; font-weight: 600; color: #94a3b8; font-size: 0.9rem;">Review</strong>
                                <span style="color: #cbd5e1; font-size: 0.8rem;">Order</span>
                            </div>
                        </div>
                    </div>

                    <h2 class="payment-section-title">Payment Method</h2>

                    <form action="{{ route('buyer.orders.store') }}" method="POST" id="paymentForm">
                        @csrf

                        <!-- Pass shipping data from session as hidden fields -->
                        @foreach($shipping as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach

                        <div class="payment-options">
                            <!-- Credit / Debit Card (active by default) -->
                            <div class="payment-option-row active" id="row-card" onclick="selectPayment('card')">
                                <div class="payment-radio">
                                    <div class="payment-radio-dot"></div>
                                </div>
                                <span class="payment-option-label">Credit / Debit Card</span>
                                <div class="payment-option-logos">
                                    <div
                                        style="background:#1a1f71;color:#fff;font-weight:900;font-size:0.65rem;padding:3px 7px;border-radius:4px;letter-spacing:0.05em;">
                                        VISA</div>
                                    <div style="display:flex;align-items:center;">
                                        <div style="background:#eb001b;width:20px;height:14px;border-radius:50%;"></div>
                                        <div
                                            style="background:#f79e1b;width:20px;height:14px;border-radius:50%;margin-left:-8px;opacity:0.9;">
                                        </div>
                                    </div>
                                    <div
                                        style="background:#016fd0;color:#fff;font-weight:900;font-size:0.55rem;padding:3px 5px;border-radius:4px;">
                                        AMEX</div>
                                    <div
                                        style="background:#ff6600;color:#fff;font-weight:900;font-size:0.55rem;padding:3px 5px;border-radius:4px;">
                                        DISC</div>
                                </div>
                            </div>

                            <!-- Card Fields (shown by default) -->
                            <div class="card-fields visible" id="cardFields">
                                <div class="field-group">
                                    <label>Card Number</label>
                                    <input type="text" name="card_number" placeholder="4242 4242 4242 4242" maxlength="19"
                                        oninput="this.value=this.value.replace(/\D/g,'').replace(/(.{4})/g,'$1 ').trim()">
                                </div>
                                <div class="card-row">
                                    <div class="field-group">
                                        <label>Expiry Date</label>
                                        <input type="text" name="card_expiry" placeholder="08 / 28" maxlength="7">
                                    </div>
                                    <div class="field-group">
                                        <label>CVV</label>
                                        <input type="password" name="card_cvv" placeholder="•••" maxlength="4">
                                    </div>
                                </div>
                                <div class="field-group">
                                    <label>Cardholder Name</label>
                                    <input type="text" name="cardholder_name" placeholder="John Doe">
                                </div>
                                <div class="save-card-row">
                                    <input type="checkbox" name="save_card" id="saveCard" checked>
                                    <label for="saveCard">Save card for future payments</label>
                                </div>
                            </div>

                            <!-- PayPal -->
                            <div class="payment-option-row" id="row-paypal" onclick="selectPayment('paypal')">
                                <div class="payment-radio">
                                    <div class="payment-radio-dot"></div>
                                </div>
                                <span class="payment-option-label">PayPal</span>
                                <div class="paypal-text">
                                    <span class="p1">Pay</span><span class="p2">Pal</span>
                                </div>
                            </div>

                            <!-- Apple Pay -->
                            <div class="payment-option-row" id="row-apple" onclick="selectPayment('apple')">
                                <div class="payment-radio">
                                    <div class="payment-radio-dot"></div>
                                </div>
                                <span class="payment-option-label">Apple Pay</span>
                                <div class="apple-pay-text">
                                    <i data-lucide="apple" style="width:18px;"></i> Pay
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="payment_method" id="paymentMethodInput" value="cod">

                        <div class="form-bottom-nav">
                            <a href="{{ route('buyer.checkout.shipping') }}" class="btn-back-link">
                                <i data-lucide="arrow-left" style="width: 16px;"></i> Back to Shipping
                            </a>
                            <button type="submit" class="btn-review">
                            Place Order <i data-lucide="lock" style="width: 18px;"></i>
                        </button>
                        </div>

                        <div class="secure-footer">
                            <i data-lucide="shield-check" style="width: 14px;"></i>
                            Your payment is secure and encrypted.
                        </div>
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
                                <div class="summary-item-price">${{ number_format($item['price'] * $item['quantity'], 2) }}
                                    @if(!empty($item['has_discount']))
                                        <span style="display: block; color: #94a3b8; font-size: 0.78rem; text-decoration: line-through;">
                                            ${{ number_format($item['original_price'] * $item['quantity'], 2) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div>
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

    <script>
        function selectPayment(method) {
            // Deactivate all rows
            ['card', 'paypal', 'apple'].forEach(function (m) {
                var row = document.getElementById('row-' + m);
                if (row) row.classList.remove('active');
            });

            // Activate selected row
            var selected = document.getElementById('row-' + method);
            if (selected) selected.classList.add('active');

            // Show card fields only for card option
            var cardFields = document.getElementById('cardFields');
            if (cardFields) {
                cardFields.style.display = (method === 'card') ? 'block' : 'none';
            }

            // Update hidden payment method input
            var map = { card: 'card', paypal: 'paypal', apple: 'apple_pay' };
            var input = document.getElementById('paymentMethodInput');
            if (input) input.value = map[method] || 'card';
        }

        // Initialize: card is active on load, card fields visible
        window.addEventListener('DOMContentLoaded', function () {
            selectPayment('card');
        });
    </script>
@endsection
