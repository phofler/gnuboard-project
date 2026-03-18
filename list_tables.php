<?php
include_once("./common.php");
$res = sql_query("SHOW TABLES");
while($row = sql_fetch_array($res)) {
    echo $row[0] . "\n";
}
?>