<?php
include_once('./common.php');

echo "Cleaning duplicates from g5_plugin_sub_design_items...\n";

$sql = "DELETE t1 FROM g5_plugin_sub_design_items t1
        INNER JOIN g5_plugin_sub_design_items t2 
        WHERE t1.id < t2.id AND t1.sd_id = t2.sd_id AND t1.me_code = t2.me_code";

sql_query($sql);

echo "Duplicates removed. Attempting to add UNIQUE INDEX...\n";

$sql_idx = "ALTER TABLE g5_plugin_sub_design_items ADD UNIQUE INDEX sd_me_code_idx (sd_id, me_code)";
$res = sql_query($sql_idx, false);

if ($res) {
    echo "SUCCESS: UNIQUE INDEX added.\n";
} else {
    echo "ERROR: Could not add index. It might already exist or there are still duplicates.\n";
    echo sql_error();
}

unlink(__FILE__);
?>