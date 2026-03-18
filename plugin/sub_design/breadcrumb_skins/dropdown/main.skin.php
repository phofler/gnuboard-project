<?php
if (!defined('_GNUBOARD_')) exit;

// GNB 메뉴 테이블 결정 (Universal)
if (defined('G5_PRO_MENU_TABLE')) {
    $menu_table = G5_PRO_MENU_TABLE;
    $code_col = 'ma_code';
    $name_col = 'ma_name';
    $link_col = 'ma_link';
    $use_col  = 'ma_use';
    $order_col = 'ma_order, ma_id';
} else {
    $menu_table = isset($g5['menu_table']) ? $g5['menu_table'] : G5_TABLE_PREFIX . 'menu';
    $code_col = 'me_code';
    $name_col = 'me_name';
    $link_col = 'me_link';
    $use_col  = 'me_use';
    $order_col = 'me_order, me_id';
}

// 1단계 메뉴 데이터 가져오기 (대분류)
$sql = " SELECT * FROM $menu_table WHERE `$use_col` = '1' AND LENGTH(`$code_col`) = 2 ORDER BY $order_col ";
$result1 = sql_query($sql);

$menu1_list = array();
$active_me1 = null;

while($row1 = sql_fetch_array($result1)) {
    // 현재 코드와 앞 2자리가 일치하면 활성 대분류
    $is_active = (isset($active_me_code) && substr($active_me_code, 0, 2) == $row1[$code_col]);
    
    // [데이터 구제] 코드가 안 맞으면 링크로 한 번 더 체크
    if (!$is_active && isset($active_me_code)) {
        if (strpos($row1[$link_col], 'me_code='.$active_me_code) !== false) $is_active = true;
    }

    $menu1_list[] = array(
        'code' => $row1[$code_col],
        'name' => $row1[$name_col],
        'link' => $row1[$link_col],
        'active' => $is_active
    );
    if($is_active) {
        $active_me1 = array(
            'code' => $row1[$code_col],
            'name' => $row1[$name_col]
        );
    }
}

// 2단계 메뉴 데이터 가져오기 (중분류)
$menu2_list = array();
$active_me2 = null;

if($active_me1) {
    $sql2 = " SELECT * FROM $menu_table WHERE `$use_col` = '1' AND `$code_col` LIKE '{$active_me1['code']}%' AND LENGTH(`$code_col`) = 4 ORDER BY $order_col ";
    $result2 = sql_query($sql2);
    while($row2 = sql_fetch_array($result2)) {
        $is_active2 = (isset($active_me_code) && $active_me_code == $row2[$code_col]);
        
        // [핵심 해결] 코드가 불일치해도 링크에 me_code가 포함되어 있으면 활성화 (데이터 불일치 방어)
        if (!$is_active2 && isset($active_me_code)) {
            // URL 파라미터로 me_code가 넘어오는 경우를 대비하여 다양한 형태 체크
            if (strpos($row2[$link_col], 'me_code='.$active_me_code) !== false || 
                strpos($_SERVER['REQUEST_URI'], 'me_code='.$row2[$code_col]) !== false) {
                $is_active2 = true;
            }
        }

        $menu2_list[] = array(
            'code' => $row2[$code_col],
            'name' => $row2[$name_col],
            'link' => $row2[$link_col],
            'active' => $is_active2
        );
        if($is_active2) {
            $active_me2 = array(
                'code' => $row2[$code_col],
                'name' => $row2[$name_col]
            );
        }
    }
}
?>

<link rel="stylesheet" href="<?php echo G5_PLUGIN_URL; ?>/sub_design/breadcrumb_skins/dropdown/style.css">

<div class="sub-lnb-wrap">
    <div class="container">
        <div class="breadcrumb-dropdown-area">
            <a href="<?php echo G5_URL; ?>" class="breadcrumb-home"><i class="fas fa-home"></i></a>
            
            <div class="breadcrumb-item <?php echo $active_me1 ? 'selected' : ''; ?>" id="bread1">
                <div class="breadcrumb-btn">
                    <span class="selected-label"><?php echo $active_me1 ? $active_me1['name'] : '메뉴 선택'; ?></span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <ul class="breadcrumb-list">
                    <?php foreach($menu1_list as $m1) { ?>
                        <li class="<?php echo $m1['active'] ? 'active' : ''; ?>"><a href="<?php echo $m1['link']; ?>"><?php echo $m1['name']; ?></a></li>
                    <?php } ?>
                </ul>
            </div>

            <?php if(!empty($menu2_list)) { ?>
            <div class="breadcrumb-item <?php echo $active_me2 ? 'selected' : ''; ?>" id="bread2">
                <div class="breadcrumb-btn">
                    <span class="selected-label"><?php echo $active_me2 ? $active_me2['name'] : '하위 메뉴'; ?></span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <ul class="breadcrumb-list">
                    <?php foreach($menu2_list as $m2) { ?>
                        <li class="<?php echo $m2['active'] ? 'active' : ''; ?>"><a href="<?php echo $m2['link']; ?>"><?php echo $m2['name']; ?></a></li>
                    <?php } ?>
                </ul>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<script>
$(function() {
    // Dropdown toggle logic
    $('.breadcrumb-btn').off('click').on('click', function(e) {
        e.stopPropagation();
        const parent = $(this).parent();
        
        // Close others
        $('.breadcrumb-item').not(parent).removeClass('active');
        
        // Toggle current
        parent.toggleClass('active');
    });

    // Close on outside click
    $(document).off('click.breadcrumb').on('click.breadcrumb', function() {
        $('.breadcrumb-item').removeClass('active');
    });

    // Hover effect for desktop
    if ($(window).width() > 768) {
        $('.breadcrumb-item').hover(
            function() { $(this).addClass('active'); },
            function() { $(this).removeClass('active'); }
        );
    }
});
</script>