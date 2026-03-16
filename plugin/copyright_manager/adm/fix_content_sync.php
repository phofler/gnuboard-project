<?php
include_once('./_common.php');
$table_name = G5_TABLE_PREFIX . 'plugin_copyright';
$cp = sql_fetch(" select * from {$table_name} where cp_id = 'kukdong_panel' ");
if(!$cp) die("No record");

$content = $cp['cp_content'];

/**
 * Robust replacement to handle strings even if they contain HTML tags internally
 */
function fuzzy_replace($search, $replace, $subject) {
    if(!$search) return $subject;
    // Create a regex that allows optional HTML tags between each character of the search string
    $escaped = preg_quote($search, '/');
    // Allow any amount of HTML tags between characters
    $pattern = '';
    $chars = preg_split('//u', $search, -1, PREG_SPLIT_NO_EMPTY);
    foreach($chars as $char) {
        $pattern .= preg_quote($char, '/') . '(<[^>]+>)*';
    }
    return preg_replace('/' . $pattern . '/u', $replace, $subject);
}

// Perform sync
$content = fuzzy_replace("경기도 파주시 광탄면 분수3리 94-7", "{addr}", $content);
$content = fuzzy_replace($cp['addr_val'], "{addr}", $content);
$content = fuzzy_replace($cp['company_val'], "{company}", $content);
$content = fuzzy_replace($cp['ceo_val'], "{ceo}", $content);
$content = fuzzy_replace($cp['bizno_val'], "{bizno}", $content);
$content = fuzzy_replace($cp['tel_val'], "{tel}", $content);
$content = fuzzy_replace($cp['fax_val'], "{fax}", $content);
$content = fuzzy_replace($cp['email_val'], "{email}", $content);

sql_query(" update {$table_name} set cp_content = '" . addslashes($content) . "' where cp_id = 'kukdong_panel' ");
echo "Intelligent Sync Completed. Hardcoded values replaced with placeholders via Regex.";
?>