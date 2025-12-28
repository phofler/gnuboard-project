<?php
$sub_menu = '300910';
include_once(dirname(__FILE__) . '/../_common.php');

if (!defined('G5_ADMIN_PATH')) {
    define('G5_ADMIN_PATH', G5_PATH . '/adm');
}
include_once(G5_ADMIN_PATH . '/admin.lib.php');

auth_check_menu($auth, $sub_menu, 'd');

check_token();

if ($_POST['act_button'] == "선택삭제") {
    $count = isset($_POST['chk']) ? count($_POST['chk']) : 0;
    if ($count == 0) {
        alert("선택하신 게시물이 없습니다.");
    }

    $write_table = G5_PLUGIN_ONLINE_INQUIRY_TABLE;

    for ($i = 0; $i < $count; $i++) {
        // 실제 번호를 넘어온 값으로 체크
        $k = $_POST['chk'][$i];

        // 데이터 존재 확인 (필수는 아니지만 안전을 위해)
        $id = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;

        if ($id) {
            sql_query(" delete from {$write_table} where id = '{$id}' ");
        }
    }
}

// alert 함수 호출 전 CWD 변경
chdir(G5_PATH);
alert('선택한 자료가 삭제되었습니다.', G5_PLUGIN_URL . '/online_inquiry/adm/list.php');
?>