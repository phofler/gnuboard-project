<?php
if (!defined('_GNUBOARD_'))
    exit;

// Setting for Gmail SMTP
// Prefixing with G_ to avoid conflict if G5_SMTP is already defined in config.php
define('G_SMTP_HOST', 'smtp.gmail.com');
define('G_SMTP_PORT', '587');
define('G_SMTP_USER', 'phofler@gmail.com'); // User email
define('G_SMTP_PW', 'qsrk rdby bwxm hzxp');   // App Password
define('G_SMTP_SECURE', 'tls');

add_replace('mail_options', 'smtp_mail_options', 1, 10);

function smtp_mail_options($mail, $fname, $fmail, $to, $subject, $content, $type, $file, $cc, $bcc)
{
    // Force apply Gmail SMTP settings
    $mail->IsSMTP();
    $mail->Host = G_SMTP_HOST;
    $mail->Port = G_SMTP_PORT;
    $mail->SMTPAuth = true;
    $mail->Username = G_SMTP_USER;
    $mail->Password = G_SMTP_PW;
    $mail->SMTPSecure = G_SMTP_SECURE;

    return $mail;
}
?>