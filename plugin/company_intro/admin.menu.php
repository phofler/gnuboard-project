<?php
if (!defined('_GNUBOARD_'))
    exit;

// 관리자 메뉴 등록
// $menu['menu300'] 배열에 추가합니다. (게시판 관리 섹션)
if (isset($menu['menu300'])) {

    // 메뉴 아이디 생성 (중복 방지, 300950 사용)
    $menu_id = '300950';

    // 메뉴 추가
    // array(메뉴ID, 메뉴명, 링크, 권한체크ID)
    $menu['menu300'][] = array(
        $menu_id,
        '회사소개 관리',
        G5_PLUGIN_URL . '/company_intro/adm/list.php',
        'company_intro'
    );
}
?>