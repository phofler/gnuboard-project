<?php
include_once('./_common.php');
header('Content-Type: application/json; charset=utf-8');

$root_code = isset($_GET['root_code']) ? preg_replace('/[^0-9a-zA-Z]/', '', $_GET['root_code']) : '';

if (!$root_code) {
    echo json_encode([]);
    exit;
}

$table = 'g5_tree_category_add';

// Logic: specific to depth 2 (root + 2 chars) usually
$root_len = strlen($root_code);
$target_len = $root_len + 2;

$sql = " SELECT tc_code, tc_name FROM {$table} 
         WHERE tc_use = 1 
         AND tc_code LIKE '{$root_code}%' 
         AND LENGTH(tc_code) = {$target_len}
         ORDER BY tc_order ASC, tc_code ASC ";

$result = sql_query($sql);
$list = [];
while ($row = sql_fetch_array($result)) {
    $list[] = [
        'code' => $row['tc_code'],
        'name' => $row['tc_name']
    ];
}

echo json_encode($list);
?>