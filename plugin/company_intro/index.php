<?php
include_once('../../common.php');

// [Core Headers]
$g5['title'] = "Company Intro";
include_once(G5_PATH . '/head.php');

// [Input Validation]
$co_id = isset($_GET['co_id']) ? clean_xss_tags($_GET['co_id']) : '';

// [Plugin Table]
$plugin_table = G5_TABLE_PREFIX . 'plugin_company_add';
$co_row = array();

if ($co_id) {
    // 1. Direct Match
    $co_row = sql_fetch(" select * from {$plugin_table} where co_id = '{$co_id}' ");

    if (!$co_row['co_id']) {
        // 2. Try adding current theme prefix (Auto-Resolve)
        // e.g. co_id='company' -> 'corporate_company'
        global $config;
        $current_theme = isset($config['cf_theme']) ? $config['cf_theme'] : 'corporate';
        $lang = isset($g5['lang']) ? $g5['lang'] : (isset($_GET['lang']) ? $_GET['lang'] : 'kr');

        $try_id = $current_theme . '_' . $lang . '_' . $co_id;
        $co_row = sql_fetch(" select * from {$plugin_table} where co_id = '{$try_id}' ");

        if (!$co_row['co_id']) {
            $try_id_simple = $current_theme . '_' . $co_id;
            $co_row = sql_fetch(" select * from {$plugin_table} where co_id = '{$try_id_simple}' ");
        }
    }
}

// [Render View]
if (isset($co_row['co_id']) && $co_row['co_id']) {
    // SEO Title Override
    $g5['title'] = $co_row['co_subject'];

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