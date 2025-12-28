<?php
include_once('./_common.php');

if (!defined('G5_THEME_PATH')) {
    alert('테마가 설정되어 있지 않습니다.');
}

// Load contact.php from the CURRENTLY ACTIVE theme
$theme_contact_file = G5_THEME_PATH . '/contact.php';

if (file_exists($theme_contact_file)) {
    include_once($theme_contact_file);
} else {
    // Fallback if theme doesn't have contact.php
    alert('현재 테마에 contact.php 파일이 없습니다.');
}
?>