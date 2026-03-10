document.addEventListener('DOMContentLoaded', function () {
    // Header Scroll Effect
    const header = document.querySelector('header');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Intersection Observer for Animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');

                // Animate child elements if they exist
                const animatedChildren = entry.target.querySelectorAll('.animate-child');
                animatedChildren.forEach((child, index) => {
                    setTimeout(() => {
                        child.style.opacity = '1';
                        child.style.transform = 'translateY(0)';
                    }, index * 100);
                });

                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const sections = document.querySelectorAll('section');
    sections.forEach(section => {
        observer.observe(section);
    });

    // Add simple fade-in class for JS usage
    const styleSheet = document.createElement("style");
    styleSheet.innerText = `
        .animate-child {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.19, 1, 0.22, 1);
        }
    `;
    document.head.appendChild(styleSheet);


    // Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                window.scrollTo({
                    top: target.offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Form Submission Alert
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            alert('쇼케이스 신청이 완료되었습니다. 담당자가 곧 연락드리겠습니다.');
            form.reset();
        });
    }
});
