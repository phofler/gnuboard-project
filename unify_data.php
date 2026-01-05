<?php
include_once('./common.php');
$table_name = "g5_plugin_main_image_add";

echo "--- Starting Data Unification ---\n";

// 1. Move A -> basic
$res_a = sql_query(" update {$table_name} set mi_style = 'basic' where mi_style = 'A' ");
$rows_a = sql_affected_rows();
echo "A -> basic: {$rows_a} rows updated.\n";

// 2. Move B -> full
$res_b = sql_query(" update {$table_name} set mi_style = 'full' where mi_style = 'B' ");
$rows_b = sql_affected_rows();
echo "B -> full: {$rows_b} rows updated.\n";

// 3. Move C -> fade
$res_c = sql_query(" update {$table_name} set mi_style = 'fade' where mi_style = 'C' ");
$rows_c = sql_affected_rows();
echo "C -> fade: {$rows_c} rows updated.\n";

echo "--- Unification Complete ---\n";
?>