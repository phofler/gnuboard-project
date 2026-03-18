<?php
if (!defined('_GNUBOARD_')) exit;

$active_me1 = null;
$active_me2 = null;

if(isset($active_me_code)) {
    $me1_code = substr($active_me_code, 0, 2);
    $active_me1 = sql_fetch(" SELECT * FROM {$g5['menu_table']} WHERE me_code = '{$me1_code}' ");
    if(strlen($active_me_code) >= 4) {
        $active_me2 = sql_fetch(" SELECT * FROM {$g5['menu_table']} WHERE me_code = '{$active_me_code}' ");
    }
}
?>

<style>
.breadcrumb-simple-wrap { background: #f8f9fa; border-bottom: 1px solid #eee; padding: 12px 0; font-size: 0.85rem; color: #888; }
.breadcrumb-simple-area { display: flex; align-items: center; gap: 8px; }
.breadcrumb-simple-area a { color: #666; transition: 0.2s; }
.breadcrumb-simple-area a:hover { color: var(--primary-color, #003366); text-decoration: underline; }
.breadcrumb-simple-area .sep { color: #ccc; font-size: 0.7rem; }
.breadcrumb-simple-area .current { color: #333; font-weight: bold; }
</style>

<div class="breadcrumb-simple-wrap">
    <div class="container">
        <div class="breadcrumb-simple-area">
            <a href="<?php echo G5_URL; ?>"><i class="fas fa-home"></i> Home</a>
            <?php if($active_me1) { ?>
                <span class="sep"><i class="fas fa-chevron-right"></i></span>
                <a href="<?php echo $active_me1['me_link']; ?>"><?php echo $active_me1['me_name']; ?></a>
            <?php } ?>
            <?php if($active_me2) { ?>
                <span class="sep"><i class="fas fa-chevron-right"></i></span>
                <span class="current"><?php echo $active_me2['me_name']; ?></span>
            <?php } ?>
        </div>
    </div>
</div>