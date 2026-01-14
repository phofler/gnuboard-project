<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$sub_menu = "950195";
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '보드 스킨 관리';
include_once(G5_ADMIN_PATH . '/admin.head.php');

// [Standardization] Config Table Setup
$config_table = G5_TABLE_PREFIX . 'plugin_board_skin_config';
sql_query(" CREATE TABLE IF NOT EXISTS `{$config_table}` (
  `bs_id` varchar(255) NOT NULL,
  `bs_theme` varchar(50) NOT NULL,
  `bs_lang` varchar(10) NOT NULL,
  `bo_table` varchar(50) NOT NULL,
  `bs_skin` varchar(50) NOT NULL,
  `bs_layout` varchar(20) NOT NULL,
  `bs_cols` int(11) NOT NULL DEFAULT '4',
  `bs_ratio` varchar(20) NOT NULL DEFAULT '4x3',
  `bs_theme_mode` varchar(20) NOT NULL DEFAULT '',
  `reg_date` datetime NOT NULL,
  PRIMARY KEY (`bs_id`),
  KEY `index_theme_lang` (`bs_theme`, `bs_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ");

// [Schema Update] Add columns if missing (Support for Legacy)
// [Schema Update] Add columns if missing (Support for Legacy)
$exists_cols = sql_query(" SHOW COLUMNS FROM {$config_table} LIKE 'bs_theme' ", false);
if (!sql_num_rows($exists_cols)) {
    sql_query(" ALTER TABLE {$config_table} ADD `bs_theme` varchar(50) NOT NULL DEFAULT 'corporate' AFTER `bs_id` ");
    sql_query(" ALTER TABLE {$config_table} ADD `bs_lang` varchar(10) NOT NULL DEFAULT 'ko' AFTER `bs_theme` ");
    sql_query(" ALTER TABLE {$config_table} ADD INDEX `index_theme_lang` (`bs_theme`, `bs_lang`) ");
}

$exists_reg = sql_query(" SHOW COLUMNS FROM {$config_table} LIKE 'reg_date' ", false);
if (!sql_num_rows($exists_reg)) {
    sql_query(" ALTER TABLE {$config_table} ADD `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ");
}

// [Schema Update] Full Integrity Check
$required_cols = array(
    'bo_table' => "varchar(50) NOT NULL AFTER `bs_lang`",
    'bs_skin' => "varchar(50) NOT NULL AFTER `bo_table`",
    'bs_layout' => "varchar(20) NOT NULL AFTER `bs_skin`",
    'bs_cols' => "int(11) NOT NULL DEFAULT '4' AFTER `bs_layout`",
    'bs_ratio' => "varchar(20) NOT NULL DEFAULT '4x3' AFTER `bs_cols`",
    'bs_theme_mode' => "varchar(20) NOT NULL DEFAULT '' AFTER `bs_ratio`"
);

foreach ($required_cols as $col_name => $col_def) {
    $exists = sql_query(" SHOW COLUMNS FROM {$config_table} LIKE '{$col_name}' ", false);
    if (!sql_num_rows($exists)) {
        sql_query(" ALTER TABLE {$config_table} ADD `{$col_name}` {$col_def} ");
    }
}

// Filter by Search
$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and (bs_id like '%{$stx}%' or bo_table like '%{$stx}%') ";
}

$sql = " select count(*) as cnt from {$config_table} {$sql_search} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page = ceil($total_count / $rows);
if ($page < 1)
    $page = 1;
$from_record = ($page - 1) * $rows;

$sql = " select * from {$config_table} {$sql_search} order by reg_date desc limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$admin_token = get_admin_token();
?>

<div class="btn_fixed_top">
    <a href="./write.php" class="btn btn_01">스킨 등록</a>
</div>

<div class="local_desc01 local_desc">
    <p>게시판의 <b>스킨 옵션(Display Options)</b>을 쉽고 빠르게 설정합니다.</p>
    <p>레이아웃(Gallery/List), 컬럼 수, 비율 등의 디자인 속성을 제어할 수 있습니다.</p>
</div>

<div class="tbl_head01 tbl_wrap">
    <table style="width:100%;">
        <caption>
            <?php echo $g5['title']; ?> 목록
        </caption>
        <colgroup>
            <col width="150"> <!-- ID -->
            <col width="200"> <!-- Board -->
            <col> <!-- Summary -->
            <col width="100"> <!-- Date -->
            <col width="80"> <!-- Manage -->
        </colgroup>
        <thead>
            <tr>
                <th>식별코드 (ID)</th>
                <th>대상 게시판</th>
                <th>설정 요약</th>
                <th>등록일</th>
                <th>관리</th>
            </tr>
        </thead>
        <?php
        for ($i = 0; $row = sql_fetch_array($result); $i++) {
            $edit_url = "./write.php?w=u&bs_id=" . $row['bs_id'];

            // Get Board Subject and Skin
            $bo = sql_fetch(" select bo_subject, bo_skin from {$g5['board_table']} where bo_table = '{$row['bo_table']}' ");

            // Theme/Lang Bagde
            $badge = '<span style="font-size:11px; color:#666; display:block; margin-top:2px;">[' . $row['bs_theme'] . ' / ' . strtoupper($row['bs_lang']) . ']</span>';
            ?>
            <tr class="bg<?php echo $i % 2; ?>">
                <td class="td_left">
                    <strong><?php echo $row['bs_id']; ?></strong>
                    <?php echo $badge; ?>
                </td>
                <td class="td_left">
                    <?php echo isset($bo['bo_subject']) ? $bo['bo_subject'] : '<span style="color:#d22;">(게시판 삭제됨)</span>'; ?>
                    <span style="font-size:11px; color:#999; display:block;"><?php echo $row['bo_table']; ?></span>
                </td>
                <td class="td_left">
                    <div style="font-weight:bold; color:#007bff; margin-bottom:4px;">
                        [Skin] <?php echo isset($bo['bo_skin']) ? $bo['bo_skin'] : 'Unknown'; ?>
                    </div>
                    레이아웃: <?php echo $row['bs_layout']; ?>,
                    컬럼: <?php echo $row['bs_cols']; ?>,
                    비율: <?php echo $row['bs_ratio']; ?>
                </td>
                <td class="td_datetime">
                    <?php echo substr($row['reg_date'], 0, 10); ?>
                </td>
                <td class="td_mng">
                    <a href="<?php echo $edit_url; ?>" class="btn btn_03">수정</a>
                    <a href="./update.php?w=d&bs_id=<?php echo urlencode($row['bs_id']); ?>"
                        onclick="return confirm('정말 삭제하시겠습니까?\n\n복구할 수 없습니다.');" class="btn btn_02">삭제</a>
                </td>
            </tr>
        <?php } ?>
        <?php if ($total_count == 0)
            echo '<tr><td colspan="5" class="empty_table">설정된 스킨 옵션이 없습니다. <a href="./write.php">새 옵션 추가</a></td></tr>'; ?>
        </tbody>
    </table>
</div>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;page='); ?>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>