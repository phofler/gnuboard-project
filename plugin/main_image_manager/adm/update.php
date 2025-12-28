<?php
$sub_menu = "800180";
include_once('./_common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');

check_demo();
auth_check_menu($auth, $sub_menu, 'w');
check_admin_token();

$style = $_POST['style'];
$count = count($_POST['mi_id']);
$upload_dir = G5_DATA_PATH . '/main_visual';

if (!is_dir($upload_dir)) {
    @mkdir($upload_dir, G5_DIR_PERMISSION);
    @chmod($upload_dir, G5_DIR_PERMISSION);
}

foreach ($_POST['mi_id'] as $i => $mi_id) {
    $title = isset($_POST['mi_title'][$i]) ? sql_real_escape_string($_POST['mi_title'][$i]) : '';
    $desc = isset($_POST['mi_desc'][$i]) ? sql_real_escape_string($_POST['mi_desc'][$i]) : '';
    $link = isset($_POST['mi_link'][$i]) ? sql_real_escape_string($_POST['mi_link'][$i]) : '';
    $target = isset($_POST['mi_target'][$i]) ? sql_real_escape_string($_POST['mi_target'][$i]) : '';

    $sql_common = " mi_title = '{$title}',
mi_desc = '{$desc}',
mi_link = '{$link}',
mi_target = '{$target}' ";

    // 이미지 삭제
    if (isset($_POST['mi_image_del'][$i]) && $_POST['mi_image_del'][$i]) {
        $sql = " select mi_image from g5_plugin_main_image_add where mi_id = '{$mi_id}' ";
        $row = sql_fetch($sql);
        if ($row['mi_image']) {
            @unlink($upload_dir . '/' . $row['mi_image']);
        }
        $sql_common .= " , mi_image = '' ";
    }

    // 이미지 처리 (파일 업로드 OR 외부 URL)
    $file_name = '';
    $mi_image_url = isset($_POST['mi_image_url'][$i]) ? trim($_POST['mi_image_url'][$i]) : '';

    // 1. 파일 업로드가 있는 경우
    if (isset($_FILES['mi_image']['name'][$i]) && $_FILES['mi_image']['name'][$i]) {
        $upload_file = $_FILES['mi_image']['tmp_name'][$i];
        $filename = $_FILES['mi_image']['name'][$i];
        $filename = preg_replace("/\.(php|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);
        $dest_file = $upload_dir . '/' . $mi_id . '_' . time() . '_' . $filename;

        if (move_uploaded_file($upload_file, $dest_file)) {
            chmod($dest_file, G5_FILE_PERMISSION);
            $file_name = basename($dest_file);

            // 기존 이미지 삭제 (로컬 파일인 경우만)
            $sql = " select mi_image from g5_plugin_main_image_add where mi_id = '{$mi_id}' ";
            $row = sql_fetch($sql);
            if ($row['mi_image'] && !preg_match("/^(http|https):/i", $row['mi_image'])) {
                @unlink($upload_dir . '/' . $row['mi_image']);
            }

            $sql_common .= " , mi_image = '{$file_name}' ";
        }
    }
    // 2. 파일 업로드는 없지만, Unsplash URL이 넘어온 경우
    else if ($mi_image_url) {
        // 기존 이미지 삭제 (로컬 파일인 경우만)
        $sql = " select mi_image from g5_plugin_main_image_add where mi_id = '{$mi_id}' ";
        $row = sql_fetch($sql);
        if ($row['mi_image'] && !preg_match("/^(http|https):/i", $row['mi_image'])) {
            @unlink($upload_dir . '/' . $row['mi_image']);
        }

        $sql_common .= " , mi_image = '{$mi_image_url}' ";
    }

    $sql = " update g5_plugin_main_image_add
set {$sql_common}
where mi_id = '" . sql_real_escape_string($mi_id) . "' ";
    sql_query($sql);
}

goto_url('./list.php?style=' . $style);
?>