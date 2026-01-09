<?php
$sub_menu = '800200';
define('G5_IS_ADMIN', true);
include_once('./_common.php');
include_once(G5_ADMIN_PATH . '/admin.lib.php');

// Table Definition
if (!defined('G5_PLUGIN_SUB_DESIGN_GROUP_TABLE')) {
    define('G5_PLUGIN_SUB_DESIGN_GROUP_TABLE', G5_TABLE_PREFIX . 'plugin_sub_design_groups');
}
if (!defined('G5_PLUGIN_SUB_DESIGN_ITEM_TABLE')) {
    define('G5_PLUGIN_SUB_DESIGN_ITEM_TABLE', G5_TABLE_PREFIX . 'plugin_sub_design_items');
}

// [NEW] Group Table Creation
if (!sql_query(" DESCRIBE " . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . " ", false)) {
    $sql = " CREATE TABLE IF NOT EXISTS `" . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . "` (
                `sd_id` varchar(100) NOT NULL DEFAULT '',
                `sd_theme` varchar(50) NOT NULL DEFAULT '',
                `sd_lang` varchar(10) NOT NULL DEFAULT 'kr',
                `sd_skin` varchar(50) NOT NULL DEFAULT 'standard',
                `sd_created` datetime NOT NULL,
                `sd_updated` datetime NOT NULL,
                PRIMARY KEY (`sd_id`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ";
    sql_query($sql, true);
}

// [NEW] Item Table Creation
if (!sql_query(" DESCRIBE " . G5_PLUGIN_SUB_DESIGN_ITEM_TABLE . " ", false)) {
    $sql = " CREATE TABLE IF NOT EXISTS `" . G5_PLUGIN_SUB_DESIGN_ITEM_TABLE . "` (
                `sdi_id` int(11) NOT NULL AUTO_INCREMENT,
                `sd_id` varchar(100) NOT NULL DEFAULT '',
                `me_code` varchar(255) NOT NULL DEFAULT '',
                `sd_main_text` varchar(255) NOT NULL DEFAULT '',
                `sd_sub_text` varchar(255) NOT NULL DEFAULT '',
                `sd_visual_img` varchar(255) NOT NULL DEFAULT '',
                `sd_visual_url` varchar(255) NOT NULL DEFAULT '',
                PRIMARY KEY (`sdi_id`),
                KEY `sd_id` (`sd_id`),
                KEY `me_code` (`me_code`)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ";
    sql_query($sql, true);
}

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '서브디자인 관리';
include_once(G5_ADMIN_PATH . '/admin.head.php');

// Fetch Sub Design Groups
$sql = " SELECT * FROM " . G5_PLUGIN_SUB_DESIGN_GROUP_TABLE . " ORder by sd_lang asc, sd_id desc ";
$result = sql_query($sql);
?>

<div class="local_desc01 local_desc">
    <p>서브페이지 상단 영역(Hero Section)의 비주얼 문구와 배경 이미지를 관리합니다. 테마 및 언어별로 그룹화하여 관리할 수 있습니다.</p>
</div>

<div class="btn_fixed_top">
    <a href="./write.php" class="btn_submit btn">서브 디자인 추가</a>
</div>

<div class="tbl_head01 tbl_wrap" style="width:100%; max-width:100%;">
    <h2 class="h2_frm">서브 디자인 그룹 목록</h2>
    <table style="width:100%;">
        <caption><?php echo $g5['title']; ?> 목록</caption>
        <colgroup>
            <col width="150"> <!-- ID -->
            <col width="100"> <!-- Lang -->
            <col width="150"> <!-- Theme -->
            <col> <!-- Skin -->
            <col width="150"> <!-- Created -->
            <col width="150"> <!-- Management -->
        </colgroup>
        <thead>
            <tr>
                <th scope="col">식별 코드 (ID)</th>
                <th scope="col">언어</th>
                <th scope="col">적용 테마</th>
                <th scope="col">사용 스킨</th>
                <th scope="col">생성일</th>
                <th scope="col">관리</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $row = sql_fetch_array($result); $i++) {
                $edit_url = "./write.php?w=u&sd_id=" . $row['sd_id'];

                // Lang Label
                $langs = array('kr' => '한국어 (기본)', 'en' => 'English (EN)', 'jp' => 'Japanese (JP)', 'cn' => 'Chinese (CN)');
                $lang_label = isset($langs[$row['sd_lang']]) ? $langs[$row['sd_lang']] : strtoupper($row['sd_lang']);
                $lang_color = ($row['sd_lang'] == 'kr') ? '#000' : '#d4af37';
                ?>
                <tr class="bg<?php echo $i % 2; ?>">
                    <td class="td_num"
                        style="font-family:var(--font-en); font-weight:bold; color:var(--color-accent-gold);">
                        <?php echo $row['sd_id']; ?>
                    </td>
                    <td class="td_num" style="font-weight:bold; color:<?php echo $lang_color; ?>;">
                        <?php echo $lang_label; ?>
                    </td>
                    <td class="td_num"><?php echo $row['sd_theme']; ?></td>
                    <td class="td_num"><?php echo $row['sd_skin']; ?></td>
                    <td class="td_datetime"><?php echo substr($row['sd_created'], 0, 10); ?></td>
                    <td class="td_mng text-center">
                        <a href="<?php echo $edit_url; ?>" class="btn btn_03"
                            style="font-size:11px; padding:3px 8px;">수정</a>
                        <a href="./update.php?w=d&sd_id=<?php echo $row['sd_id']; ?>&token=<?php echo get_admin_token(); ?>"
                            class="btn btn_02" style="font-size:11px; padding:3px 8px; color:#fff;"
                            onclick="return confirm('이 그룹의 모든 서브 디자인 설정이 삭제됩니다. 정말 삭제하시겠습니까?');">삭제</a>
                    </td>
                </tr>
            <?php } ?>
            <?php if ($i == 0)
                echo '<tr><td colspan="6" class="empty_table">등록된 서브 디자인 그룹이 없습니다. [서브 디자인 추가] 버튼을 눌러 새 설정을 시작하세요.</td></tr>'; ?>
        </tbody>
    </table>
</div>


<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>