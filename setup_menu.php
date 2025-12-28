<?php
include_once('./_common.php');

if (!$is_admin)
    alert('관리자만 접근 가능합니다.');

function add_menu($code, $name, $link, $target = '')
{
    global $g5;
    // 기존 메뉴 확인
    $row = sql_fetch(" select count(*) as cnt from {$g5['menu_table']} where me_code = '$code' ");
    if ($row['cnt']) {
        // 있으면 업데이트 (이름만)
        sql_query(" update {$g5['menu_table']} set me_name = '$name', me_link = '$link' where me_code = '$code' ");
    } else {
        // 없으면 삽입
        sql_query(" insert into {$g5['menu_table']} set me_code = '$code', me_name = '$name', me_link = '$link', me_target = '$target', me_use = 1 ");
    }
}

// 1. 회사소개 (me_code: 10)
add_menu('10', '회사소개', G5_THEME_URL . '/pag/about.php'); // 임시 링크
add_menu('1010', '회사개요', G5_THEME_URL . '/page/about.php');
add_menu('1020', '인사말', G5_THEME_URL . '/page/greeting.php');
add_menu('1030', '제품개요', G5_THEME_URL . '/page/product_overview.php');
add_menu('1040', '연혁', G5_THEME_URL . '/page/history.php');
add_menu('1050', '조직도', G5_THEME_URL . '/page/org.php');
add_menu('1060', '사업분야', G5_THEME_URL . '/page/business.php');
add_menu('1070', '인증/실적', G5_THEME_URL . '/page/cert.php');
add_menu('1080', '채용정보', G5_THEME_URL . '/page/recruit.php');
add_menu('1090', '찾아오시는길', G5_THEME_URL . '/page/location.php');

// 2. 제품소개 (me_code: 20)
add_menu('20', '제품소개', G5_BBS_URL . '/board.php?bo_table=product');
add_menu('2010', '대문', G5_BBS_URL . '/board.php?bo_table=product&sca=대문');
add_menu('2020', '자동대문', G5_BBS_URL . '/board.php?bo_table=product&sca=자동대문');
add_menu('2030', '오버헤드도어', G5_BBS_URL . '/board.php?bo_table=product&sca=오버헤드도어');
add_menu('2040', '현관문', G5_BBS_URL . '/board.php?bo_table=product&sca=현관문');
add_menu('2050', '친환경', G5_BBS_URL . '/board.php?bo_table=product&sca=친환경');
// ... 나머지 제품들도 카테고리로 연결

// 3. 시공사례 (me_code: 30)
add_menu('30', '시공사례', G5_BBS_URL . '/board.php?bo_table=gallery');

// 4. 온라인문의 (me_code: 40)
add_menu('40', '온라인문의', G5_BBS_URL . '/board.php?bo_table=qa');

// 5. 고객지원 (me_code: 50)
add_menu('50', '고객지원', G5_BBS_URL . '/board.php?bo_table=notice');
add_menu('5010', '뉴스 & 공지', G5_BBS_URL . '/board.php?bo_table=notice');
add_menu('5020', '자료실', G5_BBS_URL . '/board.php?bo_table=data');

echo "메뉴 설정이 완료되었습니다. <a href='" . G5_URL . "'>메인으로 이동</a>";
?>