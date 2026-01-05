<?php
include_once('./_common.php');
if (!$is_admin)
    die('admin only');
$table_name = G5_TABLE_PREFIX . 'plugin_copyright';
$result = sql_query("DESCRIBE $table_name");
while ($row = sql_fetch_array($result)) {
    print_r($row);
    echo "<br>";
}
