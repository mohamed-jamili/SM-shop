@extends('layouts.app')

@section('title', 'SM-SHOP | Sold Products')

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

        .sales-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .sales-header {
            margin-bottom: 2rem;
        }

        .sales-header h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0 0 0.5rem;
            letter-spacing: -0.02em;
        }

        .sales-header p {
            color: var(--text-secondary);
            font-size: 1rem;
            margin: 0;
        }

        .orders-shell {
            background: var(--card-bg);
            border: 1px solid var(--border-subtle);
            border-radius: 24px;
            padding: 1.5rem;
            display: grid;
            gap: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.01);
        }

        .orders-shell-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            border-bottom: 1px solid var(--border-subtle);
            padding-bottom: 1.25rem;
        }

        .seller-order-card {
            border: 1px solid var(--border-subtle);
            border-radius: 22px;
            padding: 1.4rem;
            display: grid;
            gap: 1.1rem;
            background: #fff;
        }

        .seller-order-card:hover {
            border-color: #fed7aa;
            box-shadow: 0 14px 30px rgba(249, 115, 22, 0.08);
        }

        .seller-order-header {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            align-items: flex-start;
        }

        .seller-order-heading {
            display: grid;
            gap: 0.55rem;
        }

        .seller-order-number {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            color: var(--text-main);
            font-size: 1.05rem;
        }

        .seller-order-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        .seller-order-total {
            display: grid;
            gap: 0.5rem;
            justify-items: end;
        }

        .seller-order-total strong {
            color: var(--accent-brand);
            font-size: 1.1rem;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 0.85rem;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .pill.pending {
            background: #fffbeb;
            color: #b45309;
        }

        .pill.accepted {
            background: #f0fdf4;
            color: #15803d;
        }

        .pill.preparing {
            background: #eff6ff;
            color: #2563eb;
        }

        .pill.shipping {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .pill.delivered {
            background: #ecfdf5;
            color: #059669;
        }

        .pill.rejected {
            background: #fef2f2;
            color: #dc2626;
        }

        .pill.partial {
            background: #fff7ed;
            color: #c2410c;
        }

        .pill-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .seller-order-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 0.75rem;
        }

        .seller-order-stat {
            border: 1px solid var(--border-subtle);
            border-radius: 16px;
            padding: 0.95rem 1rem;
            background: #fcfcfd;
        }

        .seller-order-stat span {
            display: block;
            color: var(--text-secondary);
            font-size: 0.78rem;
            margin-bottom: 0.35rem;
        }

        .seller-order-stat strong {
            color: var(--text-main);
            font-size: 0.92rem;
        }

        .seller-products-list {
            display: grid;
            gap: 0.75rem;
        }

        .seller-product-row {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            padding: 0.9rem 1rem;
            border: 1px solid var(--border-subtle);
            border-radius: 16px;
            background: #fff;
        }

        .product-thumb {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid var(--border-subtle);
            flex-shrink: 0;
        }

        .product-meta {
            display: grid;
            gap: 0.2rem;
            min-width: 0;
        }

        .product-meta h4 {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--text-main);
            margin: 0;
        }

        .product-meta span {
            font-size: 0.78rem;
            color: var(--text-secondary);
        }

        .product-status-wrap {
            margin-left: auto;
            display: grid;
            justify-items: end;
            gap: 0.45rem;
        }

        .product-status-wrap strong {
            color: var(--accent-brand);
            font-size: 0.9rem;
        }

        .tracking-card {
            border: 1px solid var(--border-subtle);
            border-radius: 18px;
            background: #fcfcfd;
            padding: 1rem;
            display: grid;
            gap: 0.85rem;
        }

        .tracking-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .tracking-head strong {
            color: var(--text-main);
            font-size: 0.92rem;
        }

        .tracking-head span {
            color: var(--text-secondary);
            font-size: 0.82rem;
        }

        .tracking-progress-bar {
            width: 100%;
            height: 8px;
            border-radius: 999px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .tracking-progress-bar span {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: var(--accent-brand);
        }

        .tracking-steps {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 0.75rem;
        }

        .tracking-step {
            display: grid;
            gap: 0.45rem;
            justify-items: center;
            text-align: center;
        }

        .tracking-step-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 2px solid #cbd5e1;
            background: #fff;
        }

        .tracking-step.completed .tracking-step-dot {
            border-color: var(--accent-brand);
            background: var(--accent-brand);
        }

        .tracking-step.current .tracking-step-dot {
            border-color: var(--accent-brand);
            background: var(--accent-soft);
            box-shadow: 0 0 0 6px rgba(249, 115, 22, 0.12);
        }

        .tracking-step-label {
            font-size: 0.76rem;
            font-weight: 700;
            color: #94a3b8;
            line-height: 1.35;
        }

        .tracking-step.completed .tracking-step-label,
        .tracking-step.current .tracking-step-label {
            color: var(--text-main);
        }

        .action-stack {
            display: flex;
            gap: 0.65rem;
            flex-wrap: wrap;
        }

        .btn-status {
            border: none;
            border-radius: 12px;
            padding: 0.7rem 1rem;
            font-size: 0.78rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-status:hover {
            transform: translateY(-1px);
        }

        .btn-status.accepted {
            background: #f0fdf4;
            color: #15803d;
        }

        .btn-status.rejected {
            background: #fef2f2;
            color: #dc2626;
        }

        .btn-status.preparing {
            background: #eff6ff;
            color: #2563eb;
        }

        .btn-status.shipping {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .btn-status.delivered {
            background: #ecfdf5;
            color: #059669;
        }

        .seller-order-note {
            padding: 0.9rem 1rem;
            border-radius: 16px;
            font-size: 0.84rem;
            line-height: 1.55;
        }

        .seller-order-note.partial {
            background: #fff7ed;
            color: #9a3412;
            border: 1px solid #fed7aa;
        }

        .seller-order-note.rejected {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .seller-empty {
            text-align: center;
            padding: 4rem 1rem;
            color: var(--text-secondary);
        }

        .seller-empty p {
            margin: 0.8rem 0 0;
        }

        @media (max-width: 1280px) {
            .seller-order-stats,
            .tracking-steps {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 1024px) {
            .dashboard-main {
                margin-left: 0;
                padding: 1.5rem;
            }

            .orders-shell-head,
            .seller-order-header,
            .tracking-head {
                flex-direction: column;
                align-items: flex-start;
            }

            .seller-order-total {
                justify-items: start;
            }
        }

        @media (max-width: 640px) {
            .seller-order-stats,
            .tracking-steps {
                grid-template-columns: 1fr;
            }

            .seller-product-row {
                align-items: flex-start;
            }

            .product-status-wrap {
                margin-left: 0;
                justify-items: start;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-shell">
        <x-sidebar />

        <main class="dashboard-main">
            <div class="sales-container">
                <header class="sales-header">
                    <h1>Sold Products</h1>
                    <p>Review incoming orders, validate them, and move accepted items through preparation and delivery.</p>
                </header>

                <div class="orders-shell">
                    <div class="orders-shell-head">
                        <span style="font-size: 0.85rem; color: var(--text-secondary);">Order management for your products</span>
                        <span style="font-size: 0.85rem; color: var(--text-secondary);">{{ $orders->count() }} orders</span>
                    </div>

                    @php
                        $actionLabels = [
                            \App\Models\OrderItem::STATUS_ACCEPTED => 'Accept Order',
                            \App\Models\OrderItem::STATUS_REJECTED => 'Reject Order',
                            \App\Models\OrderItem::STATUS_PREPARING => 'Start Preparing',
                            \App\Models\OrderItem::STATUS_SHIPPING => 'Mark as Shipping',
                            \App\Models\OrderItem::STATUS_DELIVERED => 'Mark as Delivered',
                        ];
                    @endphp

                    @forelse($orders as $order)
                        @php($sellerStatus = $order->sellerStatus($user->id))
                        @php($statusMeta = $order->sellerStatusMeta($user->id))
                        @php($sellerItems = $order->sellerItems($user->id))
                        @php($sellerTotal = $sellerItems->sum(fn($item) => (float) $item->subtotal))
                        @php($availableTransitions = $order->sellerAvailableTransitions($user->id))
                        <article class="seller-order-card">
                            <div class="seller-order-header">
                                <div class="seller-order-heading">
                                    <span class="seller-order-number">Order #{{ $order->order_number }}</span>
                                    <div class="seller-order-meta">
                                        <span>{{ ($order->ordered_at ?? $order->created_at)->format('M d, Y') }}</span>
                                        <span>{{ $order->buyer->name }}</span>
                                        <span>{{ $order->buyer->email }}</span>
                                    </div>
                                </div>

                                <div class="seller-order-total">
                                    <span class="pill {{ $statusMeta['badge'] }}">
                                        <span class="pill-dot"></span>
                                        {{ $statusMeta['label'] }}
                                    </span>
                                    <strong>${{ number_format($sellerTotal, 2) }}</strong>
                                </div>
                            </div>

                            <div class="seller-order-stats">
                                <div class="seller-order-stat">
                                    <span>Products</span>
                                    <strong>{{ $sellerItems->count() }} item(s)</strong>
                                </div>
                                <div class="seller-order-stat">
                                    <span>City</span>
                                    <strong>{{ $order->shipping_city }}</strong>
                                </div>
                                <div class="seller-order-stat">
                                    <span>Payment</span>
                                    <strong>{{ str($order->payment_method)->replace('_', ' ')->title() }}</strong>
                                </div>
                                <div class="seller-order-stat">
                                    <span>Order Total</span>
                                    <strong>${{ number_format((float) $order->total_amount, 2) }}</strong>
                                </div>
                            </div>

                            <div class="seller-products-list">
                                @foreach($sellerItems as $item)
                                    @php($itemStatusMeta = $item->status_meta)
                                    <div class="seller-product-row">
                                        @if($item->product?->image_path)
                                            <img src="{{ asset('storage/' . $item->product->image_path) }}"
                                                alt="{{ $item->product?->name ?? 'Product image' }}"
                                                class="product-thumb">
                                        @else
                                            <div class="product-thumb"
                                                style="background: #f1f5f9; display: grid; place-items: center; color: #94a3b8;">
                                                <i data-lucide="image" style="width: 16px; height: 16px;"></i>
                                            </div>
                                        @endif

                                        <div class="product-meta">
                                            <h4>{{ $item->product?->name ?? 'Deleted Product' }}</h4>
                                            <span>Qty: {{ $item->quantity }} x ${{ number_format($item->unit_price, 2) }}</span>
                                        </div>

                                        <div class="product-status-wrap">
                                            <span class="pill {{ $itemStatusMeta['badge'] }}">
                                                <span class="pill-dot"></span>
                                                {{ $itemStatusMeta['label'] }}
                                            </span>
                                            <strong>${{ number_format((float) $item->subtotal, 2) }}</strong>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="tracking-card">
                                <div class="tracking-head">
                                    <div>
                                        <strong>Current status</strong>
                                        <span>{{ $statusMeta['description'] }}</span>
                                    </div>
                                    <span>{{ $order->sellerItems($user->id)->count() }} seller-managed products</span>
                                </div>

                                <div class="tracking-progress-bar">
                                    <span style="width: {{ $order->sellerTrackingProgress($user->id) }}%;"></span>
                                </div>

                                <div class="tracking-steps">
                                    @foreach($order->sellerTrackingSteps($user->id) as $step)
                                        <div class="tracking-step {{ $step['state'] }}">
                                            <span class="tracking-step-dot"></span>
                                            <span class="tracking-step-label">{{ $step['label'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="action-stack">
                                @forelse($availableTransitions as $targetStatus)
                                    <form action="{{ route('seller.orders.status', $order) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ $targetStatus }}">
                                        <button type="submit" class="btn-status {{ $targetStatus }}">
                                            {{ $actionLabels[$targetStatus] ?? str($targetStatus)->replace('_', ' ')->title() }}
                                        </button>
                                    </form>
                                @empty
                                    <span style="font-size: 0.84rem; color: var(--text-secondary);">No further actions available for this order.</span>
                                @endforelse
                            </div>

                            @if($sellerStatus === \App\Models\Order::STATUS_PARTIALLY_ACCEPTED)
                                <div class="seller-order-note partial">
                                    This order contains a mix of accepted and non-accepted items for your shop. You can continue progressing the accepted items without changing the buyer's other seller relationships.
                                </div>
                            @elseif($sellerStatus === \App\Models\Order::STATUS_REJECTED)
                                <div class="seller-order-note rejected">
                                    All of your products in this order are currently rejected. You can still re-accept them later if stock is available.
                                </div>
                            @endif
                        </article>
                    @empty
                        <div class="seller-empty">
                            <i data-lucide="shopping-cart" size="40" style="margin-bottom: 1rem; opacity: 0.2;"></i>
                            <p>No products sold yet. Your incoming orders will appear here.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
@endsection
