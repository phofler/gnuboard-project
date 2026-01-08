<?php
$sub_menu = "800190";
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '메인 컨텐츠 관리';
include_once(G5_ADMIN_PATH . '/admin.head.php');

// [NEW] 섹션 관리 테이블 생성 확인 및 업데이트
if (!sql_query(" DESCRIBE g5_plugin_main_content_sections ", false)) {
    $sql = " CREATE TABLE IF NOT EXISTS `g5_plugin_main_content_sections` (
        `ms_id` int(11) NOT NULL AUTO_INCREMENT,
        `ms_title` varchar(255) NOT NULL DEFAULT '',
        `ms_show_title` tinyint(4) NOT NULL DEFAULT '1',
        `ms_skin` varchar(50) NOT NULL DEFAULT 'A',
        `ms_sort` int(11) NOT NULL DEFAULT '0',
        `ms_active` tinyint(4) NOT NULL DEFAULT '1',
        `ms_accent_color` varchar(20) NOT NULL DEFAULT '#FF3B30',
        `ms_font_mode` varchar(20) NOT NULL DEFAULT 'serif',
        PRIMARY KEY (`ms_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ";
    sql_query($sql);

    // 기본 섹션 하나 생성
    sql_query(" INSERT INTO `g5_plugin_main_content_sections` SET ms_title = 'PRODUCT COLLECTION', ms_skin = 'A', ms_sort = '1' ");
}

// [MODIFY] 아이템 테이블 수정 및 ms_id 인덱스 추가
$row = sql_fetch(" SHOW COLUMNS FROM g5_plugin_main_content LIKE 'ms_id' ");
if (!$row) {
    sql_query(" ALTER TABLE g5_plugin_main_content ADD `ms_id` int(11) NOT NULL DEFAULT '0' AFTER `mc_id`, ADD KEY `ms_id` (`ms_id`) ");
}

// [NEW] 언어 컬럼 추가 (Multi-Language Support)
$row = sql_fetch(" SHOW COLUMNS FROM g5_plugin_main_content_sections LIKE 'ms_lang' ");
if (!$row) {
    sql_query(" ALTER TABLE g5_plugin_main_content_sections ADD `ms_lang` varchar(10) NOT NULL DEFAULT 'kr' AFTER `ms_title` ");
}

// [NEW] 테마/식별코드 컬럼 추가
$row = sql_fetch(" SHOW COLUMNS FROM g5_plugin_main_content_sections LIKE 'ms_theme' ");
if (!$row) {
    sql_query(" ALTER TABLE g5_plugin_main_content_sections ADD `ms_theme` varchar(50) NOT NULL DEFAULT 'corporate' AFTER `ms_lang` ");
}
$row = sql_fetch(" SHOW COLUMNS FROM g5_plugin_main_content_sections LIKE 'ms_key' ");
if (!$row) {
    sql_query(" ALTER TABLE g5_plugin_main_content_sections ADD `ms_key` varchar(100) NOT NULL DEFAULT '' AFTER `ms_theme` ");
}

// [NEW] 외부 컨텐츠 소스 ID (Location 등)
$row = sql_fetch(" SHOW COLUMNS FROM g5_plugin_main_content_sections LIKE 'ms_content_source' ");
if (!$row) {
    sql_query(" ALTER TABLE g5_plugin_main_content_sections ADD `ms_content_source` varchar(50) NOT NULL DEFAULT '' AFTER `ms_key` ");
}

// [NEW] 배경색 (Custom Color)
$row = sql_fetch(" SHOW COLUMNS FROM g5_plugin_main_content_sections LIKE 'ms_bg_color' ");
if (!$row) {
    sql_query(" ALTER TABLE g5_plugin_main_content_sections ADD `ms_bg_color` varchar(20) NOT NULL DEFAULT '' AFTER `ms_font_mode` ");
}

// 섹션 목록 가져오기
$sql = " select * from g5_plugin_main_content_sections order by ms_lang asc, ms_sort asc, ms_id desc ";
$result = sql_query($sql);

$admin_token = get_admin_token();
?>

<div class="local_desc01 local_desc">
    <p>메인 페이지에 노출될 디자인 섹션들을 관리합니다. 각 섹션별로 독립적인 스킨과 컨텐츠를 구성할 수 있습니다.</p>
</div>

<div class="btn_fixed_top">
    <a href="./write.php" class="btn_submit btn">메인 섹션 추가</a>
</div>

<div class="tbl_head01 tbl_wrap" style="width:100%; max-width:100%;">
    <h2 class="h2_frm">메인 섹션 목록</h2>

    <table style="width:100%;">
        <caption>메인 섹션 목록</caption>
        <colgroup>
            <col width="150"> <!-- ID -->
            <col width="80"> <!-- Lang -->
            <col> <!-- Title -->
            <col width="100"> <!-- Show Title -->
            <col width="100"> <!-- Sort -->
            <col width="100"> <!-- Status -->
            <col width="150"> <!-- Mng -->
        </colgroup>
        <thead>
            <tr>
                <th>식별 코드 (ID)</th>
                <th>언어</th>
                <th>메인 제목</th>
                <th>제목 노출</th>
                <th>노출 순서</th>
                <th>상태</th>
                <th>관리</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $row = sql_fetch_array($result); $i++) {
                $edit_url = "./write.php?w=u&ms_id=" . $row['ms_id'];
                $status = $row['ms_active'] ? '<span style="color:blue;">노출중</span>' : '<span style="color:#888;">숨김</span>';
                $show_title = $row['ms_show_title'] ? 'Y' : 'N';

                // Lang Label
                $lang_label = strtoupper($row['ms_lang']);
                $lang_color = ($row['ms_lang'] == 'kr') ? '#000' : '#d4af37';
                ?>
                <tr>
                    <td class="td_num"
                        style="font-family:var(--font-en); font-weight:bold; color:var(--color-accent-gold);">
                        <?php echo $row['ms_key'] ? $row['ms_key'] : 'S_' . sprintf("%05d", $row['ms_id']); ?>
                    </td>
                    <td class="td_num" style="font-weight:bold; color:<?php echo $lang_color; ?>;">
                        <?php echo $lang_label; ?>
                    </td>
                    <td class="td_left">
                        <a href="<?php echo $edit_url; ?>"
                            style="font-weight:bold;"><?php echo get_text($row['ms_title']); ?></a>
                    </td>
                    <td class="td_num"><?php echo $show_title; ?></td>
                    <td class="td_num"><?php echo $row['ms_sort']; ?></td>
                    <td class="td_num text-center"><?php echo $status; ?></td>
                    <td class="td_mng text-center">
                        <a href="<?php echo $edit_url; ?>" class="btn btn_03"
                            style="font-size:11px; padding:3px 8px;">수정</a>
                        <a href="./update.php?w=d&ms_id=<?php echo $row['ms_id']; ?>&token=<?php echo $admin_token; ?>"
                            class="btn btn_02" style="font-size:11px; padding:3px 8px; color:#fff;"
                            onclick="return confirm('이 섹션과 포함된 모든 아이템이 삭제됩니다. 정말 삭제하시겠습니까?');">삭제</a>
                    </td>
                </tr>
            <?php } ?>
            <?php if ($i == 0)
                echo '<tr><td colspan="8" class="empty_table">등록된 섹션이 없습니다.</td></tr>'; ?>
        </tbody>
    </table>
</div>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>