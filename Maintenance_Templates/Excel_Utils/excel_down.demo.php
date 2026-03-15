<?php
include_once('./_common.php');

// [관리자 권한 확인]
if (!$is_admin) {
    alert('관리자만 접근 가능합니다.');
}

// [1] 다운로드할 파일명 설정
$filename = 'member_list_' . date('Ymd') . '.csv';

// [2] 헤더 설정 (한글 깨짐 방지: BOM 추가)
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
echo "\xEF\xBB\xBF"; // UTF-8 BOM

// [3] CSV 출력
$output = fopen('php://output', 'w');

// [4] 제목줄(Column) 추가
fputcsv($output, array('아이디', '이름', '닉네임', '이메일', '가입일'));

// [5] DB 데이터 조회 및 출력
// 예시: 회원 100명 추출
$sql = " select mb_id, mb_name, mb_nick, mb_email, mb_datetime from {$g5['member_table']} order by mb_datetime desc limit 100 ";
$result = sql_query($sql);

while ($row = sql_fetch_array($result)) {
    // 필요한 데이터 가공
    $row_data = array(
        $row['mb_id'],
        $row['mb_name'],
        $row['mb_nick'],
        $row['mb_email'],
        $row['mb_datetime']
    );
    fputcsv($output, $row_data);
}

fclose($output);
exit;
?>