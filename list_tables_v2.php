<?php
include_once("./common.php");
$res = sql_query("SHOW TABLES");
echo "TABLES_LIST_START\n";
while($row = sql_fetch_row($res)) {
    echo $row[0] . "\n";
}
echo "TABLES_LIST_END\n";
?>