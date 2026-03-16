<?php
include_once('../../common.php');
include_once(G5_LIB_PATH.'/premium_module.lib.php');

// [Input Validation]
$co_id = isset($_GET['co_id']) ? trim(clean_xss_tags($_GET['co_id'])) : '';

// [Plugin Table]
$plugin_table = G5_TABLE_PREFIX . 'plugin_company_add';

// [Premium Framework Loading] 
// This handles direct ID match AND Theme/Lang prefix fallback automatically
$co_row = get_premium_config($plugin_table, $co_id, 'co_id');

// [Core Headers] - Set Title BEFORE head.php
if (isset($co_row['co_subject']) && $co_row['co_subject']) {
    $g5['title'] = $co_row['co_subject'];
} else {
    $g5['title'] = "Company Intro";
}

include_once(G5_PATH . '/head.php');

// [Render View]
if (isset($co_row['co_id']) && $co_row['co_id']) {
    // Pass Data to View

    // Pass Data to View
    include(G5_PLUGIN_PATH . '/company_intro/view.php');
} else {
    // Error Handler
    echo '<div style="padding:100px 0; text-align:center;">';
    echo '<h3>콘텐츠를 찾을 수 없습니다. (Content Not Found)</h3>';
    echo '<p>요청하신 ID: <strong>' . $co_id . '</strong></p>';
    if ($is_admin) {
        echo '<p class="text-danger">관리자 모드: 플러그인 테이블에 해당 ID가 존재하지 않습니다.</p>';
    }
    echo '</div>';
}

include_once(G5_PATH . '/tail.php');
?>