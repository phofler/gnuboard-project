<?php
include_once(dirname(__FILE__) . '/../_common.php');

// [ASYNC WORKER]
// This script is called asynchronously via fsockopen or curl with a very short timeout.
// It continues to run in the background to send emails.

// Ignore user aborts and allow the script to run forever
ignore_user_abort(true);
set_time_limit(0);

// Basic Security Check
$wr_id = isset($_REQUEST['wr_id']) ? (int) $_REQUEST['wr_id'] : 0;
if (!$wr_id)
    exit;

// Fetch Inquiry Data
$write_table = G5_PLUGIN_ONLINE_INQUIRY_TABLE;
$sql = " select * from {$write_table} where id = '{$wr_id}' ";
$row = sql_fetch($sql);

if (!$row)
    exit;

// Prepare Data for Hook
$hook_data = array(
    'name' => $row['name'],
    'contact' => $row['contact'],
    'email' => $row['email'],
    'subject' => $row['subject'],
    'content' => $row['content'],
    'theme' => $row['theme'], // Add theme info if needed
    'lang' => $row['lang']    // Add lang info if needed
);

// Trigger the Email Hook
// Note: hook.php MUST be loaded via common.php -> plugin loading mechanism.
// Since we included _common.php, standard plugin hooks should be available if initialized properly.
// However, to be safe, we manually call the function if it exists, or trigger the event.

if (function_exists('run_event')) {
    run_event('online_inquiry_send_email', $wr_id, $hook_data);
}
?>