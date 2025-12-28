<?php
include_once('./_common.php');
check_admin_token();


if ($w == 'u' || $w == '') {
    if ($co_id == '')
        alert('코드가 없습니다.');
    if ($co_subject == '')
        alert('제목이 없습니다.');
    if ($co_content == '')
        alert('내용이 없습니다.');
}

$co_bgcolor = isset($_POST['co_bgcolor']) ? $_POST['co_bgcolor'] : '#000000';

if ($w == '') {
    $sql = " select count(*) as cnt from " . G5_TABLE_PREFIX . "plugin_company_add where co_id = '{$co_id}' ";
    $row = sql_fetch($sql);
    if ($row['cnt'])
        alert("이미 존재하는 코드입니다.");

    $sql = " insert into " . G5_TABLE_PREFIX . "plugin_company_add
                set co_id = '{$co_id}',
                    co_subject = '{$co_subject}',
                    co_content = '{$co_content}',
                    co_skin = '{$co_skin}',
                    co_bgcolor = '{$co_bgcolor}',
                    co_datetime = '" . G5_TIME_YMDHIS . "' ";
    sql_query($sql);
} else if ($w == 'u') {
    $sql = " update " . G5_TABLE_PREFIX . "plugin_company_add
                set co_subject = '{$co_subject}',
                    co_content = '{$co_content}',
                    co_skin = '{$co_skin}',
                    co_bgcolor = '{$co_bgcolor}',
                    co_datetime = '" . G5_TIME_YMDHIS . "' 
                where co_id = '{$co_id}' ";
    sql_query($sql);
}

goto_url('./write.php?w=u&co_id=' . $co_id);
?>