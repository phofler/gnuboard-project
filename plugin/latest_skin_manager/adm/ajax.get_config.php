<?php
include_once('./_common.php');

if (!defined('G5_IS_ADMIN')) {
    die(json_encode(array('error' => 'No access')));
}

$ls_id = isset($_POST['ls_id']) ? trim($_POST['ls_id']) : '';

if (!$ls_id) {
    die(json_encode(array('error' => 'No ID')));
}

$sql = " select * from " . G5_TABLE_PREFIX . "plugin_latest_skin_config where ls_id = '{$ls_id}' ";
$ls = sql_fetch($sql);

if (!$ls) {
    die(json_encode(array('error' => 'Not found')));
}

echo json_encode(array(
    'ls_id' => $ls['ls_id'],
    'ls_title' => $ls['ls_title'],
    'ls_description' => $ls['ls_description'],
    'ls_more_link' => $ls['ls_more_link']
));
?>