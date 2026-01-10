<?php
$sub_menu = "950150";
include_once('./_common.php');

define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

if (!$is_admin) {
    alert('관리자만 접근 가능합니다.');
}

// Ensure Table Exists
include_once(dirname(__FILE__) . '/install.php');

$g5['title'] = "상단 메뉴 설정 관리";
include_once(G5_ADMIN_PATH . '/admin.head.php');

$sql = " SELECT * FROM g5_plugin_top_menu_config ORDER BY tm_reg_dt DESC ";
$result = sql_query($sql);

// [FIX] Deletion Logic moved to list.php (Matches Main Image Manager)
if (isset($_GET['w']) && $_GET['w'] == 'd' && isset($_GET['tm_id'])) {
    $tm_id = preg_replace('/[^a-zA-Z0-9_]/', '', $_GET['tm_id']);

    // Delete files
    $row = sql_fetch(" SELECT * FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}' ");
    if ($row['tm_logo_pc'])
        @unlink(G5_DATA_PATH . '/common/' . $row['tm_logo_pc']);
    if ($row['tm_logo_mo'])
        @unlink(G5_DATA_PATH . '/common/' . $row['tm_logo_mo']);

    sql_query(" DELETE FROM g5_plugin_top_menu_config WHERE tm_id = '{$tm_id}' ");
    alert('삭제되었습니다.', './list.php');
}
?>

<div class="local_desc01 local_desc">
    <p>
        테마(Theme)나 언어별로 서로 다른 상단 메뉴 디자인과 데이터를 연결할 수 있습니다.<br>
        <strong>식별코드(ID)</strong>는 테마명(예: corporate) 또는 corporate_en 등과 매칭됩니다.
    </p>
</div>

<div class="btn_fixed_top">
    <a href="./write.php" class="btn btn_01">설정 추가</a>
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
        <caption>
            <?php echo $g5['title']; ?> 목록
        </caption>
        <colgroup>
            <col width="150">
            <col width="150">
            <col width="150">
            <col>
            <col width="100">
        </colgroup>
        <thead>
            <tr>
                <th>식별코드 (ID)</th>
                <th>적용 스킨</th>
                <th>메뉴 소스</th>
                <th>로고 미리보기</th>
                <th>관리</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $row = sql_fetch_array($result); $i++) {
                $logo_pc = $row['tm_logo_pc'] ? G5_DATA_URL . '/common/' . $row['tm_logo_pc'] : '';
                $logo_mo = $row['tm_logo_mo'] ? G5_DATA_URL . '/common/' . $row['tm_logo_mo'] : '';

                $logo_html = '';
                if ($logo_pc)
                    $logo_html .= '<img src="' . $logo_pc . '" style="max-height:30px; border:1px solid #eee; margin-right:5px;" title="PC Logo">';
                if ($logo_mo)
                    $logo_html .= '<img src="' . $logo_mo . '" style="max-height:30px; border:1px solid #eee;" title="Mobile Logo">';
                ?>
                <tr class="<?php echo $bg; ?>">
                    <td class="td_category"><strong>
                            <?php echo $row['tm_id']; ?>
                        </strong></td>
                    <td class="td_category">
                        <?php echo $row['tm_skin']; ?>
                    </td>
                    <td class="td_category">
                        <?php echo $row['tm_menu_table'] ? $row['tm_menu_table'] . ' (Extended)' : '기본 (Default)'; ?>
                    </td>
                    <td class="td_mng">
                        <?php echo $logo_html; ?>
                    </td>
                    <td class="td_mng">
                        <a href="./write.php?w=u&tm_id=<?php echo $row['tm_id']; ?>" class="btn btn_03">수정</a>
                        <a href="./list.php?w=d&tm_id=<?php echo $row['tm_id']; ?>"
                            onclick="return confirm('정말 삭제하시겠습니까?');" class="btn btn_02">삭제</a>
                    </td>
                </tr>
            <?php } ?>
            <?php if ($i == 0)
                echo '<tr><td colspan="5" class="empty_table">등록된 설정이 없습니다.</td></tr>'; ?>
        </tbody>
    </table>
</div>



<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>