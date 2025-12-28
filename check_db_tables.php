<?php
include_once('./_common.php');

echo "<h1>전체 게시판 테이블 현황</h1>";

// Get board list
$sql = " select bo_table from {$g5['board_table']} order by bo_table ";
$result = sql_query($sql);

echo "<table border='1' cellspacing='0' cellpadding='5' style='border-collapse:collapse; width:100%'>";
echo "<tr style='background:#f1f1f1'><th>게시판 ID (bo_table)</th><th>테이블 이름 (Table Name)</th><th>상태 (Status)</th><th>Engine</th></tr>";

while ($row = sql_fetch_array($result)) {
    $bo_table = $row['bo_table'];
    $table_name = $g5['write_prefix'] . $bo_table;

    // Check table existence and status
    $t_row = sql_fetch(" SHOW TABLE STATUS LIKE '$table_name' ");

    echo "<tr>";
    echo "<td><strong>$bo_table</strong></td>";
    echo "<td>$table_name</td>";

    if ($t_row) {
        echo "<td style='color:blue'>[정상] 존재함</td>";
        echo "<td>{$t_row['Engine']}</td>";
    } else {
        echo "<td style='color:red; font-weight:bold;'>[오류] 존재하지 않음 (MISSING)</td>";
        echo "<td>-</td>";
    }
    echo "</tr>";
}
echo "</table>";

echo "<br><hr>";
echo "<p>* [오류] 상태인 게시판은 <a href='./fix_table_creation.php'>[복구 도구 실행]</a>을 눌러 수동으로 생성해야 합니다.</p>";
echo "<p>* 방금 수정한 코드가 적용되었다면, 새로 만드는 게시판은 <strong>InnoDB</strong> 엔진으로 생성되어야 합니다.</p>";
?>