<?php
$sub_menu = '300910';
include_once(dirname(__FILE__) . '/../_common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');

auth_check_menu($auth, $sub_menu, 'w');

$config_table = G5_TABLE_PREFIX . 'plugin_online_inquiry_config';

$w = isset($_POST['w']) ? $_POST['w'] : '';
$oi_id = clean_xss_tags($_POST['oi_id']);
$old_oi_id = isset($_POST['old_oi_id']) ? clean_xss_tags($_POST['old_oi_id']) : '';
$theme = clean_xss_tags($_POST['oi_theme']);
$lang = clean_xss_tags($_POST['oi_lang']);
$skin = clean_xss_tags($_POST['skin']);
$subject = clean_xss_tags($_POST['subject']);
$content = isset($_POST['content']) ? $_POST['content'] : '';
$content = stripslashes($content); // Prevent double escaping
$label_name = clean_xss_tags($_POST['label_name']);
$label_phone = clean_xss_tags($_POST['label_phone']);
$label_msg = clean_xss_tags($_POST['label_msg']);
$label_submit = clean_xss_tags($_POST['label_submit']);

// Check Duplicate (only for new entries or if changing keys)
if ($w == '' || ($w == 'u' && $oi_id !== $old_oi_id)) {
    $row = sql_fetch(" select count(*) as cnt from {$config_table} where oi_id = '{$oi_id}' ");
    if ($row['cnt']) {
        alert("이미 등록된 식별코드(ID)입니다. 다른 테마/언어 조합을 선택하거나 목록에서 수정해주세요.");
    }
}

$sql_common = " oi_id = '{$oi_id}',
                theme = '{$theme}',
                lang = '{$lang}',
                skin = '{$skin}',
                subject = '{$subject}',
                content = '" . addslashes($content) . "',
                label_name = '{$label_name}',
                label_phone = '{$label_phone}',
                label_msg = '{$label_msg}',
                label_submit = '{$label_submit}' ";

if ($w == '') {
    $sql = " insert into {$config_table} set {$sql_common}, reg_date = NOW() ";
    sql_query($sql);
} else if ($w == 'u') {
    $sql = " update {$config_table} set {$sql_common} where oi_id = '{$old_oi_id}' ";
    sql_query($sql);
}

// Redirect to List
goto_url('./skin_list.php');
?>