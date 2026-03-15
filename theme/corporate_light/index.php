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

<!-- MAIN CONTENT SECTIONS (Manifesto, Services, etc.) -->
<?php
// Renders all active sections sorted by ms_sort
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