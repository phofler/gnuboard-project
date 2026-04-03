<?php
include_once("./common.php");
include_once(G5_PLUGIN_PATH."/sub_design/lib/design.lib.php");

$sd = get_sub_design();
if ($sd) {
    echo "get_sub_design: OK\n";
} else {
    echo "get_sub_design: FAILED (Check DB)\n";
}

if (function_exists("get_sub_design_image_url")) {
    echo "get_sub_design_image_url: EXISTS\n";
} else {
    echo "get_sub_design_image_url: MISSING\n";
}
?>