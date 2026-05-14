@extends('layouts.app')

@section('title', 'SM-SHOP | Seller Help Center')

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

        .help-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .help-hero {
            text-align: center;
            margin-bottom: 3rem;
            padding: 3rem 2rem;
            background: linear-gradient(135deg, var(--accent-soft) 0%, #fff 100%);
            border-radius: 24px;
            border: 1px solid #ffedd5;
            box-shadow: 0 15px 40px rgba(249, 115, 22, 0.05);
        }

        .help-hero h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 2.25rem;
            font-weight: 900;
            color: var(--text-main);
            margin-bottom: 0.75rem;
            letter-spacing: -0.03em;
        }

        .help-hero p {
            color: var(--text-secondary);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }

        .help-search-wrapper {
            position: relative;
            max-width: 650px;
            margin: 0 auto;
        }

        .help-search-icon {
            position: absolute;
            left: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            width: 24px;
            height: 24px;
        }

        .help-search-input {
            width: 100%;
            padding: 1.25rem 1.5rem 1.25rem 4rem;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            background: #fff;
            font-size: 1.1rem;
            color: var(--text-main);
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .help-search-input:focus {
            outline: none;
            border-color: var(--accent-brand);
            box-shadow: 0 15px 40px rgba(249, 115, 22, 0.1);
            transform: translateY(-2px);
        }

        .help-categories {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 4rem;
        }

        .category-card {
            background: #fff;
            border: 1px solid var(--border-subtle);
            border-radius: 20px;
            padding: 1.75rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.01);
            height: 100%;
        }

        .category-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent-brand);
            background: var(--accent-soft);
            box-shadow: 0 12px 30px rgba(249, 115, 22, 0.08);
        }

        .category-icon {
            width: 60px;
            height: 60px;
            background: var(--accent-soft);
            color: var(--accent-brand);
            border-radius: 18px;
            display: grid;
            place-items: center;
        }

        .category-card h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
        }

        .category-card p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.5;
            margin: 0;
        }

        .faq-section {
            background: #fff;
            border-radius: 32px;
            padding: 4rem;
            border: 1px solid var(--border-subtle);
            margin-bottom: 5rem;
        }

        .faq-section h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 3rem;
            text-align: center;
        }

        .faq-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 2.5rem;
        }

        .faq-item h4 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .faq-item h4 i {
            color: var(--accent-brand);
            flex-shrink: 0;
            margin-top: 2px;
        }

        .faq-item p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.6;
            padding-left: 2rem;
        }

        .support-cta {
            background: var(--text-main);
            border-radius: 32px;
            padding: 4rem;
            color: #fff;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
        }

        .support-cta h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 2.25rem;
            font-weight: 800;
            margin: 0;
        }

        .support-cta p {
            color: #94a3b8;
            font-size: 1.1rem;
            max-width: 500px;
            margin: 0;
        }

        .btn-support {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: var(--accent-brand);
            color: #fff;
            padding: 1.25rem 2.5rem;
            border-radius: 18px;
            font-weight: 800;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s;
            margin-top: 1rem;
            box-shadow: 0 10px 30px rgba(249, 115, 22, 0.3);
        }

        .btn-support:hover {
            background: #ea580c;
            transform: translateY(-4px);
            box-shadow: 0 15px 40px rgba(249, 115, 22, 0.4);
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-shell">
        <x-sidebar />

        <main class="dashboard-main">
            <div class="help-container">
                <section class="help-hero">
                    <h1>How can we help you?</h1>
                    <p>Search our seller guide or browse categories to find answers for your store.</p>
                    <div class="help-search-wrapper">
                        <i data-lucide="search" class="help-search-icon"></i>
                        <input type="text" class="help-search-input" placeholder="Search for 'how to add products', 'payouts', etc...">
                    </div>
                </section>

                <div class="help-categories">
                    <a href="#" class="category-card">
                        <div class="category-icon"><i data-lucide="rocket"></i></div>
                        <div class="category-content">
                            <h3>Getting Started</h3>
                            <p>Setup your store and list products.</p>
                        </div>
                    </a>
                    <a href="#" class="category-card">
                        <div class="category-icon"><i data-lucide="package"></i></div>
                        <div class="category-content">
                            <h3>Products</h3>
                            <p>Guidelines & photography tips.</p>
                        </div>
                    </a>
                    <a href="#" class="category-card">
                        <div class="category-icon"><i data-lucide="truck"></i></div>
                        <div class="category-content">
                            <h3>Fulfillment</h3>
                            <p>Process orders & manage shipping.</p>
                        </div>
                    </a>
                    <a href="#" class="category-card">
                        <div class="category-icon"><i data-lucide="wallet"></i></div>
                        <div class="category-content">
                            <h3>Payouts</h3>
                            <p>Manage earnings & payments.</p>
                        </div>
                    </a>
                </div>

                <section class="faq-section">
                    <h2>Frequently Asked Questions</h2>
                    <div class="faq-grid">
                        <div class="faq-item">
                            <h4><i data-lucide="help-circle" size="18"></i> When do I get paid?</h4>
                            <p>Payouts are processed 7 days after delivery confirmation.</p>
                        </div>
                        <div class="faq-item">
                            <h4><i data-lucide="help-circle" size="18"></i> How to edit a product?</h4>
                            <p>Click the 'Edit' icon next to any product in your Home list.</p>
                        </div>
                        <div class="faq-item">
                            <h4><i data-lucide="help-circle" size="18"></i> What are the fees?</h4>
                            <p>We take a 5% commission. No monthly listing fees.</p>
                        </div>
                        <div class="faq-item">
                            <h4><i data-lucide="help-circle" size="18"></i> Can I offer coupons?</h4>
                            <p>Yes, manage them via the 'Coupons' tab in your dashboard.</p>
                        </div>
                    </div>
                </section>

                <section class="support-cta">
                    <div style="text-align: left;">
                        <h2>Still need help?</h2>
                        <p>Our support team is here to help your business grow 24/7.</p>
                    </div>
                    <button type="button" class="btn-support" onclick="toggleSupportModal(true)">
                        <i data-lucide="message-square"></i>
                        <span>Contact Support</span>
                    </button>
                </section>
            </div>
        </main>
    </div>

    {{-- Support Modal --}}
    <div id="supportModal" class="modal-overlay" style="display: none;">
        <div class="support-modal">
            <div class="modal-header">
                <h3>Contact Seller Support</h3>
                <button type="button" class="btn-close-modal" onclick="toggleSupportModal(false)">
                    <i data-lucide="x"></i>
                </button>
            </div>
            <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Your message has been sent to our support team!'); toggleSupportModal(false);">
                <div class="form-group">
                    <label>Subject</label>
                    <select class="form-input">
                        <option>General Inquiry</option>
                        <option>Order Issue</option>
                        <option>Payout Question</option>
                        <option>Product Listing Problem</option>
                        <option>Technical Support</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea class="form-input" rows="5" placeholder="Tell us more about your issue..." required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="toggleSupportModal(false)">Cancel</button>
                    <button type="submit" class="btn-primary">Send Message</button>
                </div>
            </form>
        </div>
    </div>

    @push('styles')
    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 2000;
            display: grid;
            place-items: center;
            padding: 2rem;
        }
        .support-modal {
            background: #fff;
            width: 100%;
            max-width: 500px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: modalScale 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        @keyframes modalScale {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .modal-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-header h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            margin: 0;
            color: var(--text-main);
        }
        .btn-close-modal {
            background: #f8fafc;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-close-modal:hover {
            background: #f1f5f9;
            color: #ef4444;
        }
        .form-group {
            padding: 1.5rem 2rem 0;
        }
        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.95rem;
            background: #f8fafc;
            transition: all 0.2s;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--accent-brand);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.05);
        }
        .modal-footer {
            padding: 1.5rem 2rem 2rem;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }
        .btn-secondary {
            background: #fff;
            border: 1px solid #e2e8f0;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
        }
        .btn-primary {
            background: var(--accent-brand);
            color: #fff;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 12px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2);
        }
        .category-card {
            flex-direction: row !important;
            padding: 1.5rem !important;
            align-items: center !important;
        }
        .category-icon {
            width: 48px !important;
            height: 48px !important;
        }
        .category-card h3 {
            font-size: 1.1rem !important;
            margin-bottom: 0.25rem !important;
        }
        .support-cta {
            flex-direction: row !important;
            justify-content: space-between !important;
            text-align: left !important;
            padding: 3rem !important;
        }
    </style>
    @endpush

    <script>
        function toggleSupportModal(show) {
            const modal = document.getElementById('supportModal');
            modal.style.display = show ? 'grid' : 'none';
        }

        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
@endsection
