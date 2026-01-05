<?php
include_once('./_common.php');
$sql = "DESC " . G5_TABLE_PREFIX . "plugin_copyright";
$res = sql_query($sql);
while ($row = sql_fetch_array($res)) {
    echo $row['Field'] . " | ";
}
