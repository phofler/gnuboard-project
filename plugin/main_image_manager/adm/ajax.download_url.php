<?php
include_once('./_common.php');
include_once(G5_LIB_PATH . '/image.lib.php');

if (!$is_admin) {
    die(json_encode(array('error' => '권한이 없습니다.')));
}

$url = isset($_POST['url']) ? clean_xss_tags($_POST['url']) : '';
if (!$url) {
    die(json_encode(array('error' => 'URL이 없습니다.')));
}

$upload_dir = G5_DATA_PATH . '/main_visual/';
$upload_url = G5_DATA_URL . '/main_visual/';

if (!is_dir($upload_dir)) {
    @mkdir($upload_dir, G5_DIR_PERMISSION, true);
    @chmod($upload_dir, G5_DIR_PERMISSION);
}

// Download external image to library
$downloaded_file = get_external_image($url, $upload_dir, 'mv_lib_');

if ($downloaded_file) {
    echo json_encode(array(
        'success' => true,
        'url' => $upload_url . $downloaded_file,
        'filename' => $downloaded_file
    ));
} else {
    echo json_encode(array('error' => '이미지를 라이브러리에 저장하는데 실패했습니다.'));
}
?>