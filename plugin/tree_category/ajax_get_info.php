<?php
include_once('./_common.php');
header('Content-Type: application/json; charset=utf-8');

$code = isset($_GET['code']) ? preg_replace('/[^0-9a-zA-Z]/', '', $_GET['code']) : '';

if (!$code) {
    echo json_encode(['error' => 'No code provided']);
    exit;
}

$table = 'g5_tree_category_add';

$sql = " SELECT tc_code, tc_name, tc_link FROM {$table} WHERE tc_code = '{$code}' ";
$row = sql_fetch($sql);

if ($row && isset($row['tc_code'])) {
    echo json_encode([
        'success' => true,
        'code' => $row['tc_code'],
        'name' => $row['tc_name'],
        'link' => $row['tc_link']
    ]);
} else {
    echo json_encode(['success' => false, 'error' => 'Category not found']);
}
?>