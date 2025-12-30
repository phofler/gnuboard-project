<?php
include_once('./_common.php');
if (!$is_admin)
    alert('Access Denied');

$table = 'g5_write_menu_pdc';
echo "<h1>Database Inspector: {$table}</h1>";

$sql = " SELECT * FROM {$table} ORDER BY ma_code ASC ";
$res = sql_query($sql);

// [Added] Schema Check
echo "<h2>Table Structure</h2>";
$desc_sql = " DESCRIBE {$table} ";
$desc_res = sql_query($desc_sql);
echo "<table border='1' cellpadding='5' style='border-collapse:collapse; background:#fff;'>";
while ($row = sql_fetch_array($desc_res)) {
    echo "<tr>";
    foreach ($row as $k => $v)
        echo "<td>$k: $v</td>";
    echo "</tr>";
}
echo "</table><br>";

echo "<table border='1' cellpadding='5' style='border-collapse:collapse; width:100%;'>";
echo "<tr style='background:#eee;'>
    <th>ID</th>
    <th>Code</th>
    <th>Name</th>
    <th>Parent</th>
    <th>Action</th>
</tr>";

$count = 0;
while ($row = sql_fetch_array($res)) {
    $count++;
    echo "<tr>
        <td>{$row['ma_id']}</td>
        <td>{$row['ma_code']}</td>
        <td>{$row['ma_name']}</td>
        <td>Let's check code length</td>
        <td>row found</td>
    </tr>";
}
echo "</table>";

if ($count == 0) {
    echo "<h2 style='color:red;'>Table is EMPTY.</h2>";
} else {
    echo "<h2 style='color:blue;'>Found {$count} rows.</h2>";
}
?>