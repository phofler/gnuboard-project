<?php
include_once('./_common.php');

$co_id = isset($_POST['co_id']) ? trim($_POST['co_id']) : '';

if (!$co_id) {
    echo json_encode(['count' => 0, 'msg' => '코드를 입력해주세요.']);
    exit;
}

// 영문자, 숫자, _ 만 허용
if (!preg_match("/^[a-zA-Z0-9_]+$/", $co_id)) {
    echo json_encode(['count' => 1, 'msg' => '영문자, 숫자, _ 만 입력 가능합니다.']);
    exit;
}

// 1. 플러그인 테이블 체크
$sql = " select count(*) as cnt from " . G5_TABLE_PREFIX . "plugin_company_add where co_id = '{$co_id}' ";
$row = sql_fetch($sql);
$cnt = $row['cnt'];

// 2. 기본 내용(content) 테이블 체크 (URL 충돌 방지)
if (defined('G5_TABLE_PREFIX')) {
    $sql2 = " select count(*) as cnt from " . G5_TABLE_PREFIX . "content where co_id = '{$co_id}' ";
    $row2 = sql_fetch($sql2);
    $cnt += $row2['cnt'];
}

if ($cnt > 0) {
    echo json_encode(['count' => 1, 'msg' => '이미 사용 중인 코드입니다.']);
} else {
    echo json_encode(['count' => 0, 'msg' => '사용 가능한 코드입니다.']);
}
?>