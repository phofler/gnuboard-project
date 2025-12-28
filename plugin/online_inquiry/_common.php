<?php

// 1. 그누보드 최상위 common.php INCLUDE
// _common.php 파일 위치: plugin/online_inquiry/
if (!defined('_GNUBOARD_')) {
    include_once(dirname(__FILE__) . '/../../common.php');
}

// 2. 플러그인 필수 상수 정의
if (!defined('G5_PLUGIN_URL')) {
    define('G5_PLUGIN_URL', G5_URL . '/plugin');
}

// 플러그인 경로 상수
define('ONLINE_INQUIRY_PATH', G5_PLUGIN_PATH . '/online_inquiry');
define('ONLINE_INQUIRY_URL', G5_PLUGIN_URL . '/online_inquiry');

// 플러그인 전용 테이블명 정의 (독립형)
define('G5_PLUGIN_ONLINE_INQUIRY_TABLE', G5_TABLE_PREFIX . 'plugin_online_inquiry');
?>