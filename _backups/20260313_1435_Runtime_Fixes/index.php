<?php
if (!defined('_GNUBOARD_')) exit;
define('_INDEX_', true);
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

<section class="product-intro">
    <div class="container">
        <div class="section-title reveal slide-up">
            <h2>Product Introduction</h2>
            <p>성우첨단패널의 혁신적인 기술력을 소개합니다.</p>
        </div>

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
    </div>
</section>

<script>
    $(function() {
        // Scroll Animation (Intersection Observer)
        const observerOptions = { threshold: 0.1 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    });
</script>

<?php
include_once(G5_THEME_PATH.'/tail.php');
?>