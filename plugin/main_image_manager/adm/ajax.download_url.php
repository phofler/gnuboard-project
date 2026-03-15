<?php
include_once('./_common.php');
include_once(G5_LIB_PATH . '/image.lib.php');

if (!$is_admin) {
    die(json_encode(array('error' => '沅뚰븳???놁뒿?덈떎.')));
}

$url = isset($_POST['url']) ? clean_xss_tags($_POST['url']) : '';
if (!$url) {
    die(json_encode(array('error' => 'URL???놁뒿?덈떎.')));
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
    echo json_encode(array('error' => '?대?吏瑜??쇱씠釉뚮윭由ъ뿉 ??ν븯?붾뜲 ?ㅽ뙣?덉뒿?덈떎.'));
}
?>
