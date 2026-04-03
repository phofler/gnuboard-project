<?php
/**
 * DB Path Cleanup & Fix Tool v14 (Ultimate Path & Skin Fix)
 * 1. 메뉴 테이블 매핑 수정 및 노출 활성화
 * 2. 카피라이트 에디터 내용(cp_content) 내 localhost 주소 일괄 변환
 * 3. 하단 로고 및 게시판 본문 localhost 주소 일괄 변환
 */
include_once('./_common.php');

if (!$is_admin) {
    die("관리자 권한이 필요합니다.");
}

echo "<h3>[V14 최종 점검] 모든 경로 및 에디터 내용 복구</h3>";

// 헬퍼 기능: 대소문자 무시하고 실제 테이블 이름 찾기
function get_real_table_name($target) {
    $res = sql_query("SHOW TABLES");
    while($row = sql_fetch_array($res)) {
        $curr = array_values($row)[0];
        if (strtolower($curr) === strtolower($target)) return $curr;
    }
    return $target;
}

// 1. 상단 메뉴 설정 수정
sql_query(" UPDATE g5_plugin_top_menu_config SET 
    tm_menu_table = '', 
    tm_skin = 'transparent',
    tm_theme = 'kukdong_panel'
    WHERE tm_id = 'kukdong_panel' 
");
echo "<p style='color:green;'>- [상단메뉴] 기본 메뉴판(pdc) 연결 최적화 완료</p>";

// 2. 메뉴 아이템 노출 설정 일괄 활성화
$menu_table = get_real_table_name('g5_write_menu_pdc');
if (sql_query("SHOW TABLES LIKE '{$menu_table}'")) {
    sql_query(" UPDATE `{$menu_table}` SET ma_use = 1, ma_menu_use = 1, ma_mobile_use = 1 ");
    echo "<p style='color:blue;'>- [메뉴아이템] 모든 메뉴 '보임' 상태로 변경 완료</p>";
}

// 3. 주소 치환 (localhost -> 서버주소) - 에디터 내용 포함
$tables_to_fix = array(
    'g5_plugin_copyright_config' => 'cp_logo',
    'g5_plugin_copyright' => array('logo_url', 'cp_content')
);

foreach ($tables_to_fix as $raw_tbl => $cols) {
    $tbl = get_real_table_name($raw_tbl);
    if (!is_array($cols)) $cols = array($cols);
    
    if (sql_query("SHOW TABLES LIKE '{$tbl}'")) {
        foreach ($cols as $col) {
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
            echo "<p style='color:blue;'>- [{$tbl}] {$col} 컬럼 {$count}건 경로 복원 완료</p>";
        }
    }
}

// 4. 테마 및 게시판 경로 교정
sql_query(" UPDATE g5_config SET cf_title = '극동판넬(주)', cf_theme = 'kukdong_panel' ");

$sql_bo = " SELECT bo_table FROM g5_board ";
$res_bo = sql_query($sql_bo);
if ($res_bo) {
    while($bo = sql_fetch_array($res_bo)) {
        $target_table = G5_TABLE_PREFIX . "write_" . $bo['bo_table'];
        $real_table = get_real_table_name($target_table);
        if ($real_table !== $target_table) {
            @sql_query(" RENAME TABLE `{$real_table}` TO `{$target_table}` ");
        }
        sql_query(" UPDATE `{$real_table}` SET wr_content = REPLACE(wr_content, 'http://localhost', '" . G5_URL . "') WHERE wr_content LIKE '%http://localhost%' ");
    }
}

echo "<h4>[작업 완료] 이제 상단 메뉴와 하단 로고가 정상적으로 나타납니다.</h4>";
echo "<p><a href='./index.php' style='padding:10px 20px; background:#4caf50; color:#fff; text-decoration:none; border-radius:5px;'>최종 사이트 확인</a></p>";
?>
