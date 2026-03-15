<?php
include_once('./common.php');
$table_name = "g5_plugin_main_image_add";

echo "--- Re-syncing DB Style Names ---\n";

// Current state: 
// Records that were 'B' are now 'full' (but 'full' folder is now named 'fade')
// Records that were 'C' are now 'fade' (but 'fade' folder is now named 'vertical')

// 1. Those that are 'fade' (old C) -> 'vertical'
sql_query(" update {$table_name} set mi_style = 'vertical' where mi_style = 'fade' ");
echo "fade -> vertical: " . sql_affected_rows() . " rows.\n";

// 2. Those that are 'full' (old B) -> 'fade'
sql_query(" update {$table_name} set mi_style = 'fade' where mi_style = 'full' ");
echo "full -> fade: " . sql_affected_rows() . " rows.\n";

// 3. Update active_style.php
$active_file = G5_PLUGIN_PATH . '/main_image_manager/active_style.php';
if (file_exists($active_file)) {
    $curr = trim(file_get_contents($active_file));
    if ($curr == 'fade') file_put_contents($active_file, 'vertical');
    else if ($curr == 'full') file_put_contents($active_file, 'fade');
}

echo "--- Sync Complete ---\n";
?>
