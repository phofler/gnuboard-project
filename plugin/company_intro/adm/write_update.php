<?php
include_once('./_common.php');
include_once(G5_LIB_PATH . '/image.lib.php');
// check_admin_token(); // [TEMP] Disabled for localhost session debugging

$co_id = isset($_POST['co_id']) ? clean_xss_tags($_POST['co_id']) : '';
$old_co_id = isset($_POST['old_co_id']) ? clean_xss_tags($_POST['old_co_id']) : '';
$co_theme = isset($_POST['co_theme']) ? clean_xss_tags($_POST['co_theme']) : '';
$co_lang = isset($_POST['co_lang']) ? clean_xss_tags($_POST['co_lang']) : 'kr';

// [ONE-TIME MIGRATION]
$check_col = sql_fetch(" SHOW COLUMNS FROM " . G5_TABLE_PREFIX . "plugin_company_add LIKE 'co_theme' ");
if (!$check_col) {
    sql_query(" ALTER TABLE " . G5_TABLE_PREFIX . "plugin_company_add ADD COLUMN co_theme VARCHAR(100) NOT NULL AFTER co_id ");
    sql_query(" ALTER TABLE " . G5_TABLE_PREFIX . "plugin_company_add ADD COLUMN co_lang VARCHAR(20) NOT NULL AFTER co_theme ");
}

// [NEW] Extend co_id column to 100 chars to prevent truncation
$res = sql_query(" SHOW COLUMNS FROM " . G5_TABLE_PREFIX . "plugin_company_add LIKE 'co_id' ");
$row = sql_fetch_array($res);
if ($row && strpos($row['Type'], 'varchar(20)') !== false) {
    sql_query(" ALTER TABLE " . G5_TABLE_PREFIX . "plugin_company_add MODIFY co_id VARCHAR(100) NOT NULL ");
}

if ($w == 'u' || $w == '') {
    if ($co_id == '')
        alert('코드가 없습니다.');
    if ($co_subject == '')
        alert('제목이 없습니다.');
    if ($co_content == '')
        alert('내용이 없습니다.');
}

$co_bgcolor = isset($_POST['co_bgcolor']) ? $_POST['co_bgcolor'] : '';

// [MIGRATION] Fix accidentally saved black backgrounds to theme default
// If it's pure black (#000000), we treat it as "unassigned" to follow Theme Sovereignty.
if ($co_bgcolor == '#000000') {
    $co_bgcolor = '';
}

// [NEW] 에디터 본문 내 외부 이미지 다운로드 및 로컬 치환
if ($co_content) {
    $upload_dir = G5_DATA_PATH . '/common_assets';
    if (!is_dir($upload_dir)) {
        @mkdir($upload_dir, G5_DIR_PERMISSION, true);
        @chmod($upload_dir, G5_DIR_PERMISSION);
    }

    // img 태그 추출
    preg_match_all("/<img[^>]*src=[\"']?([^>\"'\s]+)[\"']?[^>]*>/i", $co_content, $matches);
    if (isset($matches[1]) && is_array($matches[1])) {
        foreach ($matches[1] as $img_url) {
            // 외부 URL이고 내 서버의 데이터 URL이 아닌 경우
            if (preg_match("/^(http|https):/i", $img_url) && strpos($img_url, G5_DATA_URL) === false) {
                $downloaded_file = get_external_image($img_url, $upload_dir, 'ci_ext_');
                if ($downloaded_file) {
                    $local_url = G5_DATA_URL . '/common_assets/' . $downloaded_file;
                    $co_content = str_replace($img_url, $local_url, $co_content);
                }
            }
        }
    }
}

if ($w == '') {
    $sql = " select count(*) as cnt from " . G5_TABLE_PREFIX . "plugin_company_add where co_id = '{$co_id}' ";
    $row = sql_fetch($sql);
    if ($row['cnt'])
        alert("이미 존재하는 코드입니다.");

    $sql = " insert into " . G5_TABLE_PREFIX . "plugin_company_add
                set co_id = '{$co_id}',
                    co_theme = '{$co_theme}',
                    co_lang = '{$co_lang}',
                    co_subject = '{$co_subject}',
                    co_content = '{$co_content}',
                    co_skin = '{$co_skin}',
                    co_bgcolor = '{$co_bgcolor}',
                    co_datetime = '" . G5_TIME_YMDHIS . "' ";
    sql_query($sql);
} else if ($w == 'u') {
    $sql = " update " . G5_TABLE_PREFIX . "plugin_company_add
                set co_id = '{$co_id}',
                    co_theme = '{$co_theme}',
                    co_lang = '{$co_lang}',
                    co_subject = '{$co_subject}',
                    co_content = '{$co_content}',
                    co_skin = '{$co_skin}',
                    co_bgcolor = '{$co_bgcolor}',
                    co_datetime = '" . G5_TIME_YMDHIS . "' 
                where co_id = '{$old_co_id}' ";
    sql_query($sql);
}

goto_url('./write.php?w=u&co_id=' . $co_id);
?>