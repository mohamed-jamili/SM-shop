<canvas id="starfield-canvas" class="home-starfield" aria-hidden="true"
    style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 0;"></canvas>

<style>
    .home-starfield {
        background: transparent;
    }
</style>

<script>
    (() => {
        const canvas = document.getElementById('starfield-canvas');
        if (!canvas || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            return;
        }

        const ctx = canvas.getContext('2d');
        const stars = [];
        let animationFrameId = null;
        let width = 0;
        let height = 0;
        let starCount = 0;

        const colors = [
            [249, 115, 22], // Bright Orange
            [251, 146, 60], // Light Orange
            [217, 119, 6],  // Caramel
        ];

        const createStar = () => {
            const [r, g, b] = colors[Math.floor(Math.random() * colors.length)];

            return {
                x: Math.random() * width,
                y: Math.random() * height,
                size: Math.random() * 1.8 + 0.5,
                speedX: (Math.random() - 0.5) * 0.12,
                speedY: (Math.random() - 0.5) * 0.12,
                opacity: Math.random() * 0.6 + 0.3,
                alphaShift: Math.random() * 0.012 + 0.003,
                direction: Math.random() > 0.5 ? 1 : -1,
                color: [r, g, b],
            };
        };

        const resize = () => {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
            starCount = Math.min(450, Math.max(150, Math.floor((width * height) / 6000)));
            stars.length = 0;

            for (let index = 0; index < starCount; index += 1) {
                stars.push(createStar());
            }
        };

        const draw = () => {
            ctx.clearRect(0, 0, width, height);

            for (const star of stars) {
                star.x += star.speedX;
                star.y += star.speedY;
                star.opacity += star.alphaShift * star.direction;

                if (star.opacity > 0.85 || star.opacity < 0.18) {
                    star.direction *= -1;
                }

                if (star.x < -2) star.x = width + 2;
                if (star.x > width + 2) star.x = -2;
                if (star.y < -2) star.y = height + 2;
                if (star.y > height + 2) star.y = -2;

                const [r, g, b] = star.color;
                ctx.beginPath();
                ctx.fillStyle = `rgba(${r}, ${g}, ${b}, ${star.opacity})`;
                ctx.arc(star.x, star.y, star.size, 0, Math.PI * 2);
                ctx.fill();

                if (star.opacity > 0.55) {
                    ctx.beginPath();
                    ctx.fillStyle = `rgba(${r}, ${g}, ${b}, ${star.opacity * 0.12})`;
                    ctx.arc(star.x, star.y, star.size * 2.4, 0, Math.PI * 2);
                    ctx.fill();
                }
            }

            animationFrameId = window.requestAnimationFrame(draw);
        };

        const handleVisibility = () => {
            if (document.hidden && animationFrameId) {
                window.cancelAnimationFrame(animationFrameId);
                animationFrameId = null;
            } else if (!document.hidden && !animationFrameId) {
                draw();
            }
        };

        resize();
        draw();

        window.addEventListener('resize', resize);
        document.addEventListener('visibilitychange', handleVisibility);
    })();
</script>