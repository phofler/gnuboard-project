<?php
include_once('./_common.php');
if (!defined('G5_USE_SHOP') || !G5_USE_SHOP)
    define('G5_USE_SHOP', true);

// Check root categories
echo "Checking Root Categories (Length 2):\n";
$sql = " SELECT me_code, me_name, me_use FROM {$g5['menu_table']} WHERE LENGTH(me_code) = 2 ORDER BY me_code ";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
    echo "[{$row['me_code']}] {$row['me_name']} (Use: {$row['me_use']})\n";
    // Check children
    $sql2 = " SELECT me_code, me_name, me_use FROM {$g5['menu_table']} WHERE me_code LIKE '{$row['me_code']}%' AND
LENGTH(me_code) = 4 ORDER BY me_code ";
    $res2 = sql_query($sql2);
    while ($row2 = sql_fetch_array($res2)) {
        echo " - [{$row2['me_code']}] {$row2['me_name']} (Use: {$row2['me_use']})\n";
    }
}
?>