<?php
if (!defined('_GNUBOARD_')) exit;

/**
 * Font Manager Library
 * Centralized control for site-wide typography (e.g., Apple-style Pretendard)
 */

if (!function_exists('g5_apply_font')) {
    /**
     * Register and Load Font
     * @param string $font_id (default: pretendard)
     */
    function g5_apply_font($font_id = 'pretendard') {
        global $g5;
        
        $fonts_config = [
            'pretendard' => [
                'name' => 'Pretendard Variable',
                'cdn' => 'https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.9/dist/web/static/variable/pretendardvariable.min.css',
                'family' => "'Pretendard Variable', Pretendard, -apple-system, BlinkMacSystemFont, system-ui, Roboto, 'Helvetica Neue', 'Segoe UI', 'Apple SD Gothic Neo', 'Noto Sans KR', 'Malgun Gothic', sans-serif"
            ],
            'noto' => [
                'name' => 'Noto Sans KR',
                'cdn' => 'https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300;400;700;900&display=swap',
                'family' => "'Noto Sans KR', sans-serif"
            ]
        ];
        
        $font = $fonts_config[$font_id] ?? $fonts_config['noto'];
        
        // Inject CDN Link using add_stylesheet (GNUBOARD internal function)
        add_stylesheet('<link rel="stylesheet" href="' . $font['cdn'] . '">', 0);
        
        // Prepare CSS Variable for injection
        $html = "\n<style>\n";
        $html .= "    :root {\n";
        $html .= "        --font-family-main: " . $font['family'] . ";\n";
        $html .= "    }\n";
        $html .= "</style>\n";
        
        // Store in global metadata to be printed in head.sub.php
        $g5['style_font_vars'] = $html;
    }
}
?>