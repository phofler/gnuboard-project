<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css?v=' . time() . '">', 0);
add_stylesheet('<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">', 0);

$view['content'] = conv_content($view['wr_content'], 1); // Fix: Force HTML mode (1) for editor content

// Context URL (Standard)
$list_url = $list_href;
if (isset($_GET['me_code']))
    $list_url .= '&me_code=' . urlencode($_GET['me_code']);
$list_url .= '#bo_list';

$update_url = $update_href;
if ($update_url && isset($_GET['me_code']))
    $update_url .= '&me_code=' . urlencode($_GET['me_code']);
$update_url .= '#bo_w'; // Anchor to Write Form

$delete_url = $delete_href;
if ($delete_url && isset($_GET['me_code']))
    $delete_url .= '&me_code=' . urlencode($_GET['me_code']);
?>

<div class="skin-container" id="bo_view">

    <div class="webzine-view-wrap">
        <!-- Main Content Area -->
        <div class="webzine-view-main">
            <!-- Category & Title -->
            <?php if ($view['ca_name']) { ?>
                <span class="view-cat"><?php echo $view['ca_name']; ?></span>
            <?php } ?>

            <h1 class="view-title"><?php echo $view['subject']; ?></h1>

            <!-- Top Image (Attached File 0) -->
            <?php
            if ($view['file'][0]['file']) {
                $image = $view['file'][0]['file'];
                $image_url = G5_DATA_URL . '/file/' . $bo_table . '/' . $image;
                echo '<div style="margin-bottom:50px;"><img src="' . $image_url . '" style="width:100%; border-radius:0;"></div>';
            }
            ?>

            <!-- Content -->
            <div class="view-content">
                <?php echo $view['content']; ?>
            </div>

            <!-- Additional Images (Gallery Grid) -->
            <?php if ($view['file']['count'] > 1) { ?>
                <div class="mag-grid" style="margin-top:60px;">
                    <?php
                    for ($i = 1; $i < $view['file']['count']; $i++) {
                        if (isset($view['file'][$i]['file']) && $view['file'][$i]['file']) {
                            $image = $view['file'][$i]['file'];
                            $image_url = G5_DATA_URL . '/file/' . $bo_table . '/' . $image;
                            echo '<div class="webzine-item"><img src="' . $image_url . '" style="width:100%;"></div>';
                        }
                    }
                    ?>
                </div>
            <?php } ?>

            <!-- Buttons -->
            <div class="btn-group" style="margin-top:60px; padding-top:30px; border-top:1px solid #eee;">
                <a href="<?php echo $list_url ?>" class="mc-btn mc-btn-outline">List</a>

                <?php if ($update_url) { ?>
                    <a href="<?php echo $update_url ?>" class="mc-btn mc-btn-primary">Edit</a>
                <?php } ?>

                <?php if ($delete_url) { ?>
                    <a href="<?php echo $delete_url ?>" class="mc-btn mc-btn-outline"
                        onclick="del(this.href); return false;">Delete</a>
                <?php } ?>
            </div>
        </div>

        <!-- Sticky Sidebar -->
        <aside class="webzine-view-side">
            <div class="meta-row">
                <span class="meta-label">Date</span>
                <span class="meta-value"><?php echo $view['datetime2']; ?></span>
            </div>

            <div class="meta-row">
                <span class="meta-label">Author</span>
                <span class="meta-value"><?php echo $view['name']; ?></span>
            </div>

            <div class="meta-row">
                <span class="meta-label">Views</span>
                <span class="meta-value"><?php echo number_format($view['wr_hit']); ?></span>
            </div>

            <div class="meta-row" style="margin-top:40px;">
                <span class="meta-label">Share</span>
                <div class="share-links">
                    <a href="#" onclick="copy_link(); return false;">🔗</a>
                </div>
            </div>
        </aside>
    </div>

</div>

<script>
    function del(href) {
        if (confirm("한번 삭제한 자료는 복구할 수 없습니다.\n\n정말 삭제하시겠습니까?")) {
            document.location.href = href;
        }
    }

    function copy_link() {
        const t = document.createElement("textarea");
        document.body.appendChild(t);
        t.value = window.location.href;
        t.select();
        document.execCommand("copy");
        document.body.removeChild(t);
        alert("URL이 복사되었습니다.");
    }
</script>