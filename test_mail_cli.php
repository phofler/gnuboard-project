<?php
define('_GNUBOARD_', true);
include_once('./common.php');
include_once(G5_LIB_PATH . '/mailer.lib.php');

// Force display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Starting Mail Test...\n";
echo "SMTP Config: " . (defined('G5_SMTP') ? G5_SMTP : 'Not Set') . "\n";
echo "SMTP Port: " . (defined('G5_SMTP_PORT') ? G5_SMTP_PORT : 'Not Set') . "\n";
echo "Use Mail: " . $config['cf_email_use'] . "\n";
echo "Admin Email: " . $config['cf_admin_email'] . "\n";

$to = 'test@example.com'; // Default test
if ($config['cf_admin_email']) {
    $to = $config['cf_admin_email'];
}

echo "Attempting to send to: " . $to . "\n";

try {
    $result = mailer($config['cf_admin_email_name'], $config['cf_admin_email'], $to, '[Test] Mail Check', 'If you see this, mail is working.', 1);
    if ($result) {
        echo "SUCCESS: Mail function returned true.\n";
    } else {
        echo "FAILURE: Mail function returned false.\n";
    }
} catch (Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
}
?>