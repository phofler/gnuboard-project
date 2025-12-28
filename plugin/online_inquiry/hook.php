<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * 플러그인 훅 파일 (hook.php)
 * - 이 파일이 로드될 때 설치가 안 되어 있으면 설치 스크립트를 실행합니다.
 * - 각종 이벤트 훅을 정의합니다.
 */

// 공통 설정 로드 (상수 정의 등)
include_once(dirname(__FILE__) . '/_common.php');

// 1. 자동 설치 체크
$install_chk_file = G5_DATA_PATH . '/online_inquiry_installed.php';
if (!file_exists($install_chk_file)) {
    // 설치 파일 로드 및 실행
    include_once(G5_PLUGIN_PATH . '/online_inquiry/install.php');

    // 설치 완료 플래그 생성 (매번 쿼리 실행 방지)
    $fp = fopen($install_chk_file, 'w');
    fwrite($fp, '<?php // Online Inquiry Installed ?>');
    fclose($fp);
}

// 2. 메일 발송 훅 (기존 extend 로직 이식)
// 'online_inquiry_send_email' 이라는 커스텀 이벤트를 정의해서 사용합니다.
// action/write_update.php 에서 이 이벤트를 호출할 예정입니다.
add_event('online_inquiry_send_email', 'online_inquiry_send_email_func', 10, 2);

function online_inquiry_send_email_func($id, $data)
{
    global $config;

    // 관리자 메일 주소
    $admin_email = $config['cf_admin_email'];
    $admin_name = $config['cf_admin_email_name'];

    // 보내는 사람 (이메일 없으면 phofler@gmail.com)
    $from_email = $data['email'] ? $data['email'] : 'phofler@gmail.com';
    $from_name = $data['name'];

    // 제목: 성함 + " 문의립니다."
    $subject = $from_name . " 문의드립니다.";

    // 내용: 깔끔한 테이블 스타일
    $content = '
    <div style="margin:20px; padding:20px; border:1px solid #ddd; background-color:#f9f9f9; font-family: sans-serif;">
        <h2 style="color:#333; border-bottom:2px solid #333; padding-bottom:10px; margin-bottom:20px;">Online Inquiry</h2>
        <table style="width:100%; border-collapse:collapse; background-color:#fff; border:1px solid #eee;">
            <colgroup>
                <col style="width:150px; background-color:#f4f4f4;">
                <col>
            </colgroup>
            <tbody>
                <tr>
                    <th style="padding:15px; border-bottom:1px solid #eee; text-align:left; color:#555;">Name (성함)</th>
                    <td style="padding:15px; border-bottom:1px solid #eee; color:#333;">' . $from_name . '</td>
                </tr>
                <tr>
                    <th style="padding:15px; border-bottom:1px solid #eee; text-align:left; color:#555;">Contact Number (연락처)</th>
                    <td style="padding:15px; border-bottom:1px solid #eee; color:#333;">' . $data['contact'] . '</td>
                </tr>
                <tr>
                    <th style="padding:15px; text-align:left; color:#555; vertical-align:top;">Message (문의내용)</th>
                    <td style="padding:15px; color:#333; line-height:1.6;">' . nl2br($data['content']) . '</td>
                </tr>
            </tbody>
        </table>
        <div style="margin-top:20px; font-size:12px; color:#999; text-align:center;">
            본 메일은 웹사이트에서 발송되었습니다.
        </div>
    </div>';

    // 메일 발송
    include_once(G5_LIB_PATH . '/mailer.lib.php');
    mailer($from_name, $from_email, $admin_email, $subject, $content, 1);
}

// 3. 관리자 메뉴 등록 훅 (admin_menu)
// admin.lib.php에서 메뉴 초기화($menu = ...) 후 실행되므로 안전하게 추가 가능
add_replace('admin_menu', 'online_inquiry_admin_menu_hook');

function online_inquiry_admin_menu_hook($menu)
{
    // 게시판관리(menu300) 제일 뒤에 추가
    $menu['menu300'][] = array(
        '300910',
        '온라인 문의 플러그인',
        G5_PLUGIN_URL . '/online_inquiry/adm/list.php',
        'online_inquiry'
    );

    return $menu;
}
?>