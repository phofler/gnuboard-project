<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * 사용자 입력 폼 로더 (form.php)
 * - 어디서든 include_once(G5_PLUGIN_PATH . '/online_inquiry/form.php'); 로 사용
 */

// 플러그인 공통 설정 로드
include_once(dirname(__FILE__) . '/_common.php');

// 스킨 설정 (config.php 로드)
$config_file = dirname(__FILE__) . '/config.php';
$skin_name = 'basic'; // Default fallback

if (file_exists($config_file)) {
    include($config_file);
    if (isset($online_inquiry_conf['skin'])) {
        $skin_name = $online_inquiry_conf['skin'];
    }
}

// 개별 페이지에서 변수로 덮어쓰기 허용 ($online_inquiry_skin)
if (isset($online_inquiry_skin) && $online_inquiry_skin) {
    $skin_name = $online_inquiry_skin;
}

$skin_path = ONLINE_INQUIRY_PATH . '/skin/user/' . $skin_name;
$skin_url = ONLINE_INQUIRY_URL . '/skin/user/' . $skin_name;

// 스타일시트 추가
add_stylesheet('<link rel="stylesheet" href="' . $skin_url . '/style.css">', 0);

// 스킨 파일 로드
if (file_exists($skin_path . '/write.skin.php')) {
    include_once($skin_path . '/write.skin.php');
} else {
    echo '<p>스킨 파일이 없습니다: ' . $skin_path . '</p>';
}
?>