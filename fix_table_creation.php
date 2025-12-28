<?php
include_once('./_common.php');

// Security check: Only admin
// if (!$is_admin)
//     die("관리자만 실행 가능합니다.");

echo "<h1>게시판 테이블 복구 도구</h1>";

// 1. Get all boards
$sql = " select bo_table, bo_subject from {$g5['board_table']} order by bo_table ";
$result = sql_query($sql);

$source_table = "{$g5['write_prefix']}online"; // Use 'online' as template
// Check source table
if (!sql_fetch("SHOW TABLES LIKE '$source_table'")) {
    die("Error: 기준이 될 '$source_table' 테이블이 없습니다. 복구를 진행할 수 없습니다.");
}

echo "<ul>";
while ($row = sql_fetch_array($result)) {
    $bo_table = $row['bo_table'];
    $target_table = $g5['write_prefix'] . $bo_table;

    echo "<li><strong>$bo_table</strong> ({$row['bo_subject']}) 확인 중... ";

    // Check if table exists
    if (sql_fetch("SHOW TABLES LIKE '$target_table'")) {
        echo "<span style='color:green'>[정상] 테이블 존재함</span>";
    } else {
        echo "<span style='color:red'>[오류] 테이블 없음 - 복구 시도</span><br>";

        // Attempt to create table by copying structure from 'online'
        // Method: Get Create Statement -> Modify Table Name -> Execute
        $row_create = sql_fetch("SHOW CREATE TABLE $source_table");
        if ($row_create && isset($row_create['Create Table'])) {
            $create_sql = $row_create['Create Table'];
            $create_sql = str_replace("CREATE TABLE `$source_table`", "CREATE TABLE `$target_table`", $create_sql);
            // Fix for strict mode (0000-00-00 date issue)
            $create_sql = str_replace("'0000-00-00 00:00:00'", "'1000-01-01 00:00:00'", $create_sql);

            // Execute Create
            if (sql_query($create_sql, false)) {
                echo "&nbsp;&nbsp;└─ <span style='color:blue'>[성공] 테이블 생성 완료!</span>";
            } else {
                echo "&nbsp;&nbsp;└─ <span style='color:red'>[실패] 생성 중 DB 오류 발생: " . sql_error() . "</span>";
            }
        } else {
            echo "&nbsp;&nbsp;└─ <span style='color:red'>[실패] 원본 테이블 구조를 읽을 수 없습니다.</span>";
        }
    }
    echo "</li>";
}
echo "</ul>";
echo "<p>작업이 완료되었습니다. 문제가 있던 게시판에 다시 접속해 보세요.</p>";
echo "<a href='" . G5_ADMIN_URL . "/board_list.php'>게시판 관리로 돌아가기</a>";
?>