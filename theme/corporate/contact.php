<?php
include_once('./_common.php');

if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가

// [Migration] 2026-01-07
// Redirect to the new Plugin URL structure for standardized management.
goto_url(G5_PLUGIN_URL . '/online_inquiry/?oi_id=corporate');
?>