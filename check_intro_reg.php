<?php
include_once('./_common.php');
$table = G5_TABLE_PREFIX . 'plugin_company_add';
$sql = " select co_id, co_subject, co_skin, co_theme, co_lang from $table where co_theme = 'corporate_light' ";
$result = sql_query($sql);
if (!$result) {
    echo "Query failed: " . sql_error();
} else {
    while ($row = sql_fetch_array($result)) {
        echo "ID: {$row['co_id']} | Subject: {$row['co_subject']} | Skin: {$row['co_skin']} | Theme: {$row['co_theme']} | Lang: {$row['co_lang']}\n";
    }
}
?>