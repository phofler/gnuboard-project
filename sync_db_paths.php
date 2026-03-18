<?php
/**
 * DB Path Cleanup & Fix Tool v10 (Post-Git Sync Finalizer)
 * 1. 하단 로고(Footer Logo) 경로 강제 교정 및 복구
 * 2. 서버의 index.html 자동 삭제
 * 3. 테마 및 사이트 제목 강제 고정 (디자인 되돌아감 방지)
 * 4. 게시판 본문 및 플러그인 설정 내의 localhost 주소 일괄 변환
 * 5. 리눅스 대소문자 구분 문제 자동 교정
 */
include_once('./_common.php');

if (!$is_admin) {
    die("관리자 권한이 필요합니다.");
}

echo "<h3>[V10 최종 점검] 서버 환경 최적화 및 경로 복구</h3>";

// 1. 하단 로고 설정 내의 localhost 치환 (다양한 테이블 대응)
$tables_to_fix = array(
    'g5_plugin_copyright_config' => 'cp_logo',
    'g5_plugin_copyright' => 'logo_url'
);

foreach ($tables_to_fix as $tbl => $col) {
    if (sql_query("SHOW TABLES LIKE '{$tbl}'")) {
        $count = 0;
        $sql = " SELECT * FROM {$tbl} WHERE {$col} LIKE '%http://localhost%' ";
        $res = sql_query($sql, false);
        if ($res) {
            while($row = sql_fetch_array($res)) {
                $new_val = str_replace('http://localhost', G5_URL, $row[$col]);
                // ID 컬럼 찾기 (cp_id 또는 id)
                $id_col = isset($row['cp_id']) ? 'cp_id' : 'id';
                sql_query(" UPDATE {$tbl} SET {$col} = '" . addslashes($new_val) . "' WHERE {$id_col} = '{$row[$id_col]}' ");
                $count++;
            }
        }
        echo "<p style='color:blue;'>- [{$tbl}] {$count}건 경로 복구 완료</p>";
    }
}

// 2. 서버에 남은 index.html 자동 삭제
if (file_exists('./index.html')) {
    if (@unlink('./index.html')) {
        echo "<p style='color:red;'>- [파일 제거] 옛날 시안(index.html) 삭제 성공!</p>";
    }
}

// 3. 기본 환경설정 고정 (kukdong_panel)
sql_query(" UPDATE g5_config SET cf_title = '극동판넬(주)', cf_theme = 'kukdong_panel' ");
echo "<p>- [환경설정] 테마 및 제목 고정 완료</p>";

// 4. 상단 메뉴 로고 및 스킨 설정 복구
sql_query(" UPDATE g5_plugin_top_menu_config SET 
    tm_theme = 'kukdong_panel',
    tm_skin = 'transparent',
    tm_logo_pc = 'tm_kukdong_panel_pc.png',
    tm_logo_mo = 'tm_kukdong_panel_mo.png',
    tm_menu_table = 'pdc'
    WHERE tm_id = 'kukdong_panel'
");
echo "<p>- [상단메뉴] 로고 및 스킨 복구 완료</p>";

// 5. 테이블명 대소문자 정규화 (리눅스용)
$sql_bo = " SELECT bo_table FROM g5_board ";
$res_bo = sql_query($sql_bo);
if ($res_bo) {
    while($bo = sql_fetch_array($res_bo)) {
        $target_table = G5_TABLE_PREFIX . "write_" . $bo['bo_table'];
        $all_tables_res = sql_query("SHOW TABLES");
        while($trow = sql_fetch_array($all_tables_res)) {
            $curr_t = array_values($trow)[0];
            if (strtolower($curr_t) === strtolower($target_table) && $curr_t !== $target_table) {
                sql_query(" RENAME TABLE `{$curr_t}` TO `{$target_table}` ");
            }
        }
    }
}

// 6. 게시판 본문 내용 치환
$res_bo2 = sql_query($sql_bo);
if ($res_bo2) {
    while($bo = sql_fetch_array($res_bo2)) {
        $table = G5_TABLE_PREFIX . "write_" . $bo['bo_table'];
        sql_query(" UPDATE {$table} SET wr_content = REPLACE(wr_content, 'http://localhost', '" . G5_URL . "') WHERE wr_content LIKE '%http://localhost%' ");
    }
}

echo "<h4>[모든 작업 완료] 모든 경로가 서버에 맞게 조정되었습니다.</h4>";
echo "<p><a href='./index.php' style='padding:10px 20px; background:#4caf50; color:#fff; text-decoration:none; border-radius:5px;'>최종 사이트 확인</a></p>";
?>
