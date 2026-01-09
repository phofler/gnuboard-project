<?php
if (!defined('_INDEX_'))
    define('_INDEX_', true);
if (!defined('_GNUBOARD_'))
    exit;

if (G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH . '/index.php');
    return;
}

include_once(G5_THEME_PATH . '/head.php');
include_once(G5_PLUGIN_PATH . '/main_image_manager/lib/main.lib.php');
include_once(G5_PLUGIN_PATH . '/main_content_manager/lib/main_content.lib.php');
?>

<!-- HERO SECTION (Digital Obsession) -->
<?php
// [TODO] Create 'ultimate_hero' skin for main_image_manager
// For now, defaulting to standard display function which needs skin selection in Admin
if (function_exists('display_main_visual')) {
    display_main_visual();
}
?>

<!-- MANIFESTO SECTION (Our Philosophy) -->
<!-- This is static content for now, can be moved to a text plugin later -->
<section class="container sec-manifesto" data-aos="fade-up" style="padding: 15vh 4vw;">
    <div class="u-grid-2" style="display:grid; grid-template-columns: 1fr 1fr; gap:4vw;">
        <div>
            <div
                style="font-size:14px; font-weight:800; margin-bottom:20px; color:var(--color-accent-gold); margin-left:20px;">
                [ OUR PHILOSOPHY ]
            </div>
        </div>
        <div class="manifesto-text"
            style="font-family:'Noto Sans KR', sans-serif; font-size:clamp(24px, 3vw, 32px); line-height:1.8; font-weight:600; word-break:keep-all;">
            완벽함이란 더 이상 더할 것이 없을 때가 아니라, <span style="color:var(--color-accent-gold)">더 이상 뺄 것이 없을 때</span> 완성됩니다. 우리는
            끊임없이 변화하는 디지털의 흐름 속에서도 변하지 않는 본질적 가치를
            탐구합니다. 복잡함을 걷어내고 브랜드의 핵심만을 명료하게 드러냄으로써, 사용자들의 마음속 깊은 곳에 잊혀지지 않는 강력한 울림과 감각적인 경험을 선사하는 당신만의 고유한 이야기를 완성해
            나갑니다.
        </div>
    </div>
</section>

<!-- SERVICES SECTION (What We Do) -->
<?php
// [TODO] Create 'list_modern' skin for main_content_manager
if (function_exists('display_main_content')) {
    display_main_content();
}
?>

<!-- SELECTED WORKS (Latest Skin Manager) -->
<?php
// Integrated Latest Skin Manager (Selected Works)
include_once(G5_PLUGIN_PATH . '/latest_skin_manager/lib/latest_skin.lib.php');

if (function_exists('latest_widget')) {
    // ID: 4 (Selected Works) identified via debugging
    latest_widget('4');
}
?>

<style>
    @keyframes slide {
        to {
            transform: translateX(-50%);
        }
    }

    .work-card:hover img {
        filter: grayscale(0%) !important;
    }
</style>

<?php
include_once(G5_THEME_PATH . '/tail.php');
?>