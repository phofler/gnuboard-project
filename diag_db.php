<?php
include_once('./_common.php');
echo "--- ACTIVE SECTIONS ---\n";
$sql = "select ms_id, ms_title, ms_skin, ms_lang, ms_active, ms_theme from g5_plugin_main_content_sections order by ms_sort asc";
$res = sql_query($sql);
while($row = sql_fetch_array($res)) {
    echo "ID: {$row['ms_id']} | Title: {$row['ms_title']} | Skin: {$row['ms_skin']} | Lang: {$row['ms_lang']} | Active: {$row['ms_active']} | Theme: {$row['ms_theme']}\n";
    $sql2 = "select mc_id, mc_title from g5_plugin_main_content where ms_id = '{$row['ms_id']}'";
    $res2 = sql_query($sql2);
    while($row2 = sql_fetch_array($res2)) {
        echo "  - Item: {$row2['mc_title']}\n";
    }
}
?>
