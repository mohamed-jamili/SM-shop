@extends('layouts.app')

@section('title', 'SM-SHOP | Notifications')

@push('styles')
    <style>
        .notifications-shell {
            display: flex;
            min-height: 100vh;
            background: #fdfcfb;
        }

        .notifications-main {
            margin-left: 280px;
            width: calc(100% - 280px);
            padding: 2rem 2.5rem;
            max-width: 1440px;
        }

        .notifications-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 1rem;
            margin-bottom: 1.75rem;
        }

        .notifications-title {
            font-size: clamp(2rem, 2.5vw, 2.5rem);
            margin: 0;
            letter-spacing: -0.03em;
        }

        .notifications-subtitle {
            margin: 0.5rem 0 0;
            color: #475569;
            max-width: 46rem;
            line-height: 1.7;
        }

        .notification-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .notification-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: #f97316;
            color: #fff;
            padding: 0.75rem 1rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .notifications-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.5rem;
        }

        .notification-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 1.5rem;
            transition: transform 0.24s ease, box-shadow 0.24s ease;
            position: relative;
        }

        .notification-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        }

        .notification-card.unread {
            background: #fffbf2;
            border-color: #fdece1;
        }

        .notification-card .notification-meta {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .notification-card .notification-meta strong {
            font-size: 1rem;
            display: block;
            color: #0f172a;
        }

        .notification-card .notification-message {
            margin: 0;
            color: #334155;
            line-height: 1.7;
            font-size: 0.98rem;
        }

        .notification-card .notification-footer {
            margin-top: 1.35rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .notification-card .notification-time {
            color: #64748b;
            font-size: 0.88rem;
        }

        .notification-card button,
        .notification-card a {
            border: none;
            background: #f97316;
            color: #fff;
            padding: 0.85rem 1.15rem;
            border-radius: 999px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .notification-card button:hover,
        .notification-card a:hover {
            background: #ea580c;
        }

        .notifications-empty {
            display: grid;
            place-items: center;
            min-height: 320px;
            background: #ffffff;
            border: 1px dashed #cbd5e1;
            border-radius: 24px;
            color: #64748b;
            text-align: center;
            padding: 3rem;
        }

        @media (max-width: 980px) {
            .notifications-grid {
                grid-template-columns: 1fr;
            }

            .notifications-main {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="notifications-shell">
        <x-sidebar />

        <main class="notifications-main">
            <div class="notifications-header">
                <div>
                    <h1 class="notifications-title">Notifications</h1>
                    <p class="notifications-subtitle">All buyer and seller notifications are displayed here with unread states and real-time refresh.</p>
                </div>

                <div class="notification-actions">
                    <div class="notification-badge-pill">
                        <i data-lucide="bell"></i>
                        <span id="notifications-pill-count">{{ $unreadCount }} unread</span>
                    </div>
                </div>
            </div>

            <div id="notifications-list" class="notifications-grid">
                @forelse($notifications as $notification)
                    <article class="notification-card {{ $notification->read_at ? '' : 'unread' }}">
                        <div class="notification-meta">
                            <strong>{{ $notification->data['title'] ?? 'Update' }}</strong>
                            <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="notification-message">{{ $notification->data['message'] ?? 'No details available.' }}</p>
                        <div class="notification-footer">
                            @if(!$notification->read_at)
                                <form action="{{ route('notifications.read', $notification) }}" method="POST">
                                    @csrf
                                    <button type="submit">Mark as read</button>
                                </form>
                            @else
                                <span style="color: #22c55e; font-weight: 700;">Read</span>
                            @endif

                            @if(isset($notification->data['order_id']) && auth()->user()->isBuyer())
                                <a href="{{ route('buyer.order.confirmation', ['order' => $notification->data['order_id']]) }}">View order</a>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="notifications-empty">
                        <div>
                            <h2>No notifications yet</h2>
                            <p>Once activity happens, you will see order updates, cart alerts, and seller messages here.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div style="margin-top: 1.5rem;">
                {{ $notifications->links() }}
            </div>
        </main>
    </div>
@endsection

@push('scripts')
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            const badges = document.querySelectorAll('.notification-badge');
            const list = document.getElementById('notifications-list');
            const summaryUrl = '{{ route('notifications.summary') }}';
            const refreshFrequencyMs = 10000;

            if (!summaryUrl) {
                return;
            }

            const updateNotificationUI = function (data) {
                if (!data || typeof data.unreadCount === 'undefined') {
                    return;
                }

                if (badges.length) {
                    badges.forEach((badgeItem) => {
                        badgeItem.textContent = data.unreadCount;
                    });
                }

                const pagePillCount = document.getElementById('notifications-pill-count');
                if (pagePillCount) {
                    pagePillCount.textContent = `${data.unreadCount} unread`;
                }
            };

            const refreshNotifications = function () {
                fetch(summaryUrl, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                })
                    .then(response => response.ok ? response.json() : null)
                    .then(data => {
                        updateNotificationUI(data);

                        if (list && data && Array.isArray(data.notifications)) {
                            list.innerHTML = data.notifications.map(notification => {
                                return `
                                    <article class="notification-card ${notification.read_at ? '' : 'unread'}">
                                        <div class="notification-meta">
                                            <strong>${notification.title}</strong>
                                            <span class="notification-time">${notification.created_at}</span>
                                        </div>
                                        <p class="notification-message">${notification.message}</p>
                                    </article>
                                `;
                            }).join('');
                        }
                    })
                    .catch(() => {
                        // Silent fail; polling is best-effort.
                    });
            };

            setInterval(refreshNotifications, refreshFrequencyMs);
        });
    </script>
@endpush
