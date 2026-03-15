<?php
$sub_menu = "950400";
include_once('./_common.php');
include_once('../lib/map.lib.php');
include_once('./check_db.php');

check_admin_token();

$ma_id = isset($_POST['ma_id']) ? clean_xss_tags($_POST['ma_id']) : '';

if (!$ma_id) {
    alert('식별코드가 없습니다.');
}

if ($w == '' || $w == 'u') {
    $ma_provider = isset($_POST['ma_provider']) ? clean_xss_tags($_POST['ma_provider']) : 'naver';
    $ma_lat = isset($_POST['ma_lat']) ? clean_xss_tags($_POST['ma_lat']) : '';
    $ma_lng = isset($_POST['ma_lng']) ? clean_xss_tags($_POST['ma_lng']) : '';
    $ma_api_key = isset($_POST['ma_api_key']) ? clean_xss_tags($_POST['ma_api_key']) : '';
    $ma_client_id = isset($_POST['ma_client_id']) ? clean_xss_tags($_POST['ma_client_id']) : '';

    $sql_common = " ma_provider = '{$ma_provider}',
                    ma_lat = '{$ma_lat}',
                    ma_lng = '{$ma_lng}',
                    ma_api_key = '{$ma_api_key}',
                    ma_client_id = '{$ma_client_id}' ";

    if ($w == '') {
        // Check duplicate
        $row = sql_fetch(" SELECT count(*) as cnt FROM {$table_name} WHERE ma_id = '{$ma_id}' ");
        if ($row['cnt']) {
            alert('이미 존재하는 식별코드입니다.');
        }

        $sql = " INSERT INTO {$table_name}
                    SET ma_id = '{$ma_id}',
                        {$sql_common},
                        ma_regdate = '" . G5_TIME_YMDHIS . "' ";
        sql_query($sql);
    } else if ($w == 'u') {
        $sql = " UPDATE {$table_name}
                    SET {$sql_common}
                    WHERE ma_id = '{$ma_id}' ";
        sql_query($sql);
    }
}

goto_url('./list.php');
?>