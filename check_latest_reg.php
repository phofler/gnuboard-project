<?php
include_once('./_common.php');
$table = G5_TABLE_PREFIX . 'plugin_latest_skin_config';
$sql = " select ls_id, ls_title, ls_skin, ls_theme, ls_lang from $table ";
$result = sql_query($sql);
if (!$result) {
    echo "Query failed: " . sql_error();
} else {
    while ($row = sql_fetch_array($result)) {
        echo "ID: {$row['ls_id']} | Title: {$row['ls_title']} | Skin: {$row['ls_skin']} | Theme: {$row['ls_theme']} | Lang: {$row['ls_lang']}\n";
    }
}
?>