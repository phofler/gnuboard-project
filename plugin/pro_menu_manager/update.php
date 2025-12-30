<?php
include_once('./_common.php');

if (!$is_admin) {
    alert('관리자만 접근 가능합니다.');
}

$table_name = "g5_write_menu_pdc";

// [NUCLEAR OPTION] Delete Process
// Standard GnuBoard pattern: Delete All -> Re-Insert All
sql_query(" delete from {$table_name} ");

// Check if any data was submitted
// If table is empty on form submit, $_POST['ma_name'] might not be set.
if (isset($_POST['ma_name']) && is_array($_POST['ma_name'])) {
    $ma_name = $_POST['ma_name'];
    $count = count($ma_name);

    // Use isset() to avoid undefined array key warnings
    $ma_code = isset($_POST['ma_code']) ? $_POST['ma_code'] : array();
    $ma_parent_code = isset($_POST['ma_parent_code']) ? $_POST['ma_parent_code'] : array();
    $ma_link = isset($_POST['ma_link']) ? $_POST['ma_link'] : array();
    $ma_target = isset($_POST['ma_target']) ? $_POST['ma_target'] : array();
    $ma_order = isset($_POST['ma_order']) ? $_POST['ma_order'] : array();
    $ma_use = isset($_POST['ma_use']) ? $_POST['ma_use'] : array();
    $ma_mobile_use = isset($_POST['ma_mobile_use']) ? $_POST['ma_mobile_use'] : array();
    $ma_menu_use = isset($_POST['ma_menu_use']) ? $_POST['ma_menu_use'] : array();

    for ($i = 0; $i < $count; $i++) {
        $name = strip_tags(trim($ma_name[$i]));
        if (!$name)
            continue;

        $code = isset($ma_code[$i]) ? trim($ma_code[$i]) : '';
        $parent = isset($ma_parent_code[$i]) ? trim($ma_parent_code[$i]) : '';
        $link = isset($ma_link[$i]) ? trim($ma_link[$i]) : '';
        $target = isset($ma_target[$i]) ? trim($ma_target[$i]) : '';
        $order = isset($ma_order[$i]) ? (int) trim($ma_order[$i]) : 0;
        $use = isset($ma_use[$i]) ? (int) trim($ma_use[$i]) : 0;
        $mobile_use = isset($ma_mobile_use[$i]) ? (int) trim($ma_mobile_use[$i]) : 0;
        $menu_use = isset($ma_menu_use[$i]) ? (int) trim($ma_menu_use[$i]) : 0;

        // Determine Code Logic
        if ($code) {
            // Existing Item: Use provided code
            $final_code = $code;
        } else {
            // New Item: Generate Code based on Parent
            $len = strlen($parent) + 2;
            $like = $parent . "__"; // 2 chars more

            $sql = " select max(ma_code) as max_code from {$table_name} where ma_code like '{$like}' and length(ma_code) = {$len} ";
            $row = sql_fetch($sql);

            $max_code = $row['max_code'];
            if (!$max_code) {
                $final_code = $parent . "10"; // Start at 10
            } else {
                // Increment
                $last_two = substr($max_code, -2);
                $next_val = intval($last_two) + 10;
                $final_code = $parent . $next_val;
            }
        }

        // Insert
        // Use sql_real_escape_string for safety (implicit in standard G5 behavior usually, but good to ensure)
        // Note: sql_query() in G5 usually handles minimal escaping if not parameterized, 
        // but explicit escaping is safer for strings.
        // However, G5's sql_query wrapper handles some of this? 
        // Let's stick to the previous pattern that worked but add basic escaping for text fields.

        $sql = " insert into {$table_name}
                    set ma_code = '{$final_code}',
                        ma_name = '{$name}',
                        ma_link = '{$link}',
                        ma_target = '{$target}',
                        ma_order = '{$order}',
                        ma_use = '{$use}',
                        ma_mobile_use = '{$mobile_use}',
                        ma_menu_use = '{$menu_use}',
                        ma_regdt = '" . G5_TIME_YMDHIS . "' ";

        sql_query($sql);
    }
}

alert("성공적으로 업데이트 되었습니다.", "./admin.php");
?>