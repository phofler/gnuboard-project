<?php
if (!defined('_GNUBOARD_')) exit;
if (!defined('_INDEX_')) define('_INDEX_', true);

// [Dynamic Integration] Libraries
include_once(G5_PLUGIN_PATH . '/main_image_manager/lib/main.lib.php');
include_once(G5_PLUGIN_PATH . '/main_content_manager/lib/main_content.lib.php');
include_once(G5_PLUGIN_PATH . '/latest_skin_manager/lib/latest_skin.lib.php');

// Language Detection
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'kr';
if (!defined('G5_LANG')) define('G5_LANG', $lang);

// Visual ID Construction (kukdong_panel / kukdong_panel_en etc.)
$visual_id = $config['cf_theme'];
if (G5_LANG != 'kr') {
    $visual_id .= '_' . G5_LANG;
}

include_once(G5_THEME_PATH.'/head.php');
?>

<?php
// Display Dynamic Main Visual with Premium Hero Options
if (function_exists('display_hero_visual')) {
    display_hero_visual($visual_id, array(
        'height' => '100vh',
        'full_width' => true
    ));
} else if (function_exists('display_main_visual')) {
    display_main_visual($visual_id);
} else {
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
<?php } ?>

<?php
// [DYNAMIC INTEGRATION] Main Content Manager
if (function_exists('display_main_content')) {
    display_main_content(G5_LANG);
} else {
?>
<!-- 1. 제품소개 (Fallback - Static Version) -->
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
                <a href="#" style="display:inline-block; margin-top:20px; color:var(--edge-color); font-weight:700;">자세히 보기 <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="product-img reveal slide-right">
                <img src="<?php echo G5_THEME_URL ?>/glasswool_p.png" alt="그라스울 패널">
            </div>
        </div>
    </div>
</section>
<?php } ?>

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
            <?php latest_widget(5); ?>
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