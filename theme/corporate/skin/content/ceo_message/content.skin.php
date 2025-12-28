<?php
if (!defined('_GNUBOARD_'))
    exit;
add_stylesheet('<link rel="stylesheet" href="' . $content_skin_url . '/style.css">', 0);
?>

<div class="sub-layout-width-height ceo-page-wrapper">
    <div class="ceo-container">
        <!-- Admin Content Injection -->
        <div class="message-body">
            <?php echo $str; ?>
        </div>
    </div>
</div>