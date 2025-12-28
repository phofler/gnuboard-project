<?php
// Include common configuration
include_once('./_common.php');

// Include mailer library
include_once(G5_LIB_PATH . '/mailer.lib.php');

// Check if it is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    alert('잘못된 접근입니다.', G5_THEME_URL);
}

// Get form data
$name = isset($_POST['name']) ? clean_xss_tags($_POST['name']) : '';
$contact = isset($_POST['contact']) ? clean_xss_tags($_POST['contact']) : '';
$message = isset($_POST['message']) ? clean_xss_tags($_POST['message']) : '';

// Validation
if (!$name || !$contact || !$message) {
    alert('모든 항목을 입력해 주세요.');
}

// Helper to get client IP
$ip = $_SERVER['REMOTE_ADDR'];

// --- 1. Save to Board (online) ---
$bo_table = 'online';
$write_table = $g5['write_prefix'] . $bo_table;

// Ensure tables exist (Fallback if setup script wasn't run, though we assume it was)
if (isset($g5['write_prefix'])) {
    // Get Request Board ID
    $row = sql_fetch(" select max(wr_num) as max_wr_num from {$write_table} ");
    $wr_num = $row['max_wr_num'] - 1;

    $user_id = $member['mb_id'] ? $member['mb_id'] : 'guest';
    $password = ''; // Guest password? Not set in form. Default to random or empty if allowed.
// If guest, password is usually required. We'll set a default random string for security if not provided.
    if (!$member['mb_id'])
        $password = sql_password(uniqid());

    $wr_subject = "{$name}님의 온라인 문의입니다.";
    $wr_content = $message . "\n\n연락처: " . $contact;

    $sql = " insert into {$write_table}
set wr_num = '{$wr_num}',
wr_reply = '',
wr_parent = '0',
wr_is_comment = 0,
wr_comment = 0,
wr_comment_reply = '',
ca_name = '',
wr_option = 'html1',
wr_subject = '{$wr_subject}',
wr_content = '{$wr_content}',
wr_link1 = '',
wr_link2 = '',
wr_link1_hit = 0,
wr_link2_hit = 0,
wr_hit = 0,
wr_good = 0,
wr_nogood = 0,
mb_id = '{$user_id}',
wr_password = '{$password}',
wr_name = '{$name}',
wr_email = '',
wr_homepage = '',
wr_datetime = '" . G5_TIME_YMDHIS . "',
wr_file = 0,
wr_last = '" . G5_TIME_YMDHIS . "',
wr_ip = '{$ip}',
wr_1 = '{$contact}', /* Store contact in extra field 1 */
wr_2 = '',
wr_3 = '',
wr_4 = '',
wr_5 = '',
wr_6 = '',
wr_7 = '',
wr_8 = '',
wr_9 = '',
wr_10 = ''
";
    sql_query($sql);
    $wr_id = sql_insert_id();

    // Update parent
    sql_query(" update {$write_table} set wr_parent = '{$wr_id}' where wr_id = '{$wr_id}' ");

    // Update board count
    sql_query(" update {$g5['board_table']} set bo_count_write = bo_count_write + 1 where bo_table = '{$bo_table}' ");
}

// --- 2. Send Email ---

// Email Subject
$subject = "[{$config['cf_title']}] 온라인 문의가 접수되었습니다.";

// Email Content
$content = "
<h2>온라인 문의 접수 내역</h2>
<hr>
<ul>
    <li><strong>이름:</strong> {$name}</li>
    <li><strong>연락처:</strong> {$contact}</li>
    <li><strong>접수일시:</strong> " . G5_TIME_YMDHIS . "</li>
    <li><strong>접수 IP:</strong> {$ip}</li>
</ul>
<hr>
<h3>문의내용</h3>
<p>" . nl2br($message) . "</p>
";

// Admin Email
$admin_email = $config['cf_admin_email'];

// Send Email
// Using user's name as sender name, and admin email as sender email to prevent spam blocking
$from_email = $config['cf_admin_email'];
$from_name = $name;

mailer($from_name, $from_email, $admin_email, $subject, $content, 1);

// Alert and Redirect
alert('문의가 성공적으로 접수되었습니다. 빠른 시일 내에 답변 드리겠습니다.', G5_URL);
?>