document.addEventListener('DOMContentLoaded', () => {
    // Fade In Animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('h1, h2, p, .btn-elegant, .product-card, .ingredient-item, form').forEach(el => {
        el.classList.add('fade-in');
        observer.observe(el);
    });

    // Form Validation
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const email = form.querySelector('input[type="email"]');
            if (email && !email.value.includes('@')) {
                alert('올바른 이메일 주소를 입력해주세요.');
                return;
            }
            alert('메시지가 성공적으로 전송되었습니다. 빠른 시일 내에 답변 드리겠습니다.');
            form.reset();
        });
    }
});
