<?php
$sub_menu = "300900";
include_once('./_common.php');

if (!defined('G5_THEME_PATH')) {
    die('테마가 설정되지 않았거나 G5_THEME_PATH 상수가 없습니다.');
}

// 테마 내의 스킨 파일이 존재하면 로드
$inquiry_skin_file = G5_THEME_PATH . '/skin/adm/inquiry_list.php';
if (file_exists($inquiry_skin_file)) {
    include_once($inquiry_skin_file);
} else {
    alert('테마 내에 관리자 스킨 파일이 없습니다.\\n' . $inquiry_skin_file);
}
?>