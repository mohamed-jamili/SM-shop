@extends('layouts.app')

@push('styles')
    <style>
        .auth-screen {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            background: #fff;
            position: relative;
            z-index: 10;
        }

        /* Left Side - SaaS Showcase */
        .auth-showcase {
            background: #080808; /* Ultra Dark Premium */
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            color: #fff;
        }

        .auth-showcase::before {
            content: '';
            position: absolute;
            top: -10%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(249, 115, 22, 0.2) 0%, transparent 70%);
            filter: blur(80px);
        }

        .showcase-top {
            display: flex;
            align-items: center;
            gap: 1rem;
            z-index: 1;
        }

        .showcase-logo {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .showcase-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .showcase-brand {
            font-family: 'Outfit', sans-serif;
            font-size: 1.4rem;
            font-weight: 900;
            letter-spacing: -0.04em;
        }

        .showcase-main {
            z-index: 1;
            max-width: 600px;
        }

        .showcase-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.4rem 0.8rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 99px;
            font-size: 0.85rem;
            font-weight: 700;
            color: #f97316;
            margin-bottom: 2rem;
        }

        .showcase-main h1 {
            font-family: 'Outfit', sans-serif;
            font-size: clamp(2rem, 3.5vw, 2.8rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.25rem;
            letter-spacing: -0.04em;
        }

        .showcase-main h1 span {
            color: #f97316;
        }

        .showcase-main p {
            font-size: 1rem;
            line-height: 1.6;
            color: #94a3b8;
            margin-bottom: 1rem;
        }

        /* Mockup Preview */
        .mockup-preview {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 1rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.4);
            transform: perspective(1000px) rotateY(-5deg) rotateX(5deg);
            transition: transform 0.5s;
        }

        .mockup-preview:hover {
            transform: perspective(1000px) rotateY(0deg) rotateX(0deg);
        }

        .mockup-header {
            display: flex;
            gap: 6px;
            margin-bottom: 1.5rem;
        }

        .m-dot { width: 10px; height: 10px; border-radius: 50%; background: rgba(255, 255, 255, 0.1); }

        .mockup-rows {
            display: grid;
            gap: 1rem;
        }

        .m-row {
            height: 12px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 4px;
        }

        .showcase-footer {
            display: flex;
            align-items: center;
            gap: 2rem;
            z-index: 1;
        }

        .trust-item strong {
            display: block;
            font-size: 1.25rem;
            font-family: 'Outfit', sans-serif;
        }

        .trust-item span {
            font-size: 0.85rem;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Right Side - Form Panel */
        .auth-panel {
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 1.25rem clamp(1rem, 5vw, 2.5rem);
            position: relative;
        }

        .auth-form-container {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }

        .auth-header {
            margin-bottom: 1.25rem;
        }

        .auth-title {
            font-family: 'Outfit', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.03em;
            margin-bottom: 0.25rem;
        }

        .auth-subtitle {
            font-size: 1rem;
            color: #64748b;
        }

        /* SaaS Form Elements */
        .form-group {
            margin-bottom: 0.85rem;
        }

        .form-label {
            display: block;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 0.9rem;
            color: #1e293b;
            margin-bottom: 0.4rem;
        }

        .form-input {
            width: 100%;
            padding: 0.6rem 0.9rem;
            background: #f8fafc;
            border: 2px solid #f1f5f9;
            border-radius: 12px;
            font-size: 0.95rem;
            color: #0f172a;
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none;
            background: #fff;
            border-color: #f97316;
            box-shadow: 0 0 0 5px rgba(249, 115, 22, 0.08);
        }

        .password-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            background: none;
            border: none;
            padding: 0;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.3s;
            z-index: 10;
        }

        .password-toggle:hover {
            color: #f97316;
        }

        .role-selector {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.85rem;
            margin-bottom: 1rem;
        }

        .role-card {
            cursor: pointer;
            position: relative;
            padding: 0.65rem;
            background: #f8fafc;
            border: 2px solid #f1f5f9;
            border-radius: 14px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
        }

        .role-card input {
            position: absolute;
            opacity: 0;
        }

        .role-card i {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
            color: #64748b;
            display: block;
        }

        .role-card strong {
            display: block;
            font-size: 0.95rem;
            font-weight: 800;
            color: #1e293b;
        }

        .role-card:hover {
            border-color: #e2e8f0;
            transform: translateY(-2px);
        }

        .role-card:has(input:checked) {
            background: #fff;
            border-color: #f97316;
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.1);
        }

        .role-card:has(input:checked) i,
        .role-card:has(input:checked) strong {
            color: #f97316;
        }

        .btn-auth {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 0.75rem;
            box-shadow: 0 10px 25px rgba(249, 115, 22, 0.2);
        }

        .btn-auth:hover {
            background: #1e293b;
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .auth-links {
            margin-top: 1.75rem;
            text-align: center;
            font-size: 0.95rem;
            color: #64748b;
        }

        .auth-links a {
            color: #f97316;
            font-weight: 800;
            text-decoration: none;
        }

        .back-to-site {
            position: absolute;
            top: 2rem;
            right: 2.5rem;
            font-weight: 800;
            font-size: 0.95rem;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            transition: color 0.3s;
        }

        .back-to-site:hover {
            color: #0f172a;
        }

        @media (max-width: 1100px) {
            .auth-screen {
                grid-template-columns: 1fr;
            }
            .auth-showcase {
                display: none;
            }
            .back-to-site {
                top: 2rem;
                right: 2rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="auth-screen">
        <!-- SaaS Showcase -->
        <section class="auth-showcase">
            <div class="showcase-top">
                <div class="showcase-logo">
                    <img src="{{ asset('images/sm-logo.jpg') }}" alt="SM-SHOP Logo">
                </div>
                <div class="showcase-brand">SM-SHOP</div>
            </div>

            <div class="showcase-main">
                <h1>Scale your <br> <span>business</span> faster <br> than ever.</h1>
                <p>Enterprise-grade infrastructure, beautiful seller tools, and a seamless shopping experience for your customers.</p>

                <div class="mockup-preview">
                    <div class="mockup-header">
                        <div class="m-dot"></div><div class="m-dot"></div><div class="m-dot"></div>
                    </div>
                    <div class="mockup-rows">
                        <div class="m-row" style="width: 40%; background: #f97316;"></div>
                        <div class="m-row" style="width: 80%;"></div>
                        <div class="m-row" style="width: 60%;"></div>
                        <div class="m-row" style="width: 90%;"></div>
                    </div>
                </div>
            </div>

            <div class="showcase-footer">
                <div class="trust-item">
                    <strong>10k+</strong>
                    <span>Stores Built</span>
                </div>
                <div class="trust-item">
                    <strong>$2M+</strong>
                    <span>Volume Processed</span>
                </div>
                <div class="trust-item">
                    <strong>24/7</strong>
                    <span>Expert Support</span>
                </div>
            </div>
        </section>

        <!-- Auth Form Panel -->
        <section class="auth-panel">
            <a href="{{ route('home') }}" class="back-to-site">
                Back to Site <i data-lucide="arrow-right"></i>
            </a>

            <div class="auth-form-container">
                @if ($errors->any())
                    <div class="flash-card error auto-hide" style="margin-bottom: 2rem; padding: 1.25rem; border-radius: 20px; background: #fff1f2; border: 1px solid #fecada; color: #9f1239; font-size: 0.95rem;">
                        <ul style="margin: 0; padding-left: 1.5rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('auth-body')
            </div>
        </section>
    </div>
    <script>
        // Password toggle functionality
        document.addEventListener('click', (e) => {
            if (e.target.closest('.password-toggle')) {
                const btn = e.target.closest('.password-toggle');
                const wrapper = btn.closest('.password-input-wrapper');
                const input = wrapper.querySelector('input');
                const icon = btn.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.setAttribute('data-lucide', 'eye-off');
                } else {
                    input.type = 'password';
                    icon.setAttribute('data-lucide', 'eye');
                }
                lucide.createIcons();
            }
        });
    </script>
@endsection
