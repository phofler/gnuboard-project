<?php
if (!defined('_GNUBOARD_')) exit;
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<?php if ($list_count > 0) { 
    $i = 0; 
    $wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);
?>
    <a href="<?php echo $wr_href ?>" class="link-box reveal slide-up" style="transition-delay: 0.3s;">
        <h4>공지사항</h4>
        <p><?php echo get_text($list[$i]['subject']) ?></p>
        <p>새로운 소식을 확인하세요.</p>
    </a>
<?php } else { ?>
    <a href="<?php echo get_pretty_url($bo_table); ?>" class="link-box reveal slide-up" style="transition-delay: 0.3s;">
        <h4>공지사항</h4>
        <p>등록된 공지가 없습니다.</p>
        <p>새로운 소식을 확인하세요.</p>
    </a>
<?php } ?>