<?php
if (!defined('_GNUBOARD_')) exit;
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$thumb_width = 400;
$thumb_height = 300;
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<div class="items-grid">
    <?php
    for ($i=0; $i<$list_count; $i++) {
        $wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);
        $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

        if(isset($thumb['src']) && $thumb['src']) {
            $img = $thumb['src'];
        } else {
            $img = G5_THEME_URL.'/1.jpg'; // 기본 이미지
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
    <?php if ($list_count == 0) { echo "<p class='empty_li'>등록된 제품이 없습니다.</p>"; } ?>
</div>