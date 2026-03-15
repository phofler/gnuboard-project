<?php
include_once('./_common.php');

if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가

// Page Title (Browser Tab)
$g5['title'] = "Online Inquiry";
include_once(G5_THEME_PATH . '/head.php');
?>

<!-- Sub Visual / Breadcrumb (Managed by sub_design plugin via head.php) -->
<!-- If manual override needed: -->
<!-- <div class="sub_visual">...</div> -->

<div id="contact_wrapper" class="sub-layout-width-height">
    <!-- Premium Edge Bar Title Area -->
    <div class="contact-header" style="text-align:center; margin-bottom:80px; position:relative;">
        <h2
            style="font-family:var(--font-heading); font-size:3rem; color:var(--color-text-primary); font-weight:700; letter-spacing:1px; margin-bottom:20px; text-transform:uppercase;">
            Online Inquiry
        </h2>
        <p style="color:var(--color-text-secondary); font-size:1.1rem; margin-bottom:40px;">
            프로젝트에 대한 궁금한 점을 남겨주시면 자세히 상담해 드립니다.
        </p>
        <!-- Gold Edge Bar -->
        <div style="width:60px; height:4px; background:var(--color-accent-gold); margin:0 auto; border-radius:2px;">
        </div>
    </div>

    <!-- Online Inquiry Plugin Loader -->
    <div class="contact-form-container" style="max-width:1000px; margin:0 auto;">
        <?php
        // Skin Selection: 'corporate' (Matches theme design)
        $online_inquiry_skin = 'corporate';

        // Plugin Path Check
        $form_path = G5_PLUGIN_PATH . '/online_inquiry/form.php';
        if (file_exists($form_path)) {
            include_once($form_path);
        } else {
            echo '<div style="text-align:center; padding:50px; background:#222; color:#fff;">Online Inquiry Plugin Not Found.</div>';
        }
        ?>
    </div>
</div>

<?php
include_once(G5_THEME_PATH . '/tail.php');
?>