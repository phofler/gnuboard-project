<?php
include_once('./_common.php');
include_once(G5_PLUGIN_PATH . '/pro_menu_manager/lib.php');

echo "<h1>Menu Data Debug</h1>";

// 1. Check Table
$table_name = "g5_write_menu_pdc";
$sql = " SELECT count(*) as cnt FROM {$table_name} ";
$row = sql_fetch($sql);
echo "<p>Total Rows in DB: " . $row['cnt'] . "</p>";

// 2. Check Raw List
$raw = get_pro_menu_list();
echo "<h2>Raw Data (First 3 items)</h2>";
echo "<pre>";
print_r(array_slice($raw, 0, 3));
echo "</pre>";

// 3. Check Mapped Data
$tree = build_pro_menu_tree($raw);
$menu_datas = array();
foreach ($tree as $root) {
    $menu_datas[] = array(
        'me_name' => $root['ma_name'],
        'me_code' => $root['ma_code'],
        'me_link' => $root['ma_link']
    );
}

echo "<h2>Mapped Data (Frontend Format)</h2>";
echo "<pre>";
print_r($menu_datas);
echo "</pre>";
?>