<?php
$sub_menu = "800180";
include_once('./_common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');

check_demo();
auth_check_menu($auth, $sub_menu, 'w');
// check_admin_token(); // CSRF 확인이 필요한 경우 활성화

$style = $_POST['style'];
$upload_dir = G5_DATA_PATH . '/main_content';

// 이미지 업로드 디렉토리 확인
if (!is_dir($upload_dir)) {
    @mkdir($upload_dir, G5_DIR_PERMISSION);
    @chmod($upload_dir, G5_DIR_PERMISSION);
}

foreach ($_POST['mc_id'] as $mi_id => $val) {
    $title = isset($_POST['mc_title'][$mi_id]) ? sql_real_escape_string($_POST['mc_title'][$mi_id]) : '';
    $desc = isset($_POST['mc_desc'][$mi_id]) ? sql_real_escape_string($_POST['mc_desc'][$mi_id]) : '';
    $link = isset($_POST['mc_link'][$mi_id]) ? sql_real_escape_string($_POST['mc_link'][$mi_id]) : '';
    $target = isset($_POST['mc_target'][$mi_id]) ? sql_real_escape_string($_POST['mc_target'][$mi_id]) : '';

    $sql_common = " mc_title = '{$title}',
                    mc_desc = '{$desc}',
                    mc_link = '{$link}',
                    mc_target = '{$target}' ";

    // 이미지 삭제
    if (isset($_POST['mc_image_del'][$mi_id]) && $_POST['mc_image_del'][$mi_id]) {
        $sql = " select mc_image from g5_plugin_main_content where mc_id = '{$mi_id}' ";
        $row = sql_fetch($sql);
        if ($row['mc_image'] && !preg_match("/^(http|https):/i", $row['mc_image'])) {
            @unlink($upload_dir . '/' . $row['mc_image']);
        }
        $sql_common .= " , mc_image = '' ";
    }

    // 이미지 처리
    $mc_image_url = isset($_POST['mc_image_url'][$mi_id]) ? trim($_POST['mc_image_url'][$mi_id]) : '';

    if (isset($_FILES['mc_image']['name'][$mi_id]) && $_FILES['mc_image']['name'][$mi_id]) {
        $upload_file = $_FILES['mc_image']['tmp_name'][$mi_id];
        $filename = $_FILES['mc_image']['name'][$mi_id];
        $filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);
        $dest_file = $upload_dir . '/' . $mi_id . '_' . time() . '_' . $filename;

        if (move_uploaded_file($upload_file, $dest_file)) {
            chmod($dest_file, G5_FILE_PERMISSION);
            $file_name = basename($dest_file);

            $sql = " select mc_image from g5_plugin_main_content where mc_id = '{$mi_id}' ";
            $row = sql_fetch($sql);
            if ($row['mc_image'] && !preg_match("/^(http|https):/i", $row['mc_image'])) {
                @unlink($upload_dir . '/' . $row['mc_image']);
            }
            $sql_common .= " , mc_image = '{$file_name}' ";
        }
    } else if ($mc_image_url) {
        $sql = " select mc_image from g5_plugin_main_content where mc_id = '{$mi_id}' ";
        $row = sql_fetch($sql);
        if ($row['mc_image'] && !preg_match("/^(http|https):/i", $row['mc_image'])) {
            @unlink($upload_dir . '/' . $row['mc_image']);
        }
        $sql_common .= " , mc_image = '{$mc_image_url}' ";
    }

    $sql = " update g5_plugin_main_content set {$sql_common} where mc_id = '{$mi_id}' ";
    sql_query($sql);
}

goto_url('./list.php?style=' . $style);
?>