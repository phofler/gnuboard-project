<?php
if (!defined('_GNUBOARD_'))
    exit;

// 초기 변수 설정
$sfl = isset($sfl) ? $sfl : '';
$stx = isset($stx) ? $stx : '';
$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '" class="ov_listall">전체목록</a>';
?>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    <span class="btn_ov01"><span class="ov_txt">전체 </span><span
            class="ov_num"><?php echo number_format($total_count) ?>건</span></span>
</div>

<div class="btn_fixed_top">
    <a href="./skin_list.php" class="btn_submit btn"
        style="background-color:#ff3061; border-color:#ff3061; color:#fff;">스킨 관리/수정</a>
</div>

<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">
    <div class="sch_last">
        <label for="sfl" class="sound_only">검색대상</label>
        <select name="sfl" id="sfl">
            <option value="name" <?php echo get_selected($sfl, "name"); ?>>이름</option>
            <option value="subject" <?php echo get_selected($sfl, "subject"); ?>>제목</option>
            <option value="content" <?php echo get_selected($sfl, "content"); ?>>내용</option>
        </select>
        <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
        <input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
        <input type="submit" class="btn_submit" value="검색">

        <input type="submit" form="fonline_inquiry_list" name="act_button" value="선택삭제"
            onclick="document.pressed=this.value" class="btn btn_02" style="margin-left:5px; vertical-align:top;">
    </div>
</form>

<form name="fonline_inquiry_list" id="fonline_inquiry_list" action="./list_update.php"
    onsubmit="return fonline_inquiry_list_submit(this);" method="post">
    <input type="hidden" name="token" value="<?php echo get_admin_token(); ?>">

    <div class="tbl_head01 tbl_wrap">
        <table>
            <caption><?php echo $g5['title']; ?> 목록</caption>
            <thead>
                <tr>
                    <th scope="col" style="width: 40px;">
                        <label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
                        <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                    </th>
                    <th scope="col" style="width: 50px;">번호</th>
                    <th scope="col" style="width: 120px;">출처 (테마/언어)</th>
                    <th scope="col" style="width: 100px;">이름</th>
                    <th scope="col" style="width: 150px;">연락처</th>
                    <th scope="col">제목</th>
                    <th scope="col" style="width: 150px;">접수일</th>
                    <th scope="col" style="width: 120px;">IP</th>
                    <th scope="col" style="width: 80px;">관리</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $row = sql_fetch_array($result); $i++) {
                    $one_update = '<a href="./view.php?id=' . $row['id'] . '" class="btn btn_03">보기</a>';
                    ?>
                    <tr class="bg<?php echo $i % 2; ?>">
                        <td class="td_chk">
                            <label for="chk_<?php echo $i; ?>"
                                class="sound_only"><?php echo get_text($row['subject']); ?></label>
                            <input type="checkbox" name="chk[]" value="<?php echo $row['id']; ?>"
                                id="chk_<?php echo $i; ?>">
                        </td>
                        <td class="td_num"><?php echo $row['id']; ?></td>
                        <td class="td_center">
                            <?php
                            $th = isset($row['theme']) ? $row['theme'] : '';
                            $lg = isset($row['lang']) ? $row['lang'] : '';

                            if ($th)
                                echo '<span style="font-weight:bold;">' . $th . '</span>';
                            if ($lg)
                                echo ' <span style="font-size:11px; color:#888;">(' . strtoupper($lg) . ')</span>';
                            if (!$th && !$lg)
                                echo '-';
                            ?>
                        </td>
                        <td class="td_left"><?php echo get_text($row['name']); ?></td>
                        <td class="td_left"><?php echo get_text($row['contact']); ?></td>
                        <td class="td_left"><?php echo get_text($row['subject']); ?></td>
                        <td class="td_datetime"><?php echo $row['reg_date']; ?></td>
                        <td class="td_num"><?php echo $row['ip']; ?></td>
                        <td class="td_mng"><?php echo $one_update ?></td>
                    </tr>
                <?php } ?>
                <?php if ($i == 0) { ?>
                    <tr>
                        <td colspan="8" class="empty_table">자료가 없습니다.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</form>

<script>
    function fonline_inquiry_list_submit(f) {
        if (!is_checked("chk[]")) {
            alert(document.pressed + " 하실 항목을 하나 이상 선택하세요.");
            return false;
        }

        if (document.pressed == "선택삭제") {
            if (!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
                return false;
            }
        }

        return true;
    }
</script>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;page='); ?>