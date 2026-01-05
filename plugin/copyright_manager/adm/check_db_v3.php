<?php
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['SERVER_PORT'] = '80';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
define('G5_IS_ADMIN', true);
include_once('./_common.php');
$sql = "DESC " . G5_TABLE_PREFIX . "plugin_copyright";
$res = sql_query($sql);
while ($row = sql_fetch_array($res)) {
    echo $row['Field'] . " | ";
}
echo "\nDONE\n";
