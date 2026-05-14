<section class="feature-bar-section">
    <div class="feature-bar-container">
        <div class="feature-bar-card">
            <div class="f-bar-item">
                <div class="f-bar-icon orange-bg">
                    <i data-lucide="zap"></i>
                </div>
                <div class="f-bar-text">
                    <strong>Lightning Fast</strong>
                    <span>Setup your store in just a few minutes.</span>
                </div>
            </div>

            <div class="f-bar-divider"></div>

            <div class="f-bar-item">
                <div class="f-bar-icon green-bg">
                    <i data-lucide="shield-check"></i>
                </div>
                <div class="f-bar-text">
                    <strong>Secure & Reliable</strong>
                    <span>Enterprise-grade security to protect your business.</span>
                </div>
            </div>

            <div class="f-bar-divider"></div>

            <div class="f-bar-item">
                <div class="f-bar-icon purple-bg">
                    <i data-lucide="bar-chart-3"></i>
                </div>
                <div class="f-bar-text">
                    <strong>Scale Effortlessly</strong>
                    <span>Powerful tools to grow your business.</span>
                </div>
            </div>

            <div class="f-bar-divider"></div>

            <div class="f-bar-item">
                <div class="f-bar-icon yellow-bg">
                    <i data-lucide="layout-grid"></i>
                </div>
                <div class="f-bar-text">
                    <strong>Everything You Need</strong>
                    <span>All-in-one platform for modern entrepreneurs.</span>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .feature-bar-section {
        padding: 2rem 2rem 6rem;
        background: transparent;
    }

    .feature-bar-container {
        max-width: 1440px;
        margin: 0 auto;
        padding: 0 4rem;
    }

    .feature-bar-card {
        background: #fff;
        border-radius: 28px;
        border: 1px solid rgba(0, 0, 0, 0.04);
        padding: 2.2rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.04);
    }

    .f-bar-item {
        display: flex;
        align-items: center;
        gap: 1.4rem;
        flex: 1;
        padding: 0 2rem;
    }

    .f-bar-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .f-bar-icon i {
        width: 26px;
        height: 26px;
    }

    .orange-bg {
        background: #fff7ed;
        color: #f97316;
    }

    .green-bg {
        background: #f0fdf4;
        color: #10b981;
    }

    .purple-bg {
        background: #f5f3ff;
        color: #8b5cf6;
    }

    .yellow-bg {
        background: #fffbeb;
        color: #f59e0b;
    }

    .f-bar-text strong {
        display: block;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 1.15rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 0.25rem;
        letter-spacing: -0.02em;
    }

    .f-bar-text span {
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        color: #64748b;
        font-weight: 500;
        letter-spacing: -0.01em;
        line-height: 1.4;
    }

    .f-bar-divider {
        width: 1px;
        height: 50px;
        background: #f1f5f9;
    }

    @media (max-width: 1100px) {
        .feature-bar-card {
            flex-direction: column;
            gap: 2rem;
            padding: 3rem 2rem;
        }

        .f-bar-divider {
            display: none;
        }

        .f-bar-item {
            width: 100%;
            justify-content: center;
            text-align: center;
            flex-direction: column;
        }
    }
</style>