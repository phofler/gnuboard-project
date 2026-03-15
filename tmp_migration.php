<?php
include_once("./common.php");
$config_table = G5_TABLE_PREFIX . "plugin_main_image_config";

// Column check and add
$cols = array();
$res = sql_query("DESC {$config_table}");
while($row = sql_fetch_array($res)) { $cols[] = $row["Field"]; }

if(!in_array("mi_effect", $cols)) {
    sql_query("ALTER TABLE {$config_table} ADD COLUMN mi_effect VARCHAR(20) DEFAULT 'none' AFTER mi_skin");
    echo "mi_effect added.\n";
}
if(!in_array("mi_overlay", $cols)) {
    sql_query("ALTER TABLE {$config_table} ADD COLUMN mi_overlay FLOAT DEFAULT 0.4 AFTER mi_effect");
    echo "mi_overlay added.\n";
}
echo "Migration complete.";
?>
