<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * 외부 이미지를 다운로드하여 서버에 저장
 * @param string $url 외부 이미지 URL
 * @param string $path 저장할 물리 경로 (G5_DATA_PATH . '/...')
 * @param string $prefix 파일명 접두사 (기본: ext_)
 * @return string|false 저장된 파일명 또는 실패 시 false
 */
function get_external_image($url, $path, $prefix = 'ext_')
{
    if (!$url || !preg_match("/^(http|https):/i", $url))
        return false;

    // 외부 URL이 현재 내 서버의 데이터 URL인 경우 다운로드 생략
    if (strpos($url, G5_DATA_URL) !== false) {
        return basename($url);
    }

    // 디렉토리 확인 및 생성
    if (!is_dir($path)) {
        @mkdir($path, G5_DIR_PERMISSION, true);
        @chmod($path, G5_DIR_PERMISSION);
    }

    // 확장자 추출 및 정규화
    $url_path = parse_url($url, PHP_URL_PATH);
    $ext = pathinfo($url_path, PATHINFO_EXTENSION);
    if (!$ext || strlen($ext) > 4) {
        // 확장자가 없거나 너무 길면 Unsplash 등 파라미터형 URL일 가능성 높음
        // 기본적으로 jpg로 처리하거나 mime type 체크가 정석이나 성능상 jpg fallback
        $ext = 'jpg';
    }

    // 파일명 생성 (중복 방지 및 식별성)
    $filename = $prefix . time() . '_' . substr(md5($url), 0, 8) . '.' . $ext;
    $dest_file = $path . '/' . $filename;

    // 다운로드 (cURL 사용)
    $ch = curl_init($url);
    $fp = fopen($dest_file, 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20); // 타임아웃 20초
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // SSL 인증서 무시 (로컬/호환성)
    $result = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    fclose($fp);

    if ($result && $http_code == 200 && filesize($dest_file) > 0) {
        @chmod($dest_file, G5_FILE_PERMISSION);
        return $filename;
    } else {
        if (file_exists($dest_file)) {
            @unlink($dest_file); // 실패 시 생성된 빈 파일 또는 잘못된 파일 삭제
        }
        return false;
    }
}
