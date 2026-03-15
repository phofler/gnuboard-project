<?php
include_once('./_common.php');

$table_name = G5_TABLE_PREFIX . 'plugin_copyright';

if ($cp_id == 'default') {
    alert('기본 설정은 삭제할 수 없습니다.');
}

$sql = " delete from {$table_name} where cp_id = '{$cp_id}' ";
sql_query($sql);

alert('삭제되었습니다.', './list.php');
?>