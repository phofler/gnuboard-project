<?php
$sub_menu = "800195"; // Adjusted to fit between 800190 and 800200
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '보드 스킨 관리 (최신글)';
include_once(G5_ADMIN_PATH . '/admin.head.php');

// [DB] Create Table if not exists
if (!sql_query(" DESCRIBE " . G5_PLUGIN_BOARD_SKIN_TABLE . " ", false)) {
    $sql = " CREATE TABLE IF NOT EXISTS `" . G5_PLUGIN_BOARD_SKIN_TABLE . "` (
        `bs_id` int(11) NOT NULL AUTO_INCREMENT,
        `bs_title` varchar(255) NOT NULL DEFAULT '',
        `bs_skin` varchar(255) NOT NULL DEFAULT 'theme/basic',
        `bs_bo_table` varchar(50) NOT NULL DEFAULT '',
        `bs_count` int(11) NOT NULL DEFAULT '4',
        `bs_subject_len` int(11) NOT NULL DEFAULT '30',
        `bs_options` varchar(255) NOT NULL DEFAULT '',
        `bs_active` tinyint(4) NOT NULL DEFAULT '1',
        `bs_sort` int(11) NOT NULL DEFAULT '0',
        PRIMARY KEY (`bs_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ";
    sql_query($sql);

    // [New] Insert Default 'Construction Case' Widget
    $check = sql_fetch(" select count(*) as cnt from " . G5_PLUGIN_BOARD_SKIN_TABLE . " ");
    if ($check['cnt'] == 0) {
        sql_query(" INSERT INTO " . G5_PLUGIN_BOARD_SKIN_TABLE . " 
            SET bs_title = 'Construction Case',
                bs_skin = 'theme/portfolio',
                bs_bo_table = 'chamcode_gallery',
                bs_count = 4,
                bs_subject_len = 30,
                bs_active = 1,
                bs_sort = 1
        ");
    }
}

// Fetch Items
$sql = " select * from " . G5_PLUGIN_BOARD_SKIN_TABLE . " order by bs_sort asc, bs_id desc ";
$result = sql_query($sql);

$admin_token = get_admin_token();
?>

<div class="local_desc01 local_desc">
    <p>메인 페이지 등에 노출할 '최신글 스킨(Latest Skin)' 위젯을 관리합니다.</p>
    <p>스킨은 플러그인에서 설정하고, 데이터는 그누보드 게시판에서 가져옵니다.</p>
</div>

<div class="btn_fixed_top">
    <a href="./write.php" class="btn_submit btn">위젯 추가</a>
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
        <caption>보드 스킨 목록</caption>
        <colgroup>
            <col width="60">
            <col>
            <col width="150">
            <col width="150">
            <col width="100">
            <col width="80">
            <col width="100">
        </colgroup>
        <thead>
            <tr>
                <th>ID</th>
                <th>관리 명칭</th>
                <th>대상 게시판</th>
                <th>사용 스킨</th>
                <th>설정(개수/길이)</th>
                <th>상태</th>
                <th>관리</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $row = sql_fetch_array($result); $i++) {
                $edit_url = "./write.php?w=u&bs_id=" . $row['bs_id'];
                $status = $row['bs_active'] ? '<span class="txt_blue">노출</span>' : '<span class="txt_gray">숨김</span>';
                ?>
                <tr>
                    <td class="td_num">
                        <?php echo $row['bs_id']; ?>
                    </td>
                    <td class="td_left">
                        <a href="<?php echo $edit_url; ?>"><strong>
                                <?php echo get_text($row['bs_title']); ?>
                            </strong></a>
                    </td>
                    <td class="td_left">
                        <?php echo $row['bs_bo_table']; ?>
                    </td>
                    <td class="td_left">
                        <?php echo $row['bs_skin']; ?>
                    </td>
                    <td class="td_center">
                        <?php echo $row['bs_count']; ?>개 /
                        <?php echo $row['bs_subject_len']; ?>자
                    </td>
                    <td class="td_center">
                        <?php echo $status; ?>
                    </td>
                    <td class="td_mng">
                        <a href="<?php echo $edit_url; ?>" class="btn btn_03">수정</a>
                        <a href="./update.php?w=d&bs_id=<?php echo $row['bs_id']; ?>&token=<?php echo $admin_token; ?>"
                            class="btn btn_02" onclick="return confirm('정말 삭제하시겠습니까?');">삭제</a>
                    </td>
                </tr>
            <?php } ?>
            <?php if ($i == 0)
                echo '<tr><td colspan="7" class="empty_table">등록된 위젯이 없습니다.</td></tr>'; ?>
        </tbody>
    </table>
</div>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>