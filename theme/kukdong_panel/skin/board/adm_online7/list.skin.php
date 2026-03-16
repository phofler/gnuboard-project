<?php
if (!defined('_GNUBOARD_'))
    exit; // Prevent direct access

// Load skin style
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css">', 0);
?>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    <span class="btn_ov01"><span class="ov_txt">전체 </span><span class="ov_num">
            <?php echo number_format($total_count) ?>건</span></span>
</div>

<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
    <div class="sch_last">
        <label for="sfl" class="sound_only">검색대상</label>
        <select name="sfl" id="sfl">
            <option value="wr_subject" <?php echo get_selected($_GET['sfl'], "wr_subject"); ?>>제목</option>
            <option value="wr_content" <?php echo get_selected($_GET['sfl'], "wr_content"); ?>>내용</option>
            <option value="wr_name" <?php echo get_selected($_GET['sfl'], "wr_name"); ?>>글쓴이</option>
        </select>
        <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
        <input type="submit" class="btn_submit" value="검색">
    </div>
</form>

<form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);"
    method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="fod" value="<?php echo $fod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">

    <div class="tbl_head01 tbl_wrap">
        <table>
            <caption><?php echo $g5['title']; ?> 목록</caption>
            <thead>
                <tr>
                    <th scope="col" style="width: 50px;">번호</th>
                    <th scope="col" style="width: 100px;">이름</th>
                    <th scope="col" style="width: 150px;">연락처</th>
                    <th scope="col">제목</th>
                    <th scope="col" style="width: 150px;">작성일</th>
                    <th scope="col" style="width: 120px;">IP</th>
                    <th scope="col" style="width: 80px;">관리</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $row = sql_fetch_array($result); $i++) {
                    // Correct link to board
                    $one_update = '<a href="' . G5_BBS_URL . '/board.php?bo_table=' . $bo_table . '&amp;wr_id=' . $row['wr_id'] . '" class="btn btn_03" target="_blank">보기</a>';

                    $wr_1 = $row['wr_1'];
                    ?>
                    <tr class="bg<?php echo $i % 2; ?>">
                        <td class="td_num"><?php echo $row['wr_id']; ?></td>
                        <td class="td_left"><?php echo get_text($row['wr_name']); ?></td>
                        <td class="td_left"><?php echo get_text($wr_1); ?></td>
                        <td class="td_left"><?php echo get_text($row['wr_subject']); ?></td>
                        <td class="td_datetime"><?php echo $row['wr_datetime']; ?></td>
                        <td class="td_num"><?php echo $row['wr_ip']; ?></td>
                        <td class="td_mng"><?php echo $one_update ?></td>
                    </tr>
                    <?php
                }
                if ($i == 0) {
                    echo '<tr><td colspan="' . $colspan . '" class="empty_table">자료가 없습니다.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;page='); ?>