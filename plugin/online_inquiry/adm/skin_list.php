<?php
$sub_menu = '800300'; // Menu ID matches list.php
define('G5_IS_ADMIN', true);
include_once(dirname(__FILE__) . '/../_common.php');

if (!defined('G5_ADMIN_PATH')) {
    define('G5_ADMIN_PATH', G5_PATH . '/adm');
}
include_once(G5_ADMIN_PATH . '/admin.lib.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '온라인 문의 스킨 설정';
include_once(G5_ADMIN_PATH . '/admin.head.php');

$config_table = G5_TABLE_PREFIX . 'plugin_online_inquiry_config';

// [Action] Delete Configuration
if (isset($_GET['mode']) && $_GET['mode'] == 'delete' && isset($_GET['oi_id'])) {
    $oi_id = clean_xss_tags($_GET['oi_id']);
    sql_query(" delete from {$config_table} where oi_id = '{$oi_id}' ");
    goto_url('./skin_list.php');
}

// [Load] Current Configurations
$list = array();
$sql = " select * from {$config_table} order by theme asc, lang asc ";
$result = sql_query($sql);
while ($row = sql_fetch_array($result)) {
    $list[] = $row;
}
?>

<div class="local_desc01 local_desc">
    <p>테마와 언어별로 사용할 스킨과 안내 문구를 설정합니다.</p>
</div>

<div class="btn_fixed_top">
    <a href="./list.php" class="btn btn_02">문의 목록으로 돌아가기</a>
    <a href="./config_write.php" class="btn_submit btn"
        style="background-color:#ff3061; border-color:#ff3061; color:#fff;">설정 추가</a>
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
        <caption>스킨 설정 목록</caption>
        <colgroup>
            <col width="150">
            <col width="100">
            <col>
            <col width="150">
            <col width="150">
            <col width="100">
        </colgroup>
        <thead>
            <tr>
                <th scope="col">식별코드 (ID)</th>
                <th scope="col">언어 (테마)</th>
                <th scope="col">페이지 제목</th>
                <th scope="col">적용 스킨</th>
                <th scope="col">등록일</th>
                <th scope="col">관리</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($list as $row) {
                $lang_color = ($row['lang'] == 'kr') ? '#000' : '#d4af37';
                ?>
                <tr>
                    <td class="td_id" style="font-weight:bold;"><?php echo $row['oi_id']; ?></td>
                    <td class="td_center" style="font-weight:bold; color:<?php echo $lang_color; ?>">
                        <?php echo strtoupper($row['lang']); ?> (<?php echo $row['theme']; ?>)
                    </td>
                    <td class="td_left" style="font-weight:bold;"><?php echo ($row['subject']) ? $row['subject'] : '-'; ?>
                    </td>
                    <td class="td_center"><?php echo $row['skin']; ?></td>
                    <td class="td_datetime"><?php echo $row['reg_date']; ?></td>
                    <td class="td_mng">
                        <a href="./config_write.php?w=u&oi_id=<?php echo $row['oi_id']; ?>" class="btn btn_03">수정</a>
                        <a href="./skin_list.php?mode=delete&oi_id=<?php echo $row['oi_id']; ?>"
                            onclick="return confirm('정말 삭제하시겠습니까?');" class="btn btn_02">삭제</a>
                    </td>
                </tr>
            <?php } ?>
            <?php if (count($list) == 0)
                echo '<tr><td colspan="6" class="empty_table">등록된 설정이 없습니다. [설정 추가] 버튼을 눌러 시작하세요.</td></tr>'; ?>
        </tbody>
    </table>
</div>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>