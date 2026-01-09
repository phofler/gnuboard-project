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

<?php if (!defined('_INDEX_')) {
    $sd_layout = isset($sub_design['sd_layout']) ? $sub_design['sd_layout'] : 'full';
    if ($sd_layout == 'sidebar') { ?>
        </div> <!-- .sub-content -->
        </div> <!-- .sub-layout-body -->
    <?php } else { ?>
        </div> <!-- .sub-layout-width-height -->
    <?php }
} ?>
</div> <!-- #container -->
</div> <!-- #container_wr -->
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