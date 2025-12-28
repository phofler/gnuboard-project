<?php
if (!defined('_INDEX_'))
    define('_INDEX_', true);
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가

// if (G5_IS_MOBILE) {
//     include_once(G5_THEME_MOBILE_PATH . '/index.php');
//     return;
// }

if (G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH . '/index.php');
    return;
}

include_once(G5_THEME_PATH . '/head.php');
include_once(G5_PLUGIN_PATH . '/main_image_manager/lib/main.lib.php');
include_once(G5_PLUGIN_PATH . '/copyright_manager/lib.php');
$cp_config = function_exists('get_copyright_config') ? get_copyright_config() : array();
?>

<!-- Hero Section (Split Slider) -->
<?php
if (function_exists('display_main_visual')) {
    display_main_visual();
}
?>

<!-- Product Introduction Section -->
<?php
include_once(G5_PLUGIN_PATH . '/main_content_manager/lib/main_content.lib.php');
if (function_exists('display_main_content')) {
    display_main_content();
} else {
    ?>
    <section class="sec-product" id="product">
        <div class="container">
            <h2 data-aos="fade-up">Product Collection</h2>
            <div class="product-list">
                <!-- Item 1 -->
                <div class="product-item" data-aos="fade-right">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1595846519845-68e298c2edd8?auto=format&fit=crop&q=80"
                            alt="Grand Gates">
                    </div>
                    <div class="product-info">
                        <h3>대문 (Main Gates)</h3>
                        <p>집의 첫인상을 결정하는 품격 있는 디자인. 장인의 손길로 완성된 르네상스의 대문은 견고함과 아름다움을 동시에 선사합니다.</p>
                        <a href="<?php echo G5_URL ?>/product/product01.php" class="btn-luxury">VIEW DETAIL</a>
                    </div>
                </div>
                <!-- Item 2 -->
                <div class="product-item" data-aos="fade-left">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1533090161767-e6ffed986c88?auto=format&fit=crop&q=80"
                            alt="Auto Gates">
                    </div>
                    <div class="product-info">
                        <h3>자동대문 (Automatic Gates)</h3>
                        <p>편리함과 보안을 위한 최첨단 자동화 시스템. 부드러운 구동과 안전한 제어 기능을 갖춘 스마트한 선택입니다.</p>
                        <a href="<?php echo G5_URL ?>/product/product02.php" class="btn-luxury">VIEW DETAIL</a>
                    </div>
                </div>
                <!-- Item 3 -->
                <div class="product-item" data-aos="fade-right">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&q=80"
                            alt="Overhead Door">
                    </div>
                    <div class="product-info">
                        <h3>오버헤드도어 (Overhead Door)</h3>
                        <p>공간 활용을 극대화하는 세련된 차고 문. 단열성과 내구성이 뛰어난 프리미엄 패널을 적용했습니다.</p>
                        <a href="<?php echo G5_URL ?>/product/product03.php" class="btn-luxury">VIEW DETAIL</a>
                    </div>
                </div>
                <!-- Item 4 -->
                <div class="product-item" data-aos="fade-left">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1481277542470-605612bd2d61?auto=format&fit=crop&q=80"
                            alt="Entrance Door">
                    </div>
                    <div class="product-info">
                        <h3>현관문 (Entrance Door)</h3>
                        <p>안전과 방범은 기본, 예술적인 디자인으로 완성된 현관문은 당신의 품격을 높여드립니다.</p>
                        <a href="<?php echo G5_URL ?>/product/product04.php" class="btn-luxury">VIEW DETAIL</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<!-- Portfolio Section -->
<section class="sec-portfolio" id="portfolio">
    <div class="container">
        <h2 data-aos="fade-up">Construction Case</h2>
        <?php
        // 최신글 스킨: portfolio (Construction Case)
        // latest('스킨명', '게시판ID', 출력개수, 제목길이);
        echo latest('theme/portfolio', 'chamcode_gallery', 4, 30);
        ?>
    </div>
</section>

<!-- Online Inquiry Section -->
<section class="sec-inquiry" id="inquiry">
    <div class="container">
        <h2 data-aos="fade-up">Online Inquiry</h2>
        <div class="inquiry-wrapper" data-aos="fade-up">
            <div class="inquiry-info">
                <h3>Contact Us</h3>
                <p style="margin-bottom: 20px; color: #888;">궁금하신 사항을 남겨주시면 친절하게 상담해 드립니다.</p>
                <p><strong><?php echo $cp_config['tel_label'] ? $cp_config['tel_label'] : 'TEL'; ?>:</strong>
                    <?php echo $cp_config['tel_val']; ?></p>
                <p><strong><?php echo $cp_config['fax_label'] ? $cp_config['fax_label'] : 'FAX'; ?>:</strong>
                    <?php echo $cp_config['fax_val']; ?></p>
                <p><strong><?php echo $cp_config['email_label'] ? $cp_config['email_label'] : 'EMAIL'; ?>:</strong>
                    <?php echo $cp_config['email_val']; ?></p>
            </div>
            <div class="inquiry-form">
                <?php
                $online_inquiry_skin = 'corporate'; // 테마 전용 스킨 사용
                include_once(G5_PLUGIN_PATH . '/online_inquiry/form.php');
                ?>
            </div>
        </div>
    </div>
</section>

<!-- News Section -->
<section class="sec-news" id="news">
    <div class="container">
        <h2 data-aos="fade-up">News & Notice</h2>
        <div class="news-grid" data-aos="fade-up">
            <?php
            // latest('스킨명', '게시판ID', 출력개수, 제목길이, '옵션=me_code')
            echo latest('theme/main_news', 'news', 5, 30, '5010');
            echo latest('theme/main_news', 'dataroom', 5, 30, '5020');
            ?>
        </div>
    </div>
</section>

<!-- Company Overview -->
<section class="sec-company" id="company">
    <div class="company-overlay"></div>
    <div class="company-content" data-aos="fade-up">
        <h2>About Renaissance</h2>
        <p>
            (주)르네상스 환경디자인산업은 1978년에 설립 되었으며,<br>
            창조성, 정확성, 높은 수준의 품질과 마무리는 르네상스 환경디자인산업의 가장 중요한 사업 목표입니다.
        </p>
        <p>
            저희는 차별화된 특수자동게이트, 현관문, 오버헤드도어, 특수 계단구조물,<br>
            돌음 계단, 알루미늄 주물 휀스, 단조난간, 화분대, 방범창 등<br>
            특화된 금속 구조물을 전문적으로 생산합니다.
        </p>
        <p>
            알루미늄주물 성형, 단조 금속 성형, 특수알곤용접 제작, 레이져 가공,<br>
            쇼트 블라스트 표면처리, 분체 도장, 불소 도장, 2액형, 우레탄도장, 소부도장까지<br>
            4,950 m² 공장부지에 전문적인 직접 생산 라인 설비를 갖추고 있습니다.
        </p>
        <a href="<?php echo G5_BBS_URL; ?>/content.php?co_id=company&me_code=1010" class="btn-luxury">COMPANY
            PROFILE</a>
    </div>
</section>

<!-- Location Section -->
<section class="sec-location" id="location">
    <div class="container">
        <h2 data-aos="fade-up">Location</h2>
        <div class="location-info" data-aos="fade-up">
            <p><strong><?php echo $cp_config['addr_label'] ? $cp_config['addr_label'] : 'Address'; ?>:</strong>
                <?php echo $cp_config['addr_val']; ?></p>
            <p>
                <strong><?php echo $cp_config['tel_label'] ? $cp_config['tel_label'] : 'Tel'; ?> :</strong>
                <?php echo $cp_config['tel_val']; ?>
                &nbsp;/&nbsp;
                <strong><?php echo $cp_config['fax_label'] ? $cp_config['fax_label'] : 'Fax'; ?> :</strong>
                <?php echo $cp_config['fax_val']; ?>
            </p>
        </div>
    </div>
    <!-- Map Placeholer -->
    <div class="map-container">
        <!-- Map API Plugin -->
        <?php
        if (function_exists('display_map_api')) {
            echo display_map_api('100%', '450px');
        } else {
            echo '<div style="padding:100px; text-align:center; background:#eee;">지도 API 플러그인이 활성화되지 않았습니다.</div>';
        }
        ?>
    </div>
</section>

<!-- Initialize Swiper -->
<!-- Swiper Library is now loaded globally in head.sub.php -->
<!-- Style-specific Swiper initialization is now handled dynamically within display_main_visual() -->
<?php
include_once(G5_THEME_PATH . '/tail.php');
?>