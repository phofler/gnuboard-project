<?php
define('_GNUBOARD_ADMIN_', true);
$sub_menu = "800180";
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '메인 이미지 관리 (식별코드 기반)';
include_once(G5_ADMIN_PATH . '/admin.head.php');

$config_table = G5_TABLE_PREFIX . 'plugin_main_image_config';

// Safe Auto-install / Update
sql_query(" CREATE TABLE IF NOT EXISTS `{$config_table}` (
    `mi_id` varchar(50) NOT NULL,
    `mi_subject` varchar(255) NOT NULL,
    `mi_skin` varchar(50) NOT NULL,
    `mi_datetime` datetime NOT NULL,
    PRIMARY KEY (`mi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ");

// Ensure 'default' exists (Deprecated for Standardization)
// $exists = sql_fetch(" select mi_id from {$config_table} where mi_id = 'default' ");
// if (!$exists) {
//     $active_style_file = G5_PLUGIN_PATH . '/main_image_manager/active_style.php';
//     $active_skin = 'basic';
//     if (file_exists($active_style_file)) {
//         $active_skin = trim(file_get_contents($active_style_file));
//     }
//     sql_query(" insert into {$config_table} set mi_id = 'default', mi_subject = '기본 메인 비주얼', mi_skin = '{$active_skin}', mi_datetime = '" . G5_TIME_YMDHIS . "' ");
// }

// Delete Action
if (isset($_GET['del_id'])) {
    $del_id = clean_xss_tags($_GET['del_id']);
    sql_query(" delete from {$config_table} where mi_id = '{$del_id}' ");
    sql_query(" delete from g5_plugin_main_image_add where mi_style = '{$del_id}' ");
    alert('삭제되었습니다.', './list.php');
}

// Skin Names Map
$skin_names_map = array(
    'basic' => 'Basic (Split)',
    'full' => 'Smooth Fade',
    'fade' => 'Vertical Slide',
    'ultimate_hero' => 'Ultimate Hero'
);

$sql = " select * from {$config_table} order by mi_datetime desc ";
$result = sql_query($sql);
$total_count = sql_num_rows($result);
?>

<div class="local_ov01 local_ov">
    전체 <?php echo number_format($total_count) ?>건
</div>

<div class="btn_fixed_top">
    <a href="./write.php" class="btn btn_01">추가</a>
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
        <caption>메인 비주얼 그룹 목록</caption>
        <thead>
            <tr>
                <th scope="col">식별코드 (ID)</th>
                <th scope="col">그룹 제목</th>
                <th scope="col">적용 스킨</th>
                <th scope="col">등록일시</th>
                <th scope="col">관리</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $row = sql_fetch_array($result); $i++) {
                $skin_display = isset($skin_names_map[$row['mi_skin']]) ? $skin_names_map[$row['mi_skin']] : $row['mi_skin'];
                ?>
                <tr>
                    <td class="td_id"><?php echo $row['mi_id']; ?></td>
                    <td class="td_subject"><?php echo stripslashes($row['mi_subject']); ?></td>
                    <td class="td_category"><?php echo $skin_display; ?></td>
                    <td class="td_datetime"><?php echo $row['mi_datetime']; ?></td>
                    <td class="td_mng">
                        <a href="./write.php?w=u&mi_id=<?php echo $row['mi_id']; ?>" class="btn btn_03">수정</a>
                        <?php // if ($row['mi_id'] != 'default') { ?>
                        <a href="./list.php?del_id=<?php echo $row['mi_id']; ?>" class="btn btn_02"
                            onclick="return confirm('정말 삭제하시겠습니까?');">삭제</a>
                        <?php // } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="local_desc02 local_desc" style="margin-top:30px;">
    <p>💡 <strong>팁</strong>: 테마명(예: <code>corporate_light</code>)과 동일한 ID로 그룹을 생성하면 별도 설정 없이 해당 테마에서 자동으로 매칭됩니다.</p>
</div>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>