<?php
include_once('./_common.php');
$table = G5_TABLE_PREFIX . 'plugin_company_add';

$skins = array(
    array('id' => 'corporate_light_instinct', 'subject' => 'Defined by Instinct', 'skin' => 'instinct'),
    array('id' => 'corporate_light_overview', 'subject' => 'Company Overview', 'skin' => 'overview'),
    array('id' => 'corporate_light_team', 'subject' => 'Our Team', 'skin' => 'team')
);

foreach ($skins as $s) {
    $exists = sql_fetch(" select count(*) as cnt from $table where co_id = '{$s['id']}' ");
    if (!$exists['cnt']) {
        $sql = " insert into $table 
                 set co_id = '{$s['id']}', 
                     co_subject = '{$s['subject']}', 
                     co_skin = '{$s['skin']}', 
                     co_theme = 'corporate_light', 
                     co_lang = 'kr',
                     co_content = '{LATEST_SKIN_DISPLAY}' "; // Default content
        sql_query($sql);
        echo "Registered: {$s['id']}\n";
    } else {
        echo "Already exists: {$s['id']}\n";
    }
}
?>