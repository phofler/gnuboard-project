<?php
include_once('./_common.php');

if (!$is_admin) {
    die(json_encode(array('error' => '권한이 없습니다.')));
}

$upload_dir = G5_DATA_PATH . '/main_visual/';
$upload_url = G5_DATA_URL . '/main_visual/';

$images = array();

if (is_dir($upload_dir)) {
    $files = scandir($upload_dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..')
            continue;

        $file_path = $upload_dir . $file;
        $file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'webp');

        if (is_file($file_path) && in_array($file_ext, $allowed_ext)) {
            $images[] = array(
                'name' => $file,
                'url' => $upload_url . $file,
                'time' => filemtime($file_path)
            );
        }
    }
}

usort($images, function ($a, $b) {
    return $b['time'] - $a['time'];
});

echo json_encode(array('images' => $images));
?>