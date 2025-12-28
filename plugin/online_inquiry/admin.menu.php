<?php
if (!defined('_GNUBOARD_'))
    exit;

// 관리자 메뉴 등록
// $menu['menu300'] 배열에 추가합니다. (게시판 관리 섹션)
if (isset($menu['menu300'])) {

    // 메뉴 아이디 생성 (중복 방지)
    $menu_id = '300910';

    // 메뉴 추가
    // array(메뉴ID, 메뉴명, 링크, 권한체크ID)
    $menu['menu300'][] = array(
        $menu_id,
        '온라인 문의 관리',
        G5_PLUGIN_URL . '/online_inquiry/adm/list.php',
        'online_inquiry'
    );
}
?>