<?php
if (!defined('_GNUBOARD_'))
    exit;
add_stylesheet('<link rel="stylesheet" href="' . $content_skin_url . '/style.css">', 0);
?>

<div class="ceo-page-wrapper">
    <div class="ceo-container">
        <!-- Edge Bar Title (Added by User Request) -->
        <div class="message-heading">
            <?php echo $g5['title']; ?>
        </div>

        <!-- Admin Content Injection -->
        <div class="message-body">
            <?php
            // [FIX] Force remove duplicate wrapper
            $str = preg_replace('/class=["\'][^"\']*sub-layout-width-height[^"\']*["\']/', '', $str);
            echo $str;
            ?>
        </div>
    </div>
</div>