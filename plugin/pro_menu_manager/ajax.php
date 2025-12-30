<?php
include_once('./_common.php');
include_once(dirname(__FILE__) . '/lib.php');

if (!$is_admin) {
    die(json_encode(array('error' => '관리자만 접근 가능합니다.')));
}

// Check Token
// check_admin_token(); // Optional: Enable if using tokens

$w = isset($_POST['w']) ? $_POST['w'] : '';
$table_name = "g5_write_menu_add";

if ($w == 'c') {
    // Create
    $parent_code = isset($_POST['parent_code']) ? $_POST['parent_code'] : '';
    $ma_name = isset($_POST['ma_name']) ? trim($_POST['ma_name']) : '';

    if (!$ma_name) {
        die(json_encode(array('error' => '메뉴명을 입력해주세요.')));
    }

    // Generate Code
    $len_target = strlen($parent_code) + 2;
    $sql_search = " SELECT MAX(ma_code) as max_code FROM {$table_name} WHERE length(ma_code) = {$len_target} AND ma_code LIKE '{$parent_code}%' ";
    $row = sql_fetch($sql_search);

    if ($row['max_code']) {
        // Increment
        $last_num = hexdec(substr($row['max_code'], -2));
        $new_num = $last_num + 10; // Increment by 10
        $new_code = $parent_code . strtoupper(str_pad(dechex($new_num), 2, '0', STR_PAD_LEFT));
    } else {
        // Start
        $new_code = $parent_code . '10';
    }

    $sql = " INSERT INTO {$table_name}
                SET ma_code = '{$new_code}',
                    ma_name = '{$ma_name}',
                    ma_link = '{$_POST['ma_link']}',
                    ma_target = '{$_POST['ma_target']}',
                    ma_order = '{$_POST['ma_order']}',
                    ma_use = '{$_POST['ma_use']}',
                    ma_mobile_use = '{$_POST['ma_mobile_use']}',
                    ma_regdt = '" . G5_TIME_YMDHIS . "' ";
    sql_query($sql);

    die(json_encode(array('success' => true, 'msg' => '추가되었습니다.', 'code' => $new_code)));

} else if ($w == 'u') {
    // Update
    $ma_code = isset($_POST['ma_code']) ? $_POST['ma_code'] : '';
    if (!$ma_code)
        die(json_encode(array('error' => '코드가 없습니다.')));

    $sql = " UPDATE {$table_name}
                SET ma_name = '{$_POST['ma_name']}',
                    ma_link = '{$_POST['ma_link']}',
                    ma_target = '{$_POST['ma_target']}',
                    ma_order = '{$_POST['ma_order']}',
                    ma_use = '{$_POST['ma_use']}',
                    ma_mobile_use = '{$_POST['ma_mobile_use']}'
              WHERE ma_code = '{$ma_code}' ";
    sql_query($sql);

    die(json_encode(array('success' => true, 'msg' => '수정되었습니다.')));

} else if ($w == 'd') {
    // Delete
    $ma_code = isset($_POST['ma_code']) ? $_POST['ma_code'] : '';
    if (!$ma_code)
        die(json_encode(array('error' => '코드가 없습니다.')));

    // Check children
    // If strict: prevent delete if children exist
    // If loose: delete all children

    // Implementing Cascading Delete
    $sql = " DELETE FROM {$table_name} WHERE ma_code LIKE '{$ma_code}%' "; // Delete self and all children
    sql_query($sql);

    die(json_encode(array('success' => true, 'msg' => '삭제되었습니다.')));
}

die(json_encode(array('error' => '잘못된 요청입니다.')));
?>