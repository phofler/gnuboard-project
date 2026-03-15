<?php
include_once('../../common.php');

// [Core Headers]
$g5['title'] = "Online Inquiry";
include_once(G5_PATH . '/head.php');

// [Input Validation]
$oi_id = isset($_GET['oi_id']) ? clean_xss_tags($_GET['oi_id']) : '';

// [Plugin Table]
$config_table = G5_TABLE_PREFIX . 'plugin_online_inquiry_config';
$row = array();

if ($oi_id) {
    // 1. Direct Match
    $row = sql_fetch(" select * from {$config_table} where oi_id = '{$oi_id}' ");

    if (!$row['oi_id']) {
        // 2. Try adding current theme prefix (Auto-Resolve)
        // e.g. oi_id='corporate' -> 'corporate_kr' or similar via form.php logic

        // Since form.php handles the fallback logic internally based on $theme and $lang,
        // we mainly need to ensure $theme and $lang are set correctly if not passed.
        // But here we want to see if we can find the config to set the page title.

        global $config;
        $current_theme = isset($config['cf_theme']) ? $config['cf_theme'] : 'corporate';
        $lang = isset($g5['lang']) ? $g5['lang'] : (isset($_GET['lang']) ? $_GET['lang'] : 'kr');

        $target_id = $current_theme . ($lang == 'kr' ? '' : '_' . $lang);
        if ($oi_id == $current_theme) {
            $row = sql_fetch(" select * from {$config_table} where oi_id = '{$target_id}' ");
        }
    }
}

// [Render View]
// SEO Title Override
if (isset($row['subject']) && $row['subject']) {
    $g5['title'] = $row['subject'];
}

// Pass Data to View
include(G5_PLUGIN_PATH . '/online_inquiry/form.php');

include_once(G5_PATH . '/tail.php');
?>