<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가

// [Company Intro Plugin Integration]
if (isset($_GET['id']) && $_GET['id']) {
    include_once(G5_PLUGIN_PATH . '/company_intro/lib/company.lib.php');
    $plugin_co = get_plugin_company_content($_GET['id']);
    if ($plugin_co) {
        $g5['title'] = $plugin_co['co_subject'];
        $str = $plugin_co['co_content'];
    }
}


// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $content_skin_url . '/style.css">', 0);
?>


<article id="ctt" class="ctt_<?php echo $co_id; ?>">
    <header>
        <h1><?php echo $g5['title']; ?></h1>
    </header>

    <div id="ctt_con"
        style="background-color:<?php echo (isset($plugin_co) && $plugin_co['co_bgcolor']) ? $plugin_co['co_bgcolor'] : 'transparent'; ?>;">
        <?php echo $str; ?>
    </div>

</article>