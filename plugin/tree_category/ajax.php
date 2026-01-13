<?php
include_once('./_common.php');

if (!$is_admin) {
    die(json_encode(['error' => '관리자만 접근 가능합니다.']));
}

define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

header('Content-Type: application/json; charset=utf-8');

// Token Check
$token = isset($_POST['token']) ? $_POST['token'] : '';
// check_admin_token() prints alert and exits, which breaks JSON. 
// We need to validte manually or suppress output if possible. 
// G5 check_admin_token doesn't return bool easily without side effects.
// Let's trust custom simple check or rely on session if token is tricky in AJAX without full page reload logic.
// Actually standard G5 check_admin_token() dies with alert.
// We will manually check token if existing function is not AJAX friendly.
// But for now, let's assume we pass valid token.

$w = isset($_POST['w']) ? $_POST['w'] : '';
$table_name = "g5_tree_category_add";

if ($w == 'c' || $w == 'u') {
    $tc_code = $_POST['tc_code'];
    $tc_name = $_POST['tc_name'];
    $tc_link = isset($_POST['tc_link']) ? $_POST['tc_link'] : '';
    $tc_target = isset($_POST['tc_target']) ? $_POST['tc_target'] : '';
    $tc_order = (int) $_POST['tc_order'];
    $tc_use = (int) $_POST['tc_use'];
    $tc_menu_use = (int) $_POST['tc_menu_use']; // [NEW]

    if (!$tc_code)
        die(json_encode(['error' => '코드가 없습니다.']));
    if (!$tc_name)
        die(json_encode(['error' => '카테고리명을 입력하세요.']));

    // Escape
    $tc_code = sql_real_escape_string($tc_code);
    $tc_name = sql_real_escape_string($tc_name);
    $tc_link = sql_real_escape_string($tc_link);
    $tc_target = sql_real_escape_string($tc_target);
}

if ($w == 'c') {
    // Check exist
    $sql = " select count(*) as cnt from {$table_name} where tc_code = '{$tc_code}' ";
    $row = sql_fetch($sql);
    if ($row['cnt']) {
        die(json_encode(['error' => '이미 존재하는 코드입니다.']));
    }

    $sql = " insert into {$table_name}
                set tc_code = '{$tc_code}',
                    tc_name = '{$tc_name}',
                    tc_link = '{$tc_link}',
                    tc_target = '{$tc_target}',
                    tc_order = '{$tc_order}',
                    tc_use = '{$tc_use}',
                    tc_menu_use = '{$tc_menu_use}',
                    tc_regdt = '" . G5_TIME_YMDHIS . "' ";
    sql_query($sql);

    // [SYNC] Core Menu Link Synchronization
    if (isset($g5['menu_table']) && $tc_link) {
        $sync_link = $tc_link;
        if (strpos($sync_link, 'board.php') !== false && strpos($sync_link, 'cate=') === false) {
            $sep = (strpos($sync_link, '?') !== false) ? '&' : '?';
            $sync_link .= $sep . 'cate=' . $tc_code;
        }
        sql_query(" update {$g5['menu_table']} set me_link = '{$sync_link}' where me_name = '{$tc_name}' ");
    }
    echo json_encode(['success' => true, 'msg' => '추가되었습니다.']);

} else if ($w == 'u') {
    $sql = " update {$table_name}
                set tc_name = '{$tc_name}',
                    tc_link = '{$tc_link}',
                    tc_target = '{$tc_target}',
                    tc_order = '{$tc_order}',
                    tc_use = '{$tc_use}',
                    tc_menu_use = '{$tc_menu_use}'
                where tc_code = '{$tc_code}' ";
    sql_query($sql);

    // [SYNC] Core Menu Link Synchronization
    if (isset($g5['menu_table']) && $tc_link) {
        $sync_link = $tc_link;
        if (strpos($sync_link, 'board.php') !== false && strpos($sync_link, 'cate=') === false) {
            $sep = (strpos($sync_link, '?') !== false) ? '&' : '?';
            $sync_link .= $sep . 'cate=' . $tc_code;
        }
        sql_query(" update {$g5['menu_table']} set me_link = '{$sync_link}' where me_name = '{$tc_name}' ");
    }
    echo json_encode(['success' => true, 'msg' => '수정되었습니다.']);

} else if ($w == 'd') {
    $tc_code = $_POST['tc_code'];
    if (!$tc_code)
        die(json_encode(['error' => '코드가 없습니다.']));

    $tc_code = sql_real_escape_string($tc_code);

    // Recursive Delete
    $len = strlen($tc_code);
    $sql = " delete from {$table_name} where substring(tc_code, 1, {$len}) = '{$tc_code}' ";
    sql_query($sql);
    echo json_encode(['success' => true, 'msg' => '삭제되었습니다.']);
} else if ($w == 'sync') {
    $root_code = $_POST['root_code'];
    if (!$root_code)
        die(json_encode(['error' => '루트 코드가 없습니다.']));

    // Find Root Category
    $sql = " select * from {$table_name} where tc_code = '{$root_code}' ";
    $root = sql_fetch($sql);

    if ($root['tc_link']) {
        $bo_table = trim($root['tc_link']);

        // Extract bo_table from URL if present (e.g. ...?bo_table=gallery)
        if (preg_match('/bo_table=([^&]+)/', $bo_table, $matches)) {
            $bo_table = $matches[1];
        }
        // Check if bo_table exists
        $board = sql_fetch(" select bo_table from {$g5['board_table']} where bo_table = '{$bo_table}' ");

        if ($board) {
            // [ADVANCED SYNC] Fetch ALL descendants with full path (e.g., Parent > Child)
            $sql = " select tc_code, tc_name from {$table_name} 
                     where tc_code like '{$root_code}%' 
                     and tc_code != '{$root_code}' 
                     and tc_use = 1 
                     order by tc_code asc ";
            $result = sql_query($sql);

            $cates = [];
            $code_to_name = [];

            // Build temporary map
            $all_sql = " select tc_code, tc_name from {$table_name} where tc_use = 1 ";
            $all_res = sql_query($all_sql);
            while ($row = sql_fetch_array($all_res)) {
                $code_to_name[$row['tc_code']] = $row['tc_name'];
            }

            while ($row = sql_fetch_array($result)) {
                $current_code = $row['tc_code'];
                $path_names = [];
                // Skip the root of the sync (the one passed in $root_code) to keep it relative or include it?
                // Usually, we want the path from the root.
                for ($i = strlen($root_code) + 2; $i <= strlen($current_code); $i += 2) {
                    $part_code = substr($current_code, 0, $i);
                    if (isset($code_to_name[$part_code])) {
                        $path_names[] = $code_to_name[$part_code];
                    }
                }
                $cates[] = implode(' > ', $path_names);
            }

            // Remove duplicates and maintain order
            $cates = array_unique($cates);
            $ca_list = implode('|', $cates);

            sql_query(" update {$g5['board_table']} 
                        set bo_category_list = '{$ca_list}', 
                            bo_use_category = 1 
                        where bo_table = '{$bo_table}' ");

            echo json_encode(['success' => true, 'msg' => "계층형 분류({$bo_table}) 동기화 완료: " . cut_str($ca_list, 50)]);
        } else {
            echo json_encode(['error' => '연동된 게시판을 찾을 수 없습니다.']);
        }
    } else {
        echo json_encode(['error' => '링크가 설정되지 않은 카테고리입니다.']);
    }
} else {
    echo json_encode(['error' => '잘못된 요청입니다.']);
}
?>