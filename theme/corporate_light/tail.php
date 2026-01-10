<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가

// if (G5_IS_MOBILE) {
//     include_once(G5_THEME_MOBILE_PATH . '/tail.php');
//     return;
// }

if (G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH . '/shop.tail.php');
    return;
}
?>

<?php if (!defined('_NO_CONTAINER_')) { ?>
    <?php if (!defined('_INDEX_')) {
        // Determine Layout (Sidebar vs. Full)
        $sd_layout = isset($sub_design['sd_layout']) ? $sub_design['sd_layout'] : 'full';

        if ($sd_layout == 'sidebar') {
            echo '</main> <!-- .sub-content -->' . PHP_EOL;
            echo '</div> <!-- .sub-layout-body -->' . PHP_EOL;
        } else {
            echo '</div> <!-- .sub-layout-full -->' . PHP_EOL;
        }
    } ?>
    </div> <!-- #container -->
    </div> <!-- #container_wr -->
<?php } // End !defined('_NO_CONTAINER_') ?>
</div> <!-- #wrapper -->

<?php
// [NEW] Copyright Manager Integration (Footer Skins)
if (defined('G5_PLUGIN_PATH') && file_exists(G5_PLUGIN_PATH . '/copyright_manager/lib.php')) {
    include_once(G5_PLUGIN_PATH . '/copyright_manager/lib.php');
    if (function_exists('display_footer_info')) {
        display_footer_info();
    }
}

?>

<?php
include_once(G5_THEME_PATH . "/tail.sub.php");
?>