<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가

// 게시글 작성 후 실행되는 훅 (bbs/write_update.php 에서 5개의 인자를 전달함)
add_event('write_update_after', 'online7_write_email_notification', 10, 5);

function online7_write_email_notification($board, $wr_id, $w, $qstr, $redirect_url)
{
    global $config, $g5;

    // 모든 게시판에서 새글 작성 시 메일 발송이 되도록 처리합니다.
    // [CUSTOM FIX] Exclude 'chamcode_gallery' unless explicitly mapped
    // Or check if 'mail' checkbox was checked (but wr_option usually not verified here).
    // Safest: Block chamcode_gallery from this hook entirely.
    // [CUSTOM FIX] Whitelist Mode: Only send emails for specific boards
    // 'online' 등 실제 온라인 문의 게시판 ID를 여기에 추가하세요.
    $allowed_boards = array('online', 'inquiry', 'qa', 'online7');

    if (!in_array($board['bo_table'], $allowed_boards)) {
        return; // 허용된 게시판이 아니면 즉시 종료
    }

    /*
    $target_boards = array('online7', 'news');
    if (!in_array($board['bo_table'], $target_boards)) {
        return;
    }
    */

    // 답글 수정 등이 아닌 새글 작성일 때만 발송하려면 $w == '' 체크 (필요시)
    if ($w !== '') {
        return;
    }

    // 게시글 정보 가져오기
    $write_table = $g5['write_prefix'] . $board['bo_table'];
    $wr = get_write($write_table, $wr_id);
    if (!$wr['wr_id']) {
        return;
    }

    // 관리자 메일 주소
    $admin_email = $config['cf_admin_email'];
    $admin_name = $config['cf_admin_email_name'];

    // 보내는 사람 (작성자)
    $from_email = $wr['wr_email'];
    $from_name = $wr['wr_name'];

    // 이메일 주소가 없으면 관리자 이메일로 대체 (오류 방지)
    if (!$from_email)
        $from_email = $admin_email;

    // 제목
    $subject = '[' . $board['bo_subject'] . '] ' . $wr['wr_subject'] . ' - 새 문의가 접수되었습니다.';

    // 내용
    $content = '';
    $content .= '<h2>' . $board['bo_subject'] . ' 문의 접수</h2>';
    $content .= '<p><strong>작성자:</strong> ' . $from_name . '</p>';
    if ($wr['wr_email'])
        $content .= '<p><strong>이메일:</strong> ' . $wr['wr_email'] . '</p>';
    // 연락처 필드가 wr_1 등으로 사용된다면 추가
    // $content .= '<p><strong>연락처:</strong> ' . $wr['wr_1'] . '</p>'; 
    $content .= '<hr>';
    $content .= '<div>' . conv_content($wr['wr_content'], 1) . '</div>';
    $content .= '<hr>';
    $content .= '<p><a href="' . G5_BBS_URL . '/board.php?bo_table=' . $board['bo_table'] . '&wr_id=' . $wr_id . '" target="_blank">게시물 바로가기</a></p>';

    // 메일 발송
    include_once(G5_LIB_PATH . '/mailer.lib.php');
    mailer($from_name, $from_email, $admin_email, $subject, $content, 1);
}
?>