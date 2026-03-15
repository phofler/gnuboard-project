<?php
include_once('./_common.php');
$table = G5_TABLE_PREFIX . 'plugin_board_skin_config';
$result = sql_query(" DESCRIBE {$table} ");
echo "<h2>Schema for $table</h2>";
echo "<table border=1><tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
while ($row = sql_fetch_array($result)) {
    echo "<tr>";
    foreach ($row as $val)
        echo "<td>$val</td>";
    echo "</tr>";
}
echo "</table>";

echo "<h2>Current Rows</h2>";
$rows = sql_query(" select * from {$table} ");
while ($row = sql_fetch_array($rows)) {
    echo "<pre>" . print_r($row, true) . "</pre>";
}
?>