document.addEventListener('DOMContentLoaded', function () {
    // Mobile Menu Toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const navMenu = document.querySelector('.nav-menu');
    const dropdowns = document.querySelectorAll('.dropdown');

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function () {
            navMenu.classList.toggle('active');
            const icon = navMenu.classList.contains('active') ? '✕' : '☰';
            mobileMenuBtn.textContent = icon;
        });
    }

    // Mobile Dropdown Toggle
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('click', function (e) {
            if (window.innerWidth <= 768) {
                // e.preventDefault();
                this.classList.toggle('active');
            }
        });
    });

    // Sticky Header Effect
    const header = document.querySelector('header');
    window.addEventListener('scroll', function () {
        if (window.scrollY > 50) {
            header.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
            header.style.padding = '10px 0';
        } else {
            header.style.boxShadow = 'none';
            header.style.padding = '20px 0';
        }
    });

    // Fade In on Scroll
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    const sections = document.querySelectorAll('section');
    sections.forEach(section => {
        section.classList.add('fade-in-section');
        observer.observe(section);
    });

    // Smooth Scrolling
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                // Close mobile menu if open
                if (navMenu.classList.contains('active')) {
                    navMenu.classList.remove('active');
                    mobileMenuBtn.textContent = '☰';
                }

                window.scrollTo({
                    top: targetElement.offsetTop - 80, // Offset for header
                    behavior: 'smooth'
                });
            }
        });
    });

    // Contact Form Validation
    const contactForm = document.querySelector('.contact-form form');
    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();
            let isValid = true;

            const name = this.querySelector('input[name="name"]');
            const email = this.querySelector('input[name="email"]');
            const message = this.querySelector('textarea[name="message"]');

            // Simple Validation
            if (!name.value.trim()) {
                alert('Please enter your name.');
                isValid = false;
            } else if (!email.value.trim() || !email.value.includes('@')) {
                alert('Please enter a valid email address.');
                isValid = false;
            } else if (!message.value.trim()) {
                alert('Please enter your message.');
                isValid = false;
            }

            if (isValid) {
                alert('Thank you for your message. We will get back to you shortly.');
                this.reset();
            }
        });
    }
});
