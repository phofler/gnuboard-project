<?php
include_once('./_common.php');

$sub_menu = "950350";
$g5['title'] = '카피라이트 관리';
include_once(G5_ADMIN_PATH . '/admin.head.php');

$table_name = G5_TABLE_PREFIX . 'plugin_copyright';
$sql_common = " from {$table_name} ";
$sql_search = " where (1) ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} ";

// DB Auto Install
$row = sql_fetch(" SHOW TABLES LIKE '{$table_name}' ");
if (!$row) {
    include('../install.php');
    alert('DB 테이블이 자동으로 설치되었습니다.\\n\\n페이지를 새로고침합니다.', './list.php');
    exit;
}

$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql = " select * {$sql_common} {$sql_search} order by cp_id asc ";
$result = sql_query($sql);
?>

<div class="local_ov01 local_ov">
    전체
    <?php echo number_format($total_count) ?>건
</div>

<div class="btn_fixed_top">
    <a href="./write.php" class="btn_submit btn"
        style="background-color:#ff3061; border-color:#ff3061; color:#fff;">카피라이트 추가</a>
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
        <caption>
            <?php echo $g5['title']; ?> 목록
        </caption>
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
                $update_href = './write.php?w=u&amp;cp_id=' . $row['cp_id'];
                $delete_href = './delete.php?cp_id=' . $row['cp_id'];
                ?>
                <tr>
                    <td class="td_id">
                        <?php echo $row['cp_id']; ?>
                    </td>
                    <td class="td_subject">
                        <?php echo $row['cp_subject']; ?>
                    </td>
                    <td class="td_category">
                        <?php echo $row['cp_skin']; ?>
                    </td>
                    <td class="td_datetime">
                        <?php echo $row['cp_datetime']; ?>
                    </td>
                    <td class="td_mng">
                        <a href="<?php echo $update_href; ?>" class="btn btn_03">수정</a>
                        <?php if ($row['cp_id'] != 'default') { ?>
                            <a href="<?php echo $delete_href; ?>" onclick="return delete_confirm(this);"
                                class="btn btn_02">삭제</a>
                        <?php } ?>
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