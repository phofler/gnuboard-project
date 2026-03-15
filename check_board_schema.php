<?php
include_once('./common.php');
$sql = "desc $g5['board_table']";
$result = sql_query($sql);
while($row = sql_fetch_array($result)) {
    echo $row['Field'] . " (" . $row['Type'] . ")\n";
}
?>
