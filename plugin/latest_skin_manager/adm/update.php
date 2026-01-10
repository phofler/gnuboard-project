<?php
$sub_menu = "950193";
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

auth_check_menu($auth, $sub_menu, 'w');

// CSRF Check
// check_admin_token();

$ls_theme = isset($_POST['ls_theme']) ? trim($_POST['ls_theme']) : '';
$ls_lang = isset($_POST['ls_lang']) ? trim($_POST['ls_lang']) : '';
$ls_more_link = isset($_POST['ls_more_link']) ? trim($_POST['ls_more_link']) : '';
$ls_description = isset($_POST['ls_description']) ? trim($_POST['ls_description']) : '';
$ls_options = isset($_POST['ls_options']) ? trim($_POST['ls_options']) : '';
$ls_title = isset($_POST['ls_title']) ? trim($_POST['ls_title']) : '';
$ls_skin = isset($_POST['ls_skin']) ? trim($_POST['ls_skin']) : '';
$ls_bo_table = isset($_POST['ls_bo_table']) ? trim($_POST['ls_bo_table']) : '';
$ls_count = isset($_POST['ls_count']) ? (int) $_POST['ls_count'] : 4;
$ls_subject_len = isset($_POST['ls_subject_len']) ? (int) $_POST['ls_subject_len'] : 30;
$ls_active = isset($_POST['ls_active']) ? 1 : 0;
$ls_sort = isset($_POST['ls_sort']) ? (int) $_POST['ls_sort'] : 0;

// String ID Handling
$ls_id = isset($_POST['ls_id']) ? trim($_POST['ls_id']) : '';

// Generate ID if empty (New Mode)
if (!$ls_id && $w == '') {
    $ls_id = $ls_theme;
    // Standard Rule: Skip 'kr' suffix for Korean
    if ($ls_lang && $ls_lang != 'kr')
        $ls_id .= '_' . $ls_lang;

    // Append custom options/name if provided
    if ($ls_options)
        $ls_id .= '_' . $ls_options;
}

$sql_common = " ls_theme = '{$ls_theme}',
                ls_lang = '{$ls_lang}',
                ls_title = '{$ls_title}',
                ls_more_link = '{$ls_more_link}',
                ls_description = '{$ls_description}',
                ls_skin = '{$ls_skin}',
                ls_bo_table = '{$ls_bo_table}',
                ls_count = '{$ls_count}',
                ls_subject_len = '{$ls_subject_len}',
                ls_options = '{$ls_options}',
                ls_active = '{$ls_active}',
                ls_sort = '{$ls_sort}' ";

if ($w == '') {
    // Check duplication
    $row = sql_fetch(" select count(*) as cnt from " . G5_PLUGIN_LATEST_SKIN_TABLE . " where ls_id = '{$ls_id}' ");
    if ($row['cnt']) {
        alert("이미 존재하는 식별코드(ID)입니다: " . $ls_id);
    }
    $sql = " insert into " . G5_PLUGIN_LATEST_SKIN_TABLE . " set ls_id = '{$ls_id}', {$sql_common} ";
    sql_query($sql);
} else if ($w == 'u') {
    // Update based on OLD ID if passed, or just update the row match
    $sql = " update " . G5_PLUGIN_LATEST_SKIN_TABLE . " set {$sql_common} where ls_id = '{$ls_id}' ";
    sql_query($sql);
} else if ($w == 'd') {
    $ls_id = isset($_REQUEST['ls_id']) ? $_REQUEST['ls_id'] : '';
    $sql = " delete from " . G5_PLUGIN_LATEST_SKIN_TABLE . " where ls_id = '{$ls_id}' ";
    sql_query($sql);
}

goto_url('./list.php');
?>