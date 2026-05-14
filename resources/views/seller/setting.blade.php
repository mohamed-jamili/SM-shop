@extends('layouts.app')

@section('title', 'SM-SHOP | Seller Settings')

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

        .settings-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .settings-header {
            margin-bottom: 2.5rem;
        }

        .settings-header h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0 0 0.5rem;
            letter-spacing: -0.02em;
        }

        .settings-header p {
            color: var(--text-secondary);
            font-size: 1rem;
            margin: 0;
        }

        .settings-card {
            background: #fff;
            border: 1px solid var(--border-subtle);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
        }

        .settings-row {
            display: flex;
            align-items: center;
            padding: 2rem;
            border-bottom: 1px solid var(--border-subtle);
            gap: 1.5rem;
            transition: background 0.2s;
            text-decoration: none;
            color: inherit;
        }

        a.settings-row:hover {
            background: #f8fafc;
        }

        .settings-row:last-child {
            border-bottom: none;
        }

        .settings-icon {
            width: 54px;
            height: 54px;
            background: var(--accent-soft);
            color: var(--accent-brand);
            border-radius: 16px;
            display: grid;
            place-items: center;
            flex-shrink: 0;
        }

        .settings-info {
            flex: 1;
        }

        .settings-info strong {
            display: block;
            color: var(--text-main);
            font-size: 1.1rem;
            margin-bottom: 0.25rem;
            font-family: 'Outfit', sans-serif;
        }

        .settings-info p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin: 0;
        }

        .settings-action {
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .settings-select {
            padding: 0.6rem 2.5rem 0.6rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.9rem;
            color: var(--text-main);
            background: #fff;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px;
            outline: none;
        }

        .theme-toggle-group {
            display: flex;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
        }

        .theme-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-secondary);
            background: #fff;
            border: none;
            border-right: 1px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.2s;
        }

        .theme-btn:last-child {
            border-right: none;
        }

        .theme-btn.active {
            background: var(--accent-soft);
            color: var(--accent-brand);
        }

        .notif-toggle {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-main);
            cursor: pointer;
        }

        .notif-toggle input {
            accent-color: var(--accent-brand);
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-shell">
        <x-sidebar />

        <main class="dashboard-main">
            <div class="settings-container">
                <header class="settings-header">
                    <h1>Settings</h1>
                    <p>Manage your account preferences and seller settings.</p>
                </header>

                <div class="settings-card">
                    <a href="{{ route('seller.profile') }}" class="settings-row">
                        <div class="settings-icon"><i data-lucide="user"></i></div>
                        <div class="settings-info">
                            <strong>Profile Information</strong>
                            <p>Update your personal information, address and contact details.</p>
                        </div>
                        <div class="settings-action"><i data-lucide="chevron-right"></i></div>
                    </a>

                    <div class="settings-row" style="cursor: default;">
                        <div class="settings-icon"><i data-lucide="bell"></i></div>
                        <div class="settings-info">
                            <strong>Notifications</strong>
                            <p>Choose how you want to receive updates about your orders and store.</p>
                        </div>
                        <div class="settings-action">
                            <label class="notif-toggle">
                                <input type="checkbox" checked> Email
                            </label>
                            <label class="notif-toggle" style="margin-left: 1rem;">
                                <input type="checkbox"> SMS
                            </label>
                        </div>
                    </div>

                    <div class="settings-row" style="cursor: default;">
                        <div class="settings-icon"><i data-lucide="globe"></i></div>
                        <div class="settings-info">
                            <strong>Language & Region</strong>
                            <p>Select your preferred language for the seller dashboard.</p>
                        </div>
                        <div class="settings-action">
                            <select class="settings-select">
                                <option value="en">English (US)</option>
                                <option value="fr">Français</option>
                                <option value="es">Español</option>
                            </select>
                        </div>
                    </div>

                    <div class="settings-row" style="cursor: default;">
                        <div class="settings-icon"><i data-lucide="moon"></i></div>
                        <div class="settings-info">
                            <strong>Dashboard Appearance</strong>
                            <p>Customize the visual theme of your workspace.</p>
                        </div>
                        <div class="settings-action">
                            <div class="theme-toggle-group">
                                <button class="theme-btn active"><i data-lucide="sun" size="16"></i> Light</button>
                                <button class="theme-btn"><i data-lucide="moon" size="16"></i> Dark</button>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="settings-row">
                        <div class="settings-icon"><i data-lucide="help-circle"></i></div>
                        <div class="settings-info">
                            <strong>Seller Help Center</strong>
                            <p>Get help with your products, orders and read our seller guide.</p>
                        </div>
                        <div class="settings-action"><i data-lucide="chevron-right"></i></div>
                    </a>

                    <a href="{{ route('seller.profile') }}" class="settings-row" style="border-top: 1px solid #fee2e2;">
                        <div class="settings-icon" style="background: #fef2f2; color: #dc2626;"><i data-lucide="trash-2"></i></div>
                        <div class="settings-info">
                            <strong style="color: #dc2626;">Delete Seller Account</strong>
                            <p>Permanently remove your store and all your data from the platform.</p>
                        </div>
                        <div class="settings-action" style="color: #dc2626;"><i data-lucide="chevron-right"></i></div>
                    </a>
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
