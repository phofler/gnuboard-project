<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css?v=' . time() . '">', 0);
add_stylesheet('<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">', 0);

// 게시물 내용 및 파일 처리
$view['content'] = conv_content($view['wr_content'], $html);
?>



<div class="skin-container">

    <div class="content-header">
        <h1 class="page-title" style="margin-bottom:10px;"><?php echo $view['subject']; ?></h1>
        <div class="mag-meta" style="margin-bottom:30px;">
            <span>By <?php echo $view['name']; ?></span>
            <span><?php echo $view['datetime2']; ?></span>
            <span>Hit <?php echo $view['wr_hit']; ?></span>
        </div>
    </div>

    <!-- Main Image (Attached File 0) -->
    <?php
    if ($view['file'][0]['file']) {
        $image = $view['file'][0]['file'];
        $image_url = G5_DATA_URL . '/file/' . $bo_table . '/' . $image;
        echo '<div style="margin-bottom:50px;"><img src="' . $image_url . '" style="width:100%; border-radius:8px;"></div>';
    }
    ?>

    <!-- Content -->
    <div class="mag-content" style="padding:0; font-size:1.1rem; line-height:1.8;">
        <?php echo $view['content']; ?>
    </div>

    <!-- Gallery Loop (Remaining Files) -->
    <?php if ($view['file']['count'] > 1) { ?>
        <div class="mag-grid" style="margin-top:80px;">
            <?php
            for ($i = 1; $i < count($view['file']); $i++) {
                if ($view['file'][$i]['file']) {
                    $image = $view['file'][$i]['file'];
                    $image_url = G5_DATA_URL . '/file/' . $bo_table . '/' . $image;
                    echo '<div class="mag-item"><img src="' . $image_url . '" class="mag-thumb"></div>';
                }
            }
            ?>
        </div>
    <?php } ?>

    <!-- Buttons (Standard (4)) -->
    <div class="btn-group" style="margin-top:80px; border-top:1px solid var(--color-border, #eee); padding-top:40px;">
        <?php
        $list_url = $list_href;
        if (isset($_GET['me_code']))
            $list_url .= '&me_code=' . urlencode($_GET['me_code']);
        ?>
        <a href="<?php echo $list_url ?>" class="btn btn-cancel">List</a>
        <?php if ($update_href) {
            $update_url = $update_href;
            if (isset($_GET['me_code']))
                $update_url .= '&me_code=' . urlencode($_GET['me_code']);
            ?>
            <a href="<?php echo $update_url ?>" class="btn btn-submit">Edit</a>
        <?php } ?>
        <?php if ($delete_href) {
            $delete_url = $delete_href;
            if (isset($_GET['me_code']))
                $delete_url .= '&me_code=' . urlencode($_GET['me_code']);
            ?>
            <a href="<?php echo $delete_url ?>" class="btn btn-cancel" onclick="del(this.href); return false;">Delete</a>
        <?php } ?>
    </div>

</div>

<script>
    function del(href) {
        if (confirm("한번 삭제한 자료는 복구할 수 없습니다.\n\n정말 삭제하시겠습니까?")) {
            document.location.href = href;
        }
    }
</script>