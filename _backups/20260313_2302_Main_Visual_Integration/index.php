<?php
if (!defined('_GNUBOARD_')) exit;
if (!defined('_INDEX_')) define('_INDEX_', true);
include_once(G5_THEME_PATH.'/head.php');
?>

<div class="main-slider">
    <div class="slide active">
        <div class="slide-bg" style="background-image: url('<?php echo G5_THEME_URL ?>/Gemini_Generated_Image_h8tejph8tejph8te.jpg');"></div>
        <div class="slide-content">
            <h2>BUILD THE FUTURE</h2>
            <p>공간의 가치를 높이는 최고의 첨단 패널 솔루션</p>
            <div class="btn-wrap">
                <a href="#" class="btn-slider-cta">제품보기</a>
            </div>
        </div>
    </div>
</div>

<!-- 1. 제품소개 (슬라이드 애니메이션) -->
<section class="product-intro">
    <div class="container">
        <div class="section-title reveal slide-up">
            <h2>Product Introduction</h2>
            <p>성우첨단패널의 혁신적인 기술력을 소개합니다.</p>
        </div>

        <!-- Glasswool -->
        <div class="product-row">
            <div class="product-text reveal slide-left">
                <h3>그라스울 패널</h3>
                <p>우수한 불연 성능과 탁월한 단열 효과</p>
                <p>내구성과 압축강도, 내부식성이 우수</p>
                <a href="#" style="display:inline-block; margin-top:20px; color:var(--edge-color); font-weight:700;">자세히 보기 <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="product-img reveal slide-right">
                <img src="<?php echo G5_THEME_URL ?>/glasswool_p.png" alt="그라스울 패널">
                <div class="img-overlay-text">
                    <span class="en">GLASSWOOL PANEL</span>
                    <span class="ko">그라스울패널</span>
                </div>
            </div>
        </div>

        <!-- EPS -->
        <div class="product-row reverse">
            <div class="product-text reveal slide-right">
                <h3>EPS 패널</h3>
                <p>우수한 단열 효과로 건물의 유지 관리비를</p>
                <p>절감할 수 있는 가장 경제적인 건축자재</p>
                <a href="#" style="display:inline-block; margin-top:20px; color:var(--edge-color); font-weight:700;">자세히 보기 <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="product-img reveal slide-left">
                <img src="<?php echo G5_THEME_URL ?>/eps_p.png" alt="EPS 패널">
                <div class="img-overlay-text">
                    <span class="en">EPS PANEL</span>
                    <span class="ko">EPS패널</span>
                </div>
            </div>
        </div>

        <!-- Steel -->
        <div class="product-row">
            <div class="product-text reveal slide-left">
                <h3>강판</h3>
                <p>형태와 색상, 무늬 등 다양한 적용이 가능하며</p>
                <p>가볍고 시공이 매우 간편함</p>
                <a href="#" style="display:inline-block; margin-top:20px; color:var(--edge-color); font-weight:700;">자세히 보기 <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="product-img reveal slide-right">
                <img src="https://images.unsplash.com/photo-1621905252507-b35482cd8d11?auto=format&fit=crop&q=80&w=800" alt="강판">
                <div class="img-overlay-text">
                    <span class="en">STEEL PANEL</span>
                    <span class="ko">강판</span>
                </div>
            </div>
        </div>

        <!-- Accessories -->
        <div class="product-row reverse">
            <div class="product-text reveal slide-right">
                <h3>부자재</h3>
                <p>패널 시스템 연결 부자재 및</p>
                <p>샤시, 도어 등 건축에 필요한 부자재</p>
                <a href="#" style="display:inline-block; margin-top:20px; color:var(--edge-color); font-weight:700;">자세히 보기 <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="product-img reveal slide-left">
                <img src="https://images.unsplash.com/photo-1503387762-592eef89d126?auto=format&fit=crop&q=80&w=800" alt="부자재">
                <div class="img-overlay-text">
                    <span class="en">ACCESSORIES</span>
                    <span class="ko">부자재</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 2. 주요제품소개 (동적 연동: product 게시판) -->
<section class="main-items">
    <div class="container">
        <div class="section-title reveal slide-up">
            <h2>Best Products</h2>
            <p>고객이 가장 많이 찾는 성우의 베스트셀러</p>
        </div>
        <?php echo latest('theme/kukdong_best', 'product', 4, 30); ?>
    </div>
</section>

<!-- 4. 고객센터 / 상담신청 / 공지사항 (동적 연동: news 게시판) -->
<section class="bottom-links">
    <div class="container">
        <div class="links-grid">
            <a href="#" class="link-box reveal slide-up" style="transition-delay: 0.1s;">
                <h4>고객센터</h4>
                <p>1551-9123</p>
                <p>평일 09:00 ~ 18:00</p>
            </a>
            <a href="/contact_us/online.php" class="link-box reveal slide-up" style="transition-delay: 0.2s;">
                <h4>상담신청</h4>
                <p>전문 상담사가 친절하게</p>
                <p>안내해 드리겠습니다.</p>
            </a>
            <?php echo latest('theme/kukdong_notice', 'news', 1, 30); ?>
        </div>
    </div>
</section>

<script>
    $(function() {
        const observerOptions = { threshold: 0.1 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        let cur = 0;
        const slides = $('.slide');
        if (slides.length > 1) {
            setInterval(() => {
                slides.eq(cur).removeClass('active');
                cur = (cur + 1) % slides.length;
                slides.eq(cur).addClass('active');
            }, 8000);
        }
    });
</script>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>