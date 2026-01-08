<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * 사용자 입력 폼 로더 (form.php)
 * - 어디서든 include_once(G5_PLUGIN_PATH . '/online_inquiry/form.php'); 로 사용
 */

// 플러그인 공통 설정 로드
include_once(dirname(__FILE__) . '/_common.php');
include_once(G5_PATH . '/lib/theme_css.lib.php');

// 스킨 설정 (DB 기반)
$theme = isset($config['cf_theme']) ? $config['cf_theme'] : 'corporate'; // Default Theme
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'kr'; // Default Lang

$config_table = G5_TABLE_PREFIX . 'plugin_online_inquiry_config';
$skin_name = 'basic'; // Default fallback

// Fetch Skin Config
$page_subject = '';
$page_content = '';

$row = null;
if (defined('G5_TABLE_PREFIX')) {
    // 1. Try to find by specific oi_id from URL first
    $oi_id_req = isset($_GET['oi_id']) ? clean_xss_tags($_GET['oi_id']) : '';
    if ($oi_id_req) {
        $row = sql_fetch(" select * from {$config_table} where oi_id = '{$oi_id_req}' ");
    }

    // 2. If not found, try to derive from theme & lang
    if (!$row || !isset($row['oi_id'])) {
        $target_id = $theme . ($lang == 'kr' ? '' : '_' . $lang);
        $row = sql_fetch(" select * from {$config_table} where oi_id = '{$target_id}' ");
    }

    // 3. Fallback: try theme + lang columns
    if (!$row || !isset($row['oi_id'])) {
        $row = sql_fetch(" select * from {$config_table} where theme = '{$theme}' and lang = '{$lang}' order by reg_date desc limit 1 ");
    }

    // 4. Final fallback: any record for this theme
    if (!$row || !isset($row['oi_id'])) {
        $row = sql_fetch(" select * from {$config_table} where theme = '{$theme}' order by reg_date desc limit 1 ");
    }

    if ($row && isset($row['oi_id'])) {
        $skin_name = $row['skin'];
        $page_subject = $row['subject'];
        $page_content = $row['content'];
        $label_name = $row['label_name'] ? $row['label_name'] : 'Name';
        $label_phone = $row['label_phone'] ? $row['label_phone'] : 'Phone';
        $label_msg = $row['label_msg'] ? $row['label_msg'] : 'Message';
        $label_submit = $row['label_submit'] ? $row['label_submit'] : 'Submit';

        // [Standardization] Default to active theme background if empty
        $oi_bgcolor = (isset($row['oi_bgcolor']) && $row['oi_bgcolor']) ? $row['oi_bgcolor'] : get_theme_css_value($config['cf_theme'], array('--color-bg', '--color-bg-dark'), '#121212');
    } else {
        // Defaults if no config found
        $label_name = 'Name';
        $label_phone = 'Phone';
        $label_msg = 'Message';
        $label_submit = 'Submit';
        $oi_bgcolor = get_theme_css_value($config['cf_theme'], array('--color-bg', '--color-bg-dark'), '#121212');
    }
}

$skin_path = ONLINE_INQUIRY_PATH . '/skin/user/' . $skin_name;
$skin_url = ONLINE_INQUIRY_URL . '/skin/user/' . $skin_name;


// 스타일시트 추가
add_stylesheet('<link rel="stylesheet" href="' . $skin_url . '/style.css">', 0);

// [DEBUG] Variable Check
// echo "<div style='background:red; color:white; padding:10px; z-index:9999; position:relative;'>DEBUG: page_content length = " . strlen($page_content) . " / skin_name = " . $skin_name . "</div>";
// var_dump($row); 

// 스킨 파일 로드
if (file_exists($skin_path . '/write.skin.php')) {
    include_once($skin_path . '/write.skin.php');
} else {
    echo '<p>스킨 파일이 없습니다: ' . $skin_path . '</p>';
}
?>