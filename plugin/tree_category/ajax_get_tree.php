<?php
include_once('./_common.php');
header('Content-Type: application/json; charset=utf-8');

$bo_table = isset($_GET['bo_table']) ? trim($_GET['bo_table']) : '';

if (!$bo_table) {
    echo json_encode(['error' => 'No board table provided']);
    exit;
}

// 1. Get Tree ID linked to this board
// Assuming there's a mapping in g5_tree_category_add or similar, 
// OR simpler: find any root category that links to this board URL.
// Since we don't have a direct bo_table field in tree_category, we search by link content.
// A more robust way: The user might have set up a specific "Tree Code" for this board.
// For now, we fetch ALL categories related to this bo_table.

// 1. Find Root Category linked to this board
$sql_root = " SELECT tc_code FROM g5_tree_category_add WHERE (tc_link LIKE '%bo_table={$bo_table}%' OR tc_link = '{$bo_table}') ORDER BY tc_code ASC LIMIT 1 ";
$root_row = sql_fetch($sql_root);

if (!$root_row) {
    echo json_encode(['success' => false, 'error' => 'No linked category found']);
    exit;
}

$root_code = $root_row['tc_code'];

// 2. Fetch Root AND All Descendants (using LIKE 'code%')
$sql = " SELECT * FROM g5_tree_category_add WHERE tc_code LIKE '{$root_code}%' ORDER BY tc_code ASC ";
$result = sql_query($sql);

$data = [];
while ($row = sql_fetch_array($result)) {
    // Basic fields
    $item = [
        'code' => $row['tc_code'],
        'name' => $row['tc_name'],
        'depth' => strlen($row['tc_code']) // 10 (2), 1010 (4), 101010 (6) ...
    ];

    // Parent code (substring)
    $parent_len = strlen($row['tc_code']) - 2;
    if ($parent_len > 0) {
        $item['parent'] = substr($row['tc_code'], 0, $parent_len);
    } else {
        $item['parent'] = 'root';
    }

    $data[] = $item;
}

// Transform flat list to nested tree (Client-side can also do this, 
// but let's provide a flat list with parent keys for easier JS processing)
echo json_encode([
    'success' => true,
    'data' => $data
]);
?>