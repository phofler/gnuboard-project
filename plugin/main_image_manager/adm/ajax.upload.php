<?php
include_once('./_common.php');

if (!$is_admin) {
    die(json_encode(array('error' => '권한이 없습니다.')));
}

$upload_dir = G5_DATA_PATH . '/main_visual/';
$upload_url = G5_DATA_URL . '/main_visual/';

if (!is_dir($upload_dir)) {
    @mkdir($upload_dir, G5_DIR_PERMISSION, true);
    @chmod($upload_dir, G5_DIR_PERMISSION);
}

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'webp');

    if (!in_array($file_ext, $allowed_ext)) {
        die(json_encode(array('error' => '허용되지 않는 파일 형식입니다. (jpg, png, gif, webp only)')));
    }

    $new_name = 'mv_' . time() . '_' . rand(1000, 9999) . '.' . $file_ext;
    $dest_path = $upload_dir . $new_name;

    if (move_uploaded_file($file_tmp, $dest_path)) {
        @chmod($dest_path, G5_FILE_PERMISSION);

        echo json_encode(array(
            'success' => true,
            'url' => $upload_url . $new_name,
            'filename' => $new_name
        ));
    } else {
        echo json_encode(array('error' => '파일 업로드에 실패했습니다.'));
    }
} else {
    echo json_encode(array('error' => '파일이 전송되지 않았거나 오류가 발생했습니다.'));
}
?>