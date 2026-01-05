<?php
include_once('./_common.php');

$sub_menu = "800350";
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
    <a href="./write.php" class="btn btn_01">카피라이트 추가</a>
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

<?php
// Fetch Default data for Quick Info Manager
$default = sql_fetch(" select * from {$table_name} where cp_id = 'default' ");
?>

<h2 class="h2_frm" style="margin-top:30px;">하단 정보 관리 (개별 항목) <span class="frm_info"
        style="font-weight:normal; font-size:12px; margin-left:10px;">ID: default 데이터가 반영됩니다.</span></h2>
<form name="fquickconfig" id="fquickconfig" action="./list_update.php" method="post" enctype="multipart/form-data">
    <div class="tbl_frm01 tbl_wrap">
        <table>
            <colgroup>
                <col class="grid_4">
                <col>
            </colgroup>
            <tbody>
                <tr>
                    <th scope="row">하단 로고</th>
                    <td>
                        <input type="file" name="logo_file" id="logo_file">
                        <span class="frm_info">권장: PNG 투명 배경. (기존 로고를 유지하려면 비워두세요)</span>
                        <?php if ($default['logo_url']) { ?>
                            <div style="margin-top:10px; background:#333; padding:10px; display:inline-block;">
                                <img src="<?php echo $default['logo_url']; ?>?v=<?php echo time(); ?>"
                                    style="max-height:40px;">
                            </div>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">사훈 (슬로건)</th>
                    <td>
                        <input type="text" name="slogan" value="<?php echo $default['slogan']; ?>" id="slogan"
                            class="frm_input" style="width:100%;">
                    </td>
                </tr>
                <tr>
                    <th scope="row">주소 (Address)</th>
                    <td>
                        <label for="addr_label">명칭</label>
                        <input type="text" name="addr_label" value="<?php echo $default['addr_label']; ?>"
                            id="addr_label" class="frm_input" size="15">
                        <label for="addr_val" style="margin-left:20px;">내용</label>
                        <input type="text" name="addr_val" value="<?php echo $default['addr_val']; ?>" id="addr_val"
                            class="frm_input" size="60">
                    </td>
                </tr>
                <tr>
                    <th scope="row">연락처 (Tel)</th>
                    <td>
                        <label for="tel_label">명칭</label>
                        <input type="text" name="tel_label" value="<?php echo $default['tel_label']; ?>" id="tel_label"
                            class="frm_input" size="15">
                        <label for="tel_val" style="margin-left:20px;">내용</label>
                        <input type="text" name="tel_val" value="<?php echo $default['tel_val']; ?>" id="tel_val"
                            class="frm_input" size="60">
                    </td>
                </tr>
                <tr>
                    <th scope="row">팩스 (Fax)</th>
                    <td>
                        <label for="fax_label">명칭</label>
                        <input type="text" name="fax_label" value="<?php echo $default['fax_label']; ?>" id="fax_label"
                            class="frm_input" size="15">
                        <label for="fax_val" style="margin-left:20px;">내용</label>
                        <input type="text" name="fax_val" value="<?php echo $default['fax_val']; ?>" id="fax_val"
                            class="frm_input" size="60">
                    </td>
                </tr>
                <tr>
                    <th scope="row">이메일 (Email)</th>
                    <td>
                        <label for="email_label">명칭</label>
                        <input type="text" name="email_label" value="<?php echo $default['email_label']; ?>"
                            id="email_label" class="frm_input" size="15">
                        <label for="email_val" style="margin-left:20px;">내용</label>
                        <input type="text" name="email_val" value="<?php echo $default['email_val']; ?>" id="email_val"
                            class="frm_input" size="60">
                    </td>
                </tr>
                <tr>
                    <th scope="row">링크 1 (Link 1)</th>
                    <td>
                        <label for="link1_name">명칭</label>
                        <input type="text" name="link1_name" value="<?php echo $default['link1_name']; ?>"
                            id="link1_name" class="frm_input" size="15">
                        <label for="link1_url" style="margin-left:20px;">URL</label>
                        <input type="text" name="link1_url" value="<?php echo $default['link1_url']; ?>" id="link1_url"
                            class="frm_input" size="60">
                    </td>
                </tr>
                <tr>
                    <th scope="row">링크 2 (Link 2)</th>
                    <td>
                        <label for="link2_name">명칭</label>
                        <input type="text" name="link2_name" value="<?php echo $default['link2_name']; ?>"
                            id="link2_name" class="frm_input" size="15">
                        <label for="link2_url" style="margin-left:20px;">URL</label>
                        <input type="text" name="link2_url" value="<?php echo $default['link2_url']; ?>" id="link2_url"
                            class="frm_input" size="60">
                    </td>
                </tr>
                <tr>
                    <th scope="row">카피라이트 (Copyright)</th>
                    <td>
                        <textarea name="copyright" id="copyright" class="frm_input"
                            style="width:100%; height:80px;"><?php echo $default['copyright']; ?></textarea>
                    </td>
                </tr>

                <input type="hidden" name="cp_content" value="<?php echo htmlspecialchars($default['cp_content']); ?>">
            </tbody>
        </table>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" value="하단 정보 일괄 저장" class="btn_submit">
    </div>
</form>

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