<?php
$sub_menu = "950400";
include_once('./_common.php');
include_once('../lib/map.lib.php'); // Only for reference if needed, but not strictly required here
include_once('./check_db.php'); // Ensure DB exists

if (isset($_GET['w']) && $_GET['w'] == 'd' && isset($_GET['ma_id'])) {
    check_admin_token();
    $ma_id = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['ma_id']);
    sql_query(" DELETE FROM {$table_name} WHERE ma_id = '{$ma_id}' ");
    alert("삭제되었습니다.", "./list.php");
}

$g5['title'] = '지도 API 관리';
include_once(G5_ADMIN_PATH . '/admin.head.php');

$sql_common = " FROM {$table_name} ";
$sql_search = " WHERE (1) ";
if ($stx) {
    $sql_search .= " AND (ma_id LIKE '%{$stx}%') ";
}

$sql_order = " ORDER BY ma_regdate DESC ";

$sql = " SELECT count(*) as cnt {$sql_common} {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = G5_IS_MOBILE ? $config['cf_mobile_page_rows'] : $config['cf_page_rows'];
$total_page = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1)
    $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " SELECT * {$sql_common} {$sql_search} {$sql_order} LIMIT {$from_record}, {$rows} ";
$result = sql_query($sql);
?>

<div class="local_ov01 local_ov">
    <span class="btn_ov01"><span class="ov_txt">총 등록수</span> <span class="ov_num">
            <?php echo number_format($total_count); ?>건
        </span></span>
</div>

<div class="local_sch01 local_sch">
    <form name="fsearch" id="fsearch" method="get">
        <input type="hidden" name="sfl" value="ma_id">
        <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="frm_input">
        <input type="submit" value="검색" class="btn_submit">
    </form>
</div>

<div class="btn_fixed_top">
    <a href="./write.php" class="btn btn_01">지도 설정 추가</a>
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
        <caption>
            <?php echo $g5['title']; ?> 목록
        </caption>
        <thead>
            <tr>
                <th scope="col">식별코드 (ID)</th>
                <th scope="col">숏코드 (Shortcode)</th>
                <th scope="col">제공자</th>
                <th scope="col">좌표 (Lat / Lng)</th>
                <th scope="col">등록일</th>
                <th scope="col">관리</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $row = sql_fetch_array($result); $i++) {
                $s_url = "./write.php?w=u&amp;ma_id=" . $row['ma_id'];
                $shortcode = '{MAP_API:' . $row['ma_id'] . '}';
                ?>
                <tr class="bg<?php echo $i % 2; ?>">
                    <td class="td_left">
                        <a href="<?php echo $s_url; ?>" style="font-weight:bold;">
                            <?php echo $row['ma_id']; ?>
                        </a>
                    </td>
                    <td class="td_center">
                        <span class="shortcode-box"
                            style="background:#f9f9f9; padding:5px 10px; border:1px solid #ddd; border-radius:4px; font-family:monospace; cursor:pointer;"
                            onclick="copy_shortcode(this);">
                            <?php echo $shortcode; ?>
                        </span>
                    </td>
                    <td class="td_center">
                        <?php
                        $p_map = array('naver' => '네이버', 'google' => '구글', 'kakao' => '카카오');
                        echo isset($p_map[$row['ma_provider']]) ? $p_map[$row['ma_provider']] : $row['ma_provider'];
                        ?>
                    </td>
                    <td class="td_center">
                        <?php echo $row['ma_lat']; ?> /
                        <?php echo $row['ma_lng']; ?>
                    </td>
                    <td class="td_center">
                        <?php echo $row['ma_regdate']; ?>
                    </td>
                    <td class="td_center">
                        <a href="<?php echo $s_url; ?>" class="btn btn_03">수정</a>
                        <a href="./list.php?w=d&amp;ma_id=<?php echo $row['ma_id']; ?>&amp;token=<?php echo get_admin_token(); ?>"
                            onclick="return delete_confirm(this);" class="btn btn_02">삭제</a>
                    </td>
                </tr>
                <?php
            }
            if ($i == 0)
                echo '<tr><td colspan="6" class="empty_table">자료가 없습니다.</td></tr>';
            ?>
        </tbody>
    </table>
</div>

<script>
    function copy_shortcode(element) {
        var text = element.innerText;
        var tempInput = document.createElement("input");
        tempInput.style = "position: absolute; left: -1000px; top: -1000px";
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);

        var originalBg = element.style.backgroundColor;
        element.style.backgroundColor = "#e0f7fa"; // Light Blue highlight
        element.style.borderColor = "#4dd0e1";

        setTimeout(function () {
            element.style.backgroundColor = originalBg;
            element.style.borderColor = "#ddd";
        }, 500);

        alert('숏코드가 복사되었습니다: ' + text);
    }
</script>

<?php echo get_paging(
    G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'],
    $page,
    $total_page,
    '?' . $qstr . '&amp;page='
); ?>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>