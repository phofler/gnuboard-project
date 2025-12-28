<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// 본문 스타일(style.css)에 이미 .portfolio-grid 스타일이 정의되어 있다고 가정합니다.
// 만약 별도의 스타일이 필요하다면 여기에 추가하세요.

$thumb_width = 800; // 포트폴리오용 고해상도 썸네일
$thumb_height = 600;
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<div class="portfolio-grid">
    <?php
    for ($i = 0; $i < $list_count; $i++) {
        $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

        if ($thumb['src']) {
            $img = $thumb['src'];
        } else {
            $img = G5_IMG_URL . '/no_img.png';
            $thumb['alt'] = '이미지가 없습니다.';
        }

        // 링크 생성
        $wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);
        ?>
        <div class="portfolio-item" data-aos="zoom-in">
            <img src="<?php echo $img; ?>" alt="<?php echo $thumb['alt']; ?>">
            <div class="portfolio-overlay" onclick="location.href='<?php echo $wr_href; ?>';" style="cursor:pointer;">
                <h4><?php echo $list[$i]['subject']; ?></h4>
                <p><?php echo cut_str(strip_tags($list[$i]['wr_content']), 50); ?></p>
            </div>
        </div>
    <?php } ?>

    <?php if ($list_count == 0) { // 게시물이 없을 때 ?>
        <div style="text-align:center; padding:50px; color:#888; grid-column: 1 / -1;">
            게시물이 없습니다.
        </div>
    <?php } ?>
</div>