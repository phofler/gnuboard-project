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
$bo_table = 'online7';
$write_table = $g5['write_prefix'] . $bo_table;

// Ensure tables exist (Fallback if setup script wasn't run, though we assume it was)
if (isset($g5['write_prefix'])) {
    // Get Request Board ID
    $row = sql_fetch(" select max(wr_num) as max_wr_num from {$write_table} ");
    $max_wr_num = (isset($row['max_wr_num']) && $row['max_wr_num']) ? (int) $row['max_wr_num'] : 0;
    $wr_num = $max_wr_num - 1;

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

    // --- 2. Send Email (via Hook) ---
    // Trigger the 'write_update_after' event so that extend/online_mail_hook.extend.php can pick it up.
    // Argument signature: $board, $wr_id, $w, $qstr, $redirect_url, $file_upload_msg
    if ($wr_id) {
        $board = sql_fetch(" select * from {$g5['board_table']} where bo_table = '{$bo_table}' ");
        // Ensure write_table key exists for the hook
        $board['write_table'] = $write_table;
        run_event('write_update_after', $board, $wr_id, '', '', '', '');
    } else {
        alert('문의 접수에 실패했습니다. 잠시 후 다시 시도해 주세요.');
    }
}

// Alert and Redirect
alert('문의가 성공적으로 접수되었습니다. 빠른 시일 내에 답변 드리겠습니다.', G5_URL);
?>