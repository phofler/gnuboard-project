<?php
include_once('./_common.php');
include_once(G5_PLUGIN_PATH . '/main_content_manager/lib/main_content.lib.php');

echo "--- PATH NORMALIZATION TEST ---\n";

// Test 1: Absolute Localhost URL
$test1 = array('mc_image' => 'http://localhost/data/common_assets/theme_name/test_img.jpg');
$row1 = normalize_row_for_test($test1);
echo "Input: http://localhost/.../test_img.jpg\n";
echo "Output URL: {$row1['img_url']}\n\n";

// Test 2: Relative Filename
$test2 = array('mc_image' => 'new_image.jpg');
$row2 = normalize_row_for_test($test2);
echo "Input: new_image.jpg\n";
echo "Output URL: {$row2['img_url']}\n\n";

// Test 3: External URL
$test3 = array('mc_image' => 'https://unsplash.com/photo-123.jpg');
$row3 = normalize_row_for_test($test3);
echo "Input: https://unsplash.com/...\n";
echo "Output URL: {$row3['img_url']}\n\n";

function normalize_row_for_test($row) {
    global $config;
    $theme_name = isset($config['cf_theme']) ? $config['cf_theme'] : 'default';
    
    if ($row['mc_image']) {
        $raw_img = $row['mc_image'];
        if (preg_match("/^https?:\/\/localhost/i", $raw_img)) {
            $parts = explode('/common_assets/', $raw_img);
            if (count($parts) > 1) $raw_img = $parts[1];
        }
        if (preg_match("/^(http|https):/i", $raw_img)) {
            $row['img_url'] = $raw_img;
        } else {
            if (strpos($raw_img, '/') === false) {
                $row['img_url'] = G5_DATA_URL . '/common_assets/' . $theme_name . '/' . $raw_img;
            } else {
                $row['img_url'] = G5_DATA_URL . '/common_assets/' . $raw_img;
            }
        }
    }
    return $row;
}
?>
