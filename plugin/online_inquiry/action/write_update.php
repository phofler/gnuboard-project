<?php
include_once(dirname(__FILE__) . '/../_common.php');

// 토큰 검사 (CSRF 방지)
check_demo();
// check_token(); // 필요시 활성화

// 데이터 검증
$name = isset($_POST['name']) ? clean_xss_tags($_POST['name'], 1, 1) : '';
$contact = isset($_POST['contact']) ? clean_xss_tags($_POST['contact'], 1, 1) : '';
$email = isset($_POST['email']) ? clean_xss_tags($_POST['email'], 1, 1) : '';
$subject = isset($_POST['subject']) ? clean_xss_tags($_POST['subject'], 1, 1) : '';
$content = isset($_POST['content']) ? strip_tags($_POST['content']) : '';
$content = addslashes($content); // Escape for SQL
// Ensure other fields are safe too if clean_xss_tags doesn't escape
$name = addslashes($name);
$contact = addslashes($contact);
$email = addslashes($email);
$subject = addslashes($subject);

$theme = isset($_POST['theme']) ? clean_xss_tags($_POST['theme'], 1, 1) : '';
$lang = isset($_POST['lang']) ? clean_xss_tags($_POST['lang'], 1, 1) : '';
$theme = addslashes($theme);
$lang = addslashes($lang);

if (!$name || !$contact || !$subject || !$content) {
    alert('필수 입력값이 누락되었습니다.');
}

// DB 테이블
$write_table = G5_PLUGIN_ONLINE_INQUIRY_TABLE;

// 데이터 저장
$sql = " insert into {$write_table}
            set name = '{$name}',
                contact = '{$contact}',
                email = '{$email}',
                subject = '{$subject}',
                content = '{$content}',
                ip = '{$_SERVER['REMOTE_ADDR']}',
                reg_date = '" . G5_TIME_YMDHIS . "',
                state = '접수',
                theme = '{$theme}',
                lang = '{$lang}' ";
sql_query($sql);

$wr_id = sql_insert_id();

// 메일 발송 이벤트 트리거
if ($wr_id) {
    // 훅에 전달할 데이터 구성
    $hook_data = array(
        'name' => $name,
        'contact' => $contact,
        'email' => $email,
        'subject' => $subject,
        'content' => $content
    );

    // hook.php에 정의된 이벤트 호출
    run_event('online_inquiry_send_email', $wr_id, $hook_data);

    // alert 함수 호출 전 CWD 변경 (bbs/alert.php 경로 문제 해결)
    chdir(G5_PATH);
    alert('문의가 성공적으로 접수되었습니다.', G5_URL);
} else {
    // alert 함수 호출 전 CWD 변경 (bbs/alert.php 경로 문제 해결)
    chdir(G5_PATH);
    alert('문의 접수에 실패했습니다.');
}
?>