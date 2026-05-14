<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SM-Shop | Professional Marketplace')</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@500;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        :root {
            --accent: #d97706;
            /* Caramel/Amber accent */
            --accent-deep: #b45309;
            --bg-primary: #fdfaf6;
            /* Off-white / light caramel */
            --bg-secondary: #f9f5ef;
            --surface: rgba(0, 0, 0, 0.03);
            --text-primary: #000000;
            /* Pure black as requested */
            --text-muted: rgba(0, 0, 0, 0.65);
            --border-color: rgba(0, 0, 0, 0.1);
            --danger: #dc2626;
            --success: #16a34a;
        }

        * {
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            background-color: var(--bg-primary);
            background-image:
                radial-gradient(circle at 85% 15%, rgba(249, 115, 22, 0.08), transparent 45%),
                radial-gradient(circle at 15% 85%, rgba(236, 72, 153, 0.05), transparent 40%),
                radial-gradient(circle at 50% 50%, rgba(253, 250, 246, 0.5), transparent 100%);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            overflow-x: hidden;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        #scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;
            height: 3px;
            width: 0;
            background: linear-gradient(90deg, #A78BFA, #7C3AED);
        }

        .flash-stack {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 5000;
            display: grid;
            gap: 0.75rem;
            width: min(360px, calc(100vw - 2rem));
        }

        .flash-card {
            padding: 0.95rem 1rem;
            border-radius: 18px;
            border: 1px solid var(--border-color);
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(18px);
        }

        .flash-card.success {
            border-color: rgba(74, 222, 128, 0.25);
        }

        .flash-card.error {
            border-color: rgba(248, 113, 113, 0.28);
        }

        .flash-card strong {
            display: block;
            margin-bottom: 0.2rem;
            font-size: 0.92rem;
        }

        .flash-card span {
            color: var(--text-muted);
            font-size: 0.88rem;
        }

        .flash-card.fade-out {
            opacity: 0;
            transform: translateX(20px);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div id="scroll-progress"></div>
    <x-star-field />

    @if (session('success') || session('error'))
        <div class="flash-stack">
            @if (session('success'))
                <div class="flash-card success">
                    <strong>Success</strong>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="flash-card error">
                    <strong>Something needs attention</strong>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
        </div>
    @endif

    @if ($errors->any())
        <div class="flash-stack" style="top: auto; bottom: 1rem;">
            <div class="flash-card error">
                <strong>Please review the submitted data</strong>
                <span>{{ collect($errors->all())->implode(' ') }}</span>
            </div>
        </div>
    @endif

    <div style="position: relative; z-index: 1;">
        @yield('content')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        lucide.createIcons();

        window.addEventListener('scroll', () => {
            const progress = document.getElementById('scroll-progress');

            if (!progress) {
                return;
            }

            const height = document.body.scrollHeight - window.innerHeight;
            const width = height > 0 ? (window.pageYOffset / height) * 100 : 0;
            progress.style.width = `${width}%`;
        });

        // Auto-hide flash messages after 10 seconds
        document.addEventListener('DOMContentLoaded', () => {
            const flashCards = document.querySelectorAll('.flash-card');
            flashCards.forEach(card => {
                setTimeout(() => {
                    card.classList.add('fade-out');
                    setTimeout(() => {
                        card.remove();
                    }, 600); // Remove from DOM after animation
                }, 10000); // 10 seconds
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
