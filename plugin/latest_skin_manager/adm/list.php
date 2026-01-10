<?php
$sub_menu = "950193";
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '보드 최근글 스킨 관리';
include_once(G5_ADMIN_PATH . '/admin.head.php');

// [DB] Create Table if not exists
if (!sql_query(" DESCRIBE " . G5_PLUGIN_LATEST_SKIN_TABLE . " ", false)) {
    $sql = " CREATE TABLE IF NOT EXISTS `" . G5_PLUGIN_LATEST_SKIN_TABLE . "` (
        `ls_id` varchar(255) NOT NULL DEFAULT '',
        `ls_theme` varchar(50) NOT NULL DEFAULT 'corporate',
        `ls_lang` varchar(10) NOT NULL DEFAULT 'ko',
        `ls_title` varchar(255) NOT NULL DEFAULT '',
        `ls_more_link` varchar(255) NOT NULL DEFAULT '',
        `ls_description` text NOT NULL DEFAULT '',
        `ls_skin` varchar(255) NOT NULL DEFAULT 'theme/basic',
        `ls_bo_table` varchar(50) NOT NULL DEFAULT '',
        `ls_count` int(11) NOT NULL DEFAULT '4',
        `ls_subject_len` int(11) NOT NULL DEFAULT '30',
        `ls_options` varchar(255) NOT NULL DEFAULT '',
        `ls_active` tinyint(4) NOT NULL DEFAULT '1',
        `ls_sort` int(11) NOT NULL DEFAULT '0',
        PRIMARY KEY (`ls_id`),
        KEY `index_theme_lang` (`ls_theme`, `ls_lang`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ";
    sql_query($sql);

    // [New] Insert Default 'Construction Case' Widget
    $check = sql_fetch(" select count(*) as cnt from " . G5_PLUGIN_LATEST_SKIN_TABLE . " ");
    if ($check['cnt'] == 0) {
        sql_query(" INSERT INTO " . G5_PLUGIN_LATEST_SKIN_TABLE . " 
            SET ls_id = 'corporate_main_works',
                ls_title = 'Main Works (Corporate)',
                ls_more_link = '/bbs/board.php?bo_table=chamcode_gallery',
                ls_theme = 'corporate',
                ls_lang = 'ko',
                ls_skin = 'theme/portfolio',
                ls_bo_table = 'chamcode_gallery',
                ls_count = 4,
                ls_subject_len = 30,
                ls_active = 1,
                ls_sort = 1
        ");
    }
}

// [Schema Update] Add columns if missing (Support for Legacy)
$exists_cols = sql_query(" SHOW COLUMNS FROM " . G5_PLUGIN_LATEST_SKIN_TABLE . " LIKE 'ls_theme' ", false);
if (!sql_num_rows($exists_cols)) {
    sql_query(" ALTER TABLE " . G5_PLUGIN_LATEST_SKIN_TABLE . " ADD `ls_theme` varchar(50) NOT NULL DEFAULT 'corporate' AFTER `ls_id` ");
    sql_query(" ALTER TABLE " . G5_PLUGIN_LATEST_SKIN_TABLE . " ADD `ls_lang` varchar(10) NOT NULL DEFAULT 'ko' AFTER `ls_theme` ");
    sql_query(" ALTER TABLE " . G5_PLUGIN_LATEST_SKIN_TABLE . " ADD INDEX `index_theme_lang` (`ls_theme`, `ls_lang`) ");
}
if (!sql_query(" select ls_more_link from " . G5_PLUGIN_LATEST_SKIN_TABLE . " limit 1 ", false)) {
    sql_query(" alter table " . G5_PLUGIN_LATEST_SKIN_TABLE . " add `ls_more_link` varchar(255) NOT NULL DEFAULT '' after `ls_title` ");
}
if (!sql_query(" select ls_description from " . G5_PLUGIN_LATEST_SKIN_TABLE . " limit 1 ", false)) {
    sql_query(" alter table " . G5_PLUGIN_LATEST_SKIN_TABLE . " add `ls_description` text NOT NULL DEFAULT '' after `ls_more_link` ");
}

// Fetch Items
$sql = " select * from " . G5_PLUGIN_LATEST_SKIN_TABLE . " order by ls_sort asc, ls_id desc ";
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
        <caption>최근글 스킨 목록</caption>
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
                <th>관리 명칭 (테마/언어)</th>
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
                $edit_url = "./write.php?w=u&ls_id=" . $row['ls_id'];
                $status = $row['ls_active'] ? '<span class="txt_blue">노출</span>' : '<span class="txt_gray">숨김</span>';

                // Theme/Lang Bagde
                $badge = '<span style="font-size:11px; color:#666; display:block; margin-top:2px;">[' . $row['ls_theme'] . ' / ' . strtoupper($row['ls_lang']) . ']</span>';
                ?>
                <tr>
                    <td class="td_num">
                        <?php echo $row['ls_id']; ?>
                    </td>
                    <td class="td_left">
                        <a href="<?php echo $edit_url; ?>"><strong>
                                <?php echo get_text($row['ls_title']); ?>
                            </strong></a>
                        <?php echo $badge; ?>
                    </td>
                    <td class="td_left">
                        <?php echo $row['ls_bo_table']; ?>
                    </td>
                    <td class="td_left">
                        <?php echo $row['ls_skin']; ?>
                    </td>
                    <td class="td_center">
                        <?php echo $row['ls_count']; ?>개 /
                        <?php echo $row['ls_subject_len']; ?>자
                    </td>
                    <td class="td_center">
                        <?php echo $status; ?>
                    </td>
                    <td class="td_mng">
                        <a href="<?php echo $edit_url; ?>" class="btn btn_03">수정</a>
                        <a href="./update.php?w=d&ls_id=<?php echo $row['ls_id']; ?>&token=<?php echo $admin_token; ?>"
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