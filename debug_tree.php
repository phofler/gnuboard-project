<?php
include_once('./_common.php');
$result = sql_query("SELECT * FROM g5_tree_category_add");
echo "<h2>Tree Category Data</h2>";
echo "<table border=1><tr><th>Code</th><th>Name</th><th>Link</th></tr>";
while ($row = sql_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['tc_code'] . "</td>";
    echo "<td>" . $row['tc_name'] . "</td>";
    echo "<td>" . $row['tc_link'] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>