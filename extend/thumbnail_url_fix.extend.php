<?php
if (!defined('_GNUBOARD_'))
    exit;

/**
 * get_view_thumbnail 결과물에서 도메인을 자동으로 제거/치환하는 훅
 * 웹에디터(Cheditor 등)에서 저장된 절대경로(http://localhost 등)를 상대경로로 변경하여
 * 모바일이나 다른 기기에서 이미지가 깨지는 현상을 방지합니다.
 */
add_replace('get_view_thumbnail', 'custom_thumbnail_url_fix', 10, 1);

function custom_thumbnail_url_fix($content)
{
    // 1. config.php의 G5_URL(현재 접속 주소) 활용
    // 2. 추가로 제거하고 싶은 수동 도메인 목록 (변수화)
    $legacy_domains = array(
        G5_URL, // 현재 접속한 주소 (도메인 또는 localhost)
        'http://localhost',
        'https://localhost',
        'http://www.xn--6j1b64bvyvn2dt2ade339aq6r.com',
        'http://xn--6j1b64bvyvn2dt2ade339aq6r.com'
    );

    // 중복 제거 및 유효한 값만 정리
    $legacy_domains = array_unique(array_filter($legacy_domains));

    // 절대경로를 빈값으로 치환하여 /data/editor/... 형태의 상대경로로 유도
    return str_replace($legacy_domains, '', $content);
}
