<?php
include_once("./common.php");
$res = sql_query("SHOW COLUMNS FROM g5_write_menu_pdc");
while($row = sql_fetch_array($res)) {
    echo $row["Field"] . "\n";
}
?>