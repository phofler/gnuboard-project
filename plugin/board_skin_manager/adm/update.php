<?php
$sub_menu = "950195";
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

auth_check_menu($auth, $sub_menu, 'w');

check_admin_token();

$w = isset($_POST['w']) ? $_POST['w'] : '';
$bs_id = isset($_POST['bs_id']) ? trim($_POST['bs_id']) : '';

if (!$bs_id)
    alert('식별코드(ID)가 없습니다.');

$config_table = G5_TABLE_PREFIX . 'plugin_board_skin_config';

// Handle Delete
if ($w == 'd') {
    sql_query(" delete from {$config_table} where bs_id = '{$bs_id}' ");
    goto_url('./list.php');
}

$bs_theme = isset($_POST['bs_theme']) ? $_POST['bs_theme'] : '';
$bs_lang = isset($_POST['bs_lang']) ? $_POST['bs_lang'] : '';
$bo_table = isset($_POST['bo_table']) ? $_POST['bo_table'] : '';
$bs_skin = isset($_POST['bs_skin']) ? $_POST['bs_skin'] : '';
$bs_layout = isset($_POST['bs_layout']) ? $_POST['bs_layout'] : '';
$bs_cols = isset($_POST['bs_cols']) ? (int) $_POST['bs_cols'] : 4;
$bs_ratio = isset($_POST['bs_ratio']) ? $_POST['bs_ratio'] : '4x3';
$bs_theme_mode = isset($_POST['bs_theme_mode']) ? $_POST['bs_theme_mode'] : '';

$sql_common = " bs_theme = '{$bs_theme}',
                bs_lang = '{$bs_lang}',
                bo_table = '{$bo_table}',
                bs_skin = '{$bs_skin}',
                bs_layout = '{$bs_layout}',
                bs_cols = '{$bs_cols}',
                bs_ratio = '{$bs_ratio}',
                bs_theme_mode = '{$bs_theme_mode}' ";

if ($w == '') {
    // Check for duplicate ID
    $exists = sql_fetch(" select bs_id from {$config_table} where bs_id = '{$bs_id}' ");
    if ($exists)
        alert('이미 존재하는 식별코드입니다. 다른 커스텀 이름을 입력하세요.');

    sql_query(" insert into {$config_table} set bs_id = '{$bs_id}', {$sql_common}, reg_date = '" . G5_TIME_YMDHIS . "' ");
} else if ($w == 'u') {
    sql_query(" update {$config_table} set {$sql_common} where bs_id = '{$bs_id}' ");
}

goto_url('./write.php?w=u&bs_id=' . $bs_id);
?>