<?php
include_once('./common.php');
include_once('./extend/project_ui.extend.php');

ob_start();
display_hero_visual('kukdong_panel');
$out = ob_get_clean();

if (strpos($out, 'effect-fade') !== false) {
    echo "SUCCESS: class effect-fade is present\n";
} else {
    echo "ERROR: class effect-fade is MISSING\n";
}
echo substr($out, 0, 1000);
