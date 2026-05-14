document.addEventListener('DOMContentLoaded', () => {
    const revealElements = document.querySelectorAll('.reveal');

    if (revealElements.length && 'IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        revealElements.forEach((element) => revealObserver.observe(element));
    } else {
        revealElements.forEach((element) => element.classList.add('active'));
    }

    const floatingImages = document.querySelectorAll('.floating-img');
    floatingImages.forEach((image) => {
        image.addEventListener('mousemove', (event) => {
            const { offsetWidth: width, offsetHeight: height } = image;
            const { offsetX: x, offsetY: y } = event;
            const xRotation = -((y - height / 2) / height) * 12;
            const yRotation = ((x - width / 2) / width) * 12;
            image.style.transform = `perspective(900px) rotateX(${xRotation}deg) rotateY(${yRotation}deg) scale(1.03)`;
        });

        image.addEventListener('mouseleave', () => {
            image.style.transform = 'perspective(900px) rotateX(0deg) rotateY(0deg) scale(1)';
        });
    });
});
