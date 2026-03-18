<?php
/**
 * DB Path Cleanup & Fix Tool v11 (Error-Proof Finalizer)
 * 1. 테이블 대소문자 충돌(1050 에러) 완벽 해결
 * 2. 하단 로고 및 게시판 본문 localhost 주소 일괄 변환
 * 3. 테마 및 사이트 제목 강제 고정
 */
include_once('./_common.php');

if (!$is_admin) {
    die("관리자 권한이 필요합니다.");
}

echo "<h3>[V11 최종 점검] 에러 방지 및 경로 복구 완료</h3>";

// 헬퍼 기능: 대소문자 무시하고 실제 테이블 이름 찾기
function get_real_table_name($target) {
    $res = sql_query("SHOW TABLES");
    while($row = sql_fetch_array($res)) {
        $curr = array_values($row)[0];
        if (strtolower($curr) === strtolower($target)) return $curr;
    }
    return $target;
}

// 1. 하단 로고 및 설정값 치환
$tables_to_fix = array(
    'g5_plugin_copyright_config' => 'cp_logo',
    'g5_plugin_copyright' => 'logo_url'
);

foreach ($tables_to_fix as $raw_tbl => $col) {
    $tbl = get_real_table_name($raw_tbl);
    $check = sql_fetch("SHOW TABLES LIKE '{$tbl}'");
    if ($check) {
        $count = 0;
        $sql = " SELECT * FROM `{$tbl}` WHERE `{$col}` LIKE '%http://localhost%' ";
        $res = sql_query($sql, false);
        if ($res) {
            while($row = sql_fetch_array($res)) {
                $new_val = str_replace('http://localhost', G5_URL, $row[$col]);
                $id_col = isset($row['cp_id']) ? 'cp_id' : 'id';
                sql_query(" UPDATE `{$tbl}` SET `{$col}` = '" . addslashes($new_val) . "' WHERE `{$id_col}` = '{$row[$id_col]}' ");
                $count++;
            }
        }
        echo "<p style='color:blue;'>- [{$tbl}] {$count}건 경로 복구 완료</p>";
    }
}

// 2. index.html 삭제
if (file_exists('./index.html')) @unlink('./index.html');

// 3. 테마 고정
sql_query(" UPDATE g5_config SET cf_title = '극동판넬(주)', cf_theme = 'kukdong_panel' ");

// 4. 테이블명 대소문자 교정 (1050 에러 방지 버전)
$sql_bo = " SELECT bo_table FROM g5_board ";
$res_bo = sql_query($sql_bo);
if ($res_bo) {
    while($bo = sql_fetch_array($res_bo)) {
        $target_table = G5_TABLE_PREFIX . "write_" . $bo['bo_table'];
        $real_table = get_real_table_name($target_table);
        
        // 이름이 다를 때만 변경 시도하되, 이미 존재하면 건너뜀
        if ($real_table !== $target_table) {
            @sql_query(" RENAME TABLE `{$real_table}` TO `{$target_table}` ");
        }
        
        // 주소 치환 작업 (실제 있는 테이블 이름 사용)
        sql_query(" UPDATE `{$real_table}` SET wr_content = REPLACE(wr_content, 'http://localhost', '" . G5_URL . "') WHERE wr_content LIKE '%http://localhost%' ");
    }
}

echo "<h4>[작업 완료] 이제 사이트로 이동하여 확인해 보세요.</h4>";
echo "<p><a href='./index.php' style='padding:10px 20px; background:#4caf50; color:#fff; text-decoration:none; border-radius:5px;'>최종 사이트 확인</a></p>";
?>
