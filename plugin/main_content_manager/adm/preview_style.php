<?php
include_once('./_common.php');
include_once(G5_PLUGIN_PATH . '/main_content_manager/lib/main_content.lib.php');

$style = isset($_GET['style']) ? clean_xss_tags($_GET['style']) : '';
$skin = isset($_GET['skin']) ? clean_xss_tags($_GET['skin']) : 'A';

// Fetch section data by ms_key
$ms = sql_fetch(" select * from g5_plugin_main_content_sections where ms_key = '{$style}' ");

if (!$ms) {
    // SAMPLE MODE if not saved yet
    $ms = array(
        'ms_id' => 'sample',
        'ms_title' => 'SAMPLE CONTENT SECTION',
        'ms_show_title' => 1,
        'ms_skin' => $skin,
        'ms_lang' => 'kr',
        'ms_theme' => 'corporate'
    );

    // Sample items
    $items = array();
    for ($i = 1; $i <= 3; $i++) {
        $items[] = array(
            'mc_id' => 'sample_' . $i,
            'mc_title' => 'Sample Title ' . $i,
            'mc_desc' => 'This is a sample description for the content section. It shows how your text will look with the selected skin.',
            'mc_link' => '#',
            'mc_target' => '_self',
            'img_url' => 'https://images.unsplash.com/photo-' . ($i == 1 ? '1504384308090-c89e959b84db' : ($i == 2 ? '1486406146926-c627a92ad1ab' : '1504917595217-d4dc5f9c47e0')) . '?q=80&w=800&auto=format&fit=crop'
        );
    }
} else {
    $items = get_main_content_list($ms['ms_id']);
}

// Ensure the requested skin is used for preview even if not saved
$ms['ms_skin'] = $skin;
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>Preview - Main Content</title>
    <link rel="stylesheet" href="<?php echo G5_THEME_URL ?>/css/default.css">
    <script src="<?php echo G5_JS_URL ?>/jquery-1.12.4.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body {
            padding: 0;
            margin: 0;
        }

        .preview-header {
            background: rgba(0, 0, 0, 0.85);
            backdrop-filter: blur(10px);
            color: #fff;
            padding: 12px 25px;
            font-size: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: 'Inter', sans-serif;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .skin-badge {
            background: #c8a27c;
            color: #000;
            padding: 2px 10px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }

        .btn-close-notice {
            color: #888;
            font-size: 11px;
            margin-left: 20px;
        }
    </style>
</head>

<body>
    <div class="preview-header">
        <div>
            <strong>PREVIEW MODE</strong> - ID: <span style="color:#f1c40f">
                <?php echo $style; ?>
            </span>
        </div>
        <div>
            USING SKIN: <span class="skin-badge">
                <?php echo $skin; ?>
            </span>
        </div>
    </div>

    <div id="preview_area">
        <?php
        // Render the section using the library function logic but with preview data
        render_main_section($ms);
        ?>
    </div>

    <script>
        $(function () {
            AOS.init();
        });
    </script>
</body>

</html>