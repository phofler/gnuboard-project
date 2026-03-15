<?php
include_once('./_common.php');

// [관리자 권한 확인]
if (!$is_admin) {
    alert('관리자만 접근 가능합니다.');
}

// [1] 파일 업로드 처리
if (isset($_FILES['csv_file']) && $_FILES['csv_file']['tmp_name']) {
    $file = $_FILES['csv_file']['tmp_name'];

    // [2] 파일 열기
    $handle = fopen($file, "r");

    $success_count = 0;
    $fail_count = 0;

    // [3] 한 줄씩 읽기
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        // 첫 줄이 제목줄인 경우 건너뛰기 로직 필요 시 추가
        // if ($data[0] == '아이디') continue;

        $mb_id = trim($data[0]);
        $mb_name = trim($data[1]);

        if (!$mb_id)
            continue;

        // [4] DB 입력 (예시)
        // 실제로는 insert_member() 함수 등을 활용하거나 직접 쿼리 작성
        /*
        $sql = " insert into ... set mb_id = '$mb_id', mb_name = '$mb_name' ... ";
        sql_query($sql);
        */

        $success_count++;
    }

    fclose($handle);
    alert($success_count . "건 처리되었습니다.");
}
?>

<!-- 엑셀(CSV) 업로드 폼 -->
<form method="post" enctype="multipart/form-data">
    내파일 선택: <input type="file" name="csv_file" required>
    <button type="submit">업로드 및 DB 저장</button>
</form>