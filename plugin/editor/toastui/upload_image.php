<?php
include_once("./_common.php");

// Check permissions (admin or member level)
if (!$is_member && !$is_admin) {
    echo json_encode(['error' => '권한이 없습니다.']);
    exit;
}

$data_dir = G5_DATA_PATH . '/editor';
$data_url = G5_DATA_URL . '/editor';

if (!is_dir($data_dir)) {
    @mkdir($data_dir, G5_DIR_PERMISSION);
    @chmod($data_dir, G5_DIR_PERMISSION);
}

$ym = date('ym', G5_SERVER_TIME);
$dir = $data_dir . '/' . $ym;
$url = $data_url . '/' . $ym;

if (!is_dir($dir)) {
    @mkdir($dir, G5_DIR_PERMISSION);
    @chmod($dir, G5_DIR_PERMISSION);
}

if (isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
    $file = $_FILES['image'];

    // Validation
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
        echo json_encode(['error' => '허용되지 않는 파일 형식입니다.']);
        exit;
    }

    // Generate unique name
    $filename = time() . '_' . sprintf('%04d', rand(0, 9999)) . '.' . $ext;
    $dest_path = $dir . '/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $dest_path)) {
        @chmod($dest_path, G5_FILE_PERMISSION);
        echo json_encode(['imageUrl' => $url . '/' . $filename]);
    } else {
        echo json_encode(['error' => '파일 저장 실패']);
    }
} else {
    echo json_encode(['error' => '파일이 전송되지 않았습니다.']);
}
?>