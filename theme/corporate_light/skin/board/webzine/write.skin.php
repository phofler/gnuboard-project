<?php
if (!defined('_GNUBOARD_'))
    exit;
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css?v=' . time() . '">', 0);
add_stylesheet('<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">', 0);
add_javascript('<script src="' . G5_THEME_URL . '/js/category_cascade.js?v=' . time() . '"></script>', 0);
?>

<section id="bo_w" class="skin-container">
    <div class="write-header">
        <h1 class="wz-view-title" style="font-size:3rem; margin-bottom:10px;">New Entry</h1>
        <p style="color:#999; text-transform:uppercase; letter-spacing:2px; font-size:0.85rem;">Webzine Editorial Mode
        </p>
    </div>

    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);"
        method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
        <input type="hidden" name="w" value="<?php echo $w ?>">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
        <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
        <input type="hidden" name="sca" value="<?php echo $sca ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
        <input type="hidden" name="stx" value="<?php echo $stx ?>">
        <input type="hidden" name="page" value="<?php echo $page ?>">
        <?php if (isset($_GET['me_code'])) { ?>
            <input type="hidden" name="me_code" value="<?php echo $_GET['me_code']; ?>">
        <?php } ?>

        <div class="form-group">
            <label class="form-label">Category</label>
            <?php if ($is_category) { ?>
                <input type="text" name="ca_name" id="ca_name"
                    value="<?php echo isset($write['ca_name']) ? $write['ca_name'] : ''; ?>" required style="display:none;">
                <input type="hidden" name="wr_1" id="wr_1"
                    value="<?php echo isset($write['wr_1']) ? $write['wr_1'] : ''; ?>">
                <div id="category_container" style="display:flex; gap:10px;"></div>
                <script>
                    $(document).ready(function () {
                        if (typeof initCascadingCategory === 'function') {
                            initCascadingCategory({
                                bo_table: "<?php echo $bo_table; ?>",
                                ajaxUrl: "<?php echo G5_PLUGIN_URL; ?>/tree_category/ajax_get_tree.php",
                                initialCaName: "<?php echo isset($write['ca_name']) ? addslashes($write['ca_name']) : ''; ?>",
                                initialCode: "<?php echo isset($write['wr_1']) ? $write['wr_1'] : ''; ?>",
                                validCategories: <?php echo json_encode(explode('|', $board['bo_category_list']), JSON_UNESCAPED_UNICODE); ?>
                                });
                            }
                        });
                </script>
            <?php } ?>
        </div>

        <div class="form-group">
            <label class="form-label">Headline</label>
            <input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="inp-txt"
                placeholder="Enter article headline..."
                style="width:100%; padding:15px; border:1px solid #ddd; font-size:1.1rem; border-radius:4px; font-family:var(--font-serif);">
        </div>

        <div class="form-group">
            <label class="form-label">Featured Image (List Thumbnail)</label>
            <div class="inp-file"
                style="position:relative; background:#f9f9f9; padding:40px; border:2px dashed #ddd; text-align:center; cursor:pointer; border-radius:4px;">
                <input type="file" name="bf_file[]" id="bf_file_0" title="File 1"
                    style="position:absolute; top:0; left:0; width:100%; height:100%; opacity:0; cursor:pointer;"
                    onchange="preview_wz(this, 'preview_0')">
                <div id="preview_0_wrap">
                    <span style="font-size:30px; color:#ccc;">📷</span><br>
                    <span style="color:#999; font-size:0.9rem;">Click to upload main image</span>
                </div>
                <img id="preview_0" src="" style="display:none; max-width:100%; max-height:200px; margin:0 auto;">
            </div>
            <?php if ($w == 'u' && $file[0]['file']) { ?>
                <div style="margin-top:10px; font-size:0.85rem; color:#888;">
                    <input type="checkbox" name="bf_file_del[0]" value="1" id="del_0"> <label for="del_0">
                        <?php echo $file[0]['source']; ?> DELETE
                    </label>
                </div>
            <?php } ?>
        </div>

        <div class="form-group">
            <label class="form-label">Article Narrative</label>
            <?php echo $editor_html; ?>
        </div>

        <div style="margin-top:60px; display:flex; gap:15px; justify-content:center; padding-bottom:100px;">
            <?php
            $cancel_url = get_pretty_url($bo_table);
            if (isset($_GET['me_code']))
                $cancel_url .= (strpos($cancel_url, '?') === false ? '?' : '&') . 'me_code=' . urlencode($_GET['me_code']);
            $cancel_url .= '#bo_cate';
            ?>
            <a href="<?php echo $cancel_url; ?>" class="btn btn-can"
                style="display:inline-block; padding:12px 40px; background:#eee; color:#333; text-decoration:none; border-radius:4px; font-weight:600;">Discard</a>
            <button type="submit" id="btn_submit" class="btn btn-sub"
                style="padding:12px 60px; background:#111; color:#fff; border:none; border-radius:4px; font-weight:600; cursor:pointer;">Publish
                Article</button>
        </div>
    </form>
</section>

<script>
    function preview_wz(input, previewId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#' + previewId).attr('src', e.target.result).show();
                $('#' + previewId + '_wrap').hide();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function fwrite_submit(f) {
    <?php echo $editor_js; ?>
    if (f.wr_subject.value.trim() === '') { alert('Please enter a headline.'); f.wr_subject.focus(); return false; }
        document.getElementById("btn_submit").disabled = "disabled";
        return true;
    }
</script>