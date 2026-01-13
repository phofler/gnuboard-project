<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * Company Intro View File
 * 
 * $co_row 변수에 이미 데이터가 담겨져 있다고 가정 (route.php에서 조회함)
 * 만약 직접 접근했다면 다시 조회해야 함.
 */

if (!isset($co_row) || empty($co_row)) {
    alert('잘못된 접근입니다.');
}

// [Standardized Logic]
include_once(G5_PLUGIN_PATH . '/company_intro/skin.head.php');

$g5['title'] = $co_row['co_subject'];

// 헤더 포함
include_once(G5_PATH . '/_head.php');

if (file_exists($skin_file)) {
    // [FIX] Wrapperless Output (Theme Sovereignty)
    // Only wrap if a specific background color is set and differs from 'transparent'
    if ($bg_color && $bg_color != 'transparent' && $bg_color != 'var(--color-bg)') {
        echo '<div style="background-color:' . $bg_color . ';">';
        echo get_view_thumbnail($view_content);
        echo '</div>';
    } else {
        // Direct Output (No Wrapper)
        echo get_view_thumbnail($view_content);
    }
} else {
    echo '<div id="sub_container" class="sub-wrapper">';
    echo $view_content;
    echo '</div>';
}
?>


<?php
// 테일 포함
include_once(G5_PATH . '/_tail.php');
?>