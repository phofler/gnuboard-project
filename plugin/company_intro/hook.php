<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * 플러그인 훅 파일 (hook.php)
 * - 이 파일이 로드될 때 설치가 안 되어 있으면 설치 스크립트를 실행합니다.
 */

// 1. 자동 설치 체크
$install_chk_file = G5_DATA_PATH . '/company_intro_installed.php';
if (!file_exists($install_chk_file)) {
    // 설치 파일 로드 및 실행
    include(G5_PLUGIN_PATH . '/company_intro/install.php');

    // 설치 완료 플래그 생성
    $fp = fopen($install_chk_file, 'w');
    fwrite($fp, '<?php // Company Intro Installed ?>');
    fclose($fp);
}

// 2. 관리자 메뉴 등록 훅 (제거됨)
// admin.menu800_theme.php 에서 통합 관리하므로 여기서는 등록하지 않습니다.
// add_replace('admin_menu', 'company_intro_admin_menu_hook');

/*
function company_intro_admin_menu_hook($menu)
{
    // 게시판관리(menu300) 제일 뒤에 추가
    $menu['menu300'][] = array(
        '300950',
        '회사소개 관리',
        G5_PLUGIN_URL . '/company_intro/adm/list.php',
        'company_intro'
    );

    return $menu;
}
*/
?>