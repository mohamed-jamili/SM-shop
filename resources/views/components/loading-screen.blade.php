<style>
    .home-loader {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.8s;
    }

    .home-loader.is-hidden {
        opacity: 0;
        visibility: hidden;
    }

    .loader-content {
        text-align: center;
        animation: loaderFadeUp 0.8s ease-out;
    }

    @keyframes loaderFadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .loader-logo {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .loader-logo i {
        width: 48px;
        height: 48px;
        color: #f97316;
        animation: pulseLogo 2s infinite;
    }

    @keyframes pulseLogo {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }

    .loader-brand {
        font-family: 'Outfit', sans-serif;
        font-size: 3rem;
        font-weight: 900;
        color: #0f172a;
        letter-spacing: -0.04em;
    }

    .loader-bar-container {
        width: 240px;
        height: 3px;
        background: #f1f5f9;
        border-radius: 10px;
        margin: 0 auto;
        overflow: hidden;
        position: relative;
    }

    .loader-bar-progress {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 0;
        background: #f97316;
        transition: width 1.5s cubic-bezier(0.65, 0, 0.35, 1);
        box-shadow: 0 0 15px rgba(249, 115, 22, 0.5);
    }
</style>

<div id="loading-screen" class="home-loader">
    <div class="loader-content">
        <div class="loader-logo">
            <i data-lucide="zap"></i>
            <h1 class="loader-brand">SM-SHOP</h1>
        </div>
        <div class="loader-bar-container">
            <div id="loader-bar" class="loader-bar-progress"></div>
        </div>
    </div>
</div>

<script>
    (() => {
        const screen = document.getElementById('loading-screen');
        const bar = document.getElementById('loader-bar');

        if (!screen) return;

        const hasSeenLoader = sessionStorage.getItem('sm_loader_seen') === '1';
        
        if (hasSeenLoader) {
            screen.style.display = 'none';
            return;
        }

        document.body.style.overflow = 'hidden';

        // Start progress
        setTimeout(() => {
            if (bar) bar.style.width = '100%';
        }, 100);

        window.addEventListener('load', () => {
            setTimeout(() => {
                screen.classList.add('is-hidden');
                document.body.style.overflow = '';
                sessionStorage.setItem('sm_loader_seen', '1');
                setTimeout(() => screen.remove(), 800);
            }, 1800);
        });
    })();
</script>
