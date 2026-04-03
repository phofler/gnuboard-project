<?php
if (!defined('_GNUBOARD_')) exit;
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// Load shared skin header (Standardized Typography & Title Area)
// 테마 루트의 skin.head.php가 없을 경우를 대비해 스코프 체크
$head_path = G5_THEME_PATH.'/skin.head.php';
if (!file_exists($head_path)) {
    $head_path = G5_PLUGIN_PATH.'/latest_skin_manager/skins/skin.head.php';
}
include_once($head_path);

global $txt_title, $txt_desc, $list, $skin_cls;

$thumb_width = 400;
$thumb_height = 300;
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<div class="section-title reveal slide-up">
    <h2><?php echo $txt_title; ?></h2>
    <?php if ($txt_desc) { ?>
    <p><?php echo $txt_desc; ?></p>
    <?php } ?>
</div>

<div class="items-grid <?php echo $skin_cls; ?>">
    <?php
    for ($i=0; $i<$list_count; $i++) {
        $wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);
        $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

        if(isset($thumb['src']) && $thumb['src']) {
            $img = $thumb['src'];
        } else {
            $img = G5_THEME_URL.'/img/no-image.jpg'; // 기본 이미지 경로 수정 권장
        }
    ?>
    <div class="item-card reveal slide-up" style="transition-delay: <?php echo ($i+1)*0.1 ?>s;">
        <a href="<?php echo $wr_href ?>">
            <div class="img-box"><img src="<?php echo $img ?>" alt="<?php echo $list[$i]['subject'] ?>"></div>
            <div class="info">
                <h4><?php echo $list[$i]['subject'] ?></h4>
            </div>
        </a>
    </div>
    <?php } ?>
    <?php if ($list_count == 0) { ?>
        <p class='empty_li'>등록된 제품이 없습니다.</p>
    <?php } ?>
</div>