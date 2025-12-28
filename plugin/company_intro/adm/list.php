<?php
include_once('./_common.php');

$g5['title'] = '회사소개 관리';
include_once(G5_ADMIN_PATH . '/admin.head.php');

$table_name = G5_TABLE_PREFIX . 'plugin_company_add';
$sql_common = " from {$table_name} ";
$sql_search = " where (1) ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} ";

// [DB 테이블 자동 설치 방어 코드]
// 테이블 존재 여부 확인 (SHOW TABLES 사용)
$row = sql_fetch(" SHOW TABLES LIKE '{$table_name}' ");
if (!$row) {
    include('../install.php');
    alert('DB 테이블이 자동으로 설치되었습니다.\\n\\n페이지를 새로고침합니다.', './list.php');
    exit;
} else {
    // 테이블이 존재해도 컬럼 추가 등 DB 변경사항 체크를 위해 실행
    include_once('../install.php');
}

$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql = " select * {$sql_common} {$sql_search} order by co_id asc ";
$result = sql_query($sql);
?>

<div class="local_ov01 local_ov">
    전체 <?php echo number_format($total_count) ?>건
</div>

<div class="btn_fixed_top">
    <a href="./write.php" class="btn btn_01">회사소개 추가</a>
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
        <caption><?php echo $g5['title']; ?> 목록</caption>
        <thead>
            <tr>
                <th scope="col">ID (식별코드)</th>
                <th scope="col">제목</th>
                <th scope="col">스킨타입</th>
                <th scope="col">최근수정</th>
                <th scope="col">관리</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $row = sql_fetch_array($result); $i++) {
                $update_href = './write.php?w=u&amp;co_id=' . $row['co_id'];
                $delete_href = './delete.php?co_id=' . $row['co_id'];
                ?>
                <tr>
                    <td class="td_id"><?php echo $row['co_id']; ?></td>
                    <td class="td_subject"><?php echo $row['co_subject']; ?></td>
                    <td class="td_category"><?php echo $row['co_skin']; ?></td>
                    <td class="td_datetime"><?php echo $row['co_datetime']; ?></td>
                    <td class="td_mng">
                        <a href="<?php echo $update_href; ?>" class="btn btn_03">수정</a>
                        <a href="<?php echo $delete_href; ?>" onclick="return delete_confirm(this);"
                            class="btn btn_02">삭제</a>
                    </td>
                </tr>
                <?php
            }
            if ($i == 0)
                echo '<tr><td colspan="5" class="empty_table">자료가 없습니다.</td></tr>';
            ?>
        </tbody>
    </table>
</div>

<script>
    function delete_confirm(el) {
        if (confirm("한번 삭제한 자료는 복구할 수 없습니다.\n\n정말 삭제하시겠습니까?")) {
            return true;
        }
        return false;
    }
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>