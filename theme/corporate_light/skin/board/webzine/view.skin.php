<?php
if (!defined('_GNUBOARD_'))
    exit;
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css?v=' . time() . '">', 0);
add_stylesheet('<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">', 0);

$view['content'] = conv_content($view['wr_content'], $html);

// Context URL
$list_url = $list_href;
if (isset($_GET['me_code']))
    $list_url .= '&me_code=' . urlencode($_GET['me_code']);
$list_url .= '#bo_cate';

$update_url = $update_href;
if ($update_url && isset($_GET['me_code']))
    $update_url .= '&me_code=' . urlencode($_GET['me_code']);
?>

<div class="skin-container">
    <div class="wz-view-grid">
        <!-- Main Content -->
        <main class="wz-view-main">
            <h1 class="wz-view-title">
                <?php echo $view['subject']; ?>
            </h1>

            <!-- Article Image if exists -->
            <?php
            if ($view['file'][0]['file']) {
                $img_url = G5_DATA_URL . '/file/' . $bo_table . '/' . $view['file'][0]['file'];
                echo '<div style="margin-bottom:60px;"><img src="' . $img_url . '" style="width:100%; border-radius:4px;"></div>';
            }
            ?>

            <div class="wz-view-content">
                <?php echo $view['content']; ?>
            </div>

            <div style="margin-top:100px; padding-top:40px; border-top:1px solid #eee; display:flex; gap:20px;">
                <a href="<?php echo $list_url ?>" style="font-weight:600; text-decoration:none; color:#111;">← BACK TO
                    LIST</a>
                <?php if ($update_url) { ?>
                    <a href="<?php echo $update_url ?>"
                        style="font-weight:600; text-decoration:none; color:var(--wz-primary);">✎ EDIT ARTICLE</a>
                <?php } ?>
            </div>
        </main>

        <!-- Sticky Sidebar -->
        <aside class="wz-view-sidebar">
            <span class="sidebar-label">Category</span>
            <span class="sidebar-value">
                <?php echo $view['ca_name'] ? $view['ca_name'] : 'Editorial'; ?>
            </span>

            <span class="sidebar-label">Published</span>
            <span class="sidebar-value" style="font-family:var(--font-serif); font-style:italic;">
                <?php echo date("F d, Y", strtotime($view['wr_datetime'])); ?>
            </span>

            <span class="sidebar-label">Author</span>
            <span class="sidebar-value">By
                <?php echo $view['name']; ?>
            </span>

            <span class="sidebar-label">Views</span>
            <span class="sidebar-value">
                <?php echo number_format($view['wr_hit']); ?> Reading
            </span>

            <div style="margin-top:60px;">
                <span class="sidebar-label">Quick Actions</span>
                <div style="display:flex; flex-direction:column; gap:12px;">
                    <a href="javascript:void(0);" onclick="copy_link()" class="sidebar-link"
                        style="color:#666; font-size:0.9rem; text-decoration:none;">Copy Page Link</a>
                    <?php if ($delete_href) {
                        $delete_url = $delete_href;
                        if (isset($_GET['me_code']))
                            $delete_url .= '&me_code=' . urlencode($_GET['me_code']);
                        ?>
                        <a href="<?php echo $delete_url ?>" onclick="return confirm('정말 삭제하시겠습니까?');"
                            style="color:#e74c3c; font-size:0.9rem; text-decoration:none;">Delete Article</a>
                    <?php } ?>
                </div>
            </div>
        </aside>
    </div>
</div>

<script>
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