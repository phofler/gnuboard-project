<?php
include_once('./_common.php');
$table_name = G5_TABLE_PREFIX . 'plugin_copyright';
echo "<h1>DB Content Debug</h1>";
$result = sql_query("select cp_id, cp_content from {$table_name}");
while ($row = sql_fetch_array($result)) {
    echo "<h2>ID: {$row['cp_id']}</h2>";
    echo "<div style='border:1px solid #ccc; padding:10px;'>";
    echo "<strong>Raw Content (htmlspecialchars):</strong><br>";
    echo nl2br(htmlspecialchars($row['cp_content']));
    echo "</div><br>";
}
?>