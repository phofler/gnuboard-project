<?php
include_once('./_common.php');

if (!$is_admin) {
    die(json_encode(array('error' => '권한이 없습니다.')));
}

$upload_dir = G5_DATA_PATH . '/common_assets/';
$upload_url = G5_DATA_URL . '/common_assets/';

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

// Sort by newest first
usort($images, function ($a, $b) {
    return $b['time'] - $a['time'];
});

// Calculate total size
$total_size = 0;
if (is_dir($upload_dir)) {
    $files = scandir($upload_dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..')
            continue;
        $file_path = $upload_dir . $file;
        if (is_file($file_path)) {
            $total_size += filesize($file_path);
        }
    }
}

// Format size
function format_byte_size($bytes)
{
    if ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 1) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}

echo json_encode(array(
    'images' => $images,
    'total_size' => format_byte_size($total_size)
));
?>