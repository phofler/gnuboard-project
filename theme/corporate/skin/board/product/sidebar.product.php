<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// [1] 제품소개 카테고리 (Root Code: 10) 가져오기
// lib.php에 정의된 함수 사용 (없을 경우 직접 쿼리)
if (!function_exists('get_tree_categories')) {
    include_once(G5_PLUGIN_PATH . '/tree_category/lib.php');
}

$all_cats = get_tree_categories();
$product_cats = array();

// Root Code '10' (제품소개) 하위만 필터링
foreach ($all_cats as $cat) {
    if (substr($cat['tc_code'], 0, 2) === '10' && strlen($cat['tc_code']) > 2) {
        $product_cats[] = $cat;
    }
}

// [2] 현재 활성 카테고리 확인
// 1순위: $_GET['cate'] (코드 직접 전달)
// 2순위: $sca (이름 전달)
// 3순위: $write['ca_name'] (뷰 페이지)

$active_code = '';

if (isset($_GET['cate']) && $_GET['cate']) {
    $active_code = trim($_GET['cate']);
} elseif (isset($sca) && $sca) {
    // 이름으로 코드 찾기
    foreach ($product_cats as $cat) {
        if ($cat['tc_name'] === $sca) {
            $active_code = $cat['tc_code'];
            break;
        }
    }
} elseif (isset($write['ca_name']) && $write['ca_name']) {
    foreach ($product_cats as $cat) {
        if ($cat['tc_name'] === $write['ca_name']) {
            $active_code = $cat['tc_code'];
            break;
        }
    }
}
?>

<div class="product-sidebar">
    <!-- Header -->
    <div class="sidebar-header">
        <h2>PRODUCT</h2>
        <span>제품소개</span>
    </div>

    <!-- Menu List -->
    <ul class="sidebar-menu">
        <?php
        // 1차 분류 (Depth 2: 10xx)
        foreach ($product_cats as $cat) {
            if (strlen($cat['tc_code']) === 4) {
                // 활성 상태 체크 (현재 코드가 이 메뉴의 코드보 시작하거나 같음)
                $is_active = (substr($active_code, 0, 4) === $cat['tc_code']);
                $active_cls = $is_active ? 'active' : '';
                
                // 하위 메뉴 확인
                $sub_items = array();
                foreach ($product_cats as $sub) {
                    if (strlen($sub['tc_code']) === 6 && substr($sub['tc_code'], 0, 4) === $cat['tc_code']) {
                        $sub_items[] = $sub;
                    }
                }
                
                // 링크 설정 (cate 파라미터 사용)
                // $href = G5_BBS_URL . '/board.php?bo_table=' . $bo_table . '&cate=' . $cat['tc_code'];
                // 기존 sca 유지를 원하면 둘 다 넣거나, cate만 넣어도 됨. 여기선 cate 우선.
                // Scroll to content anchor added (#page_start)
                $href = $cat['tc_link'] ? $cat['tc_link'] : G5_BBS_URL . '/board.php?bo_table=' . $bo_table . '&cate=' . $cat['tc_code'] . '#page_start';
        ?>

            <li class="menu-item depth-1 <?php echo $active_cls; ?>">
                <?php if(count($sub_items) > 0) { ?>
                    <!-- Accordion Toggle for Parent with Child -->
                    <a href="#" class="toggle-menu">
                        <?php echo $cat['tc_name']; ?>
                        <i class="fa fa-angle-right arrow-icon"></i>
                    </a>
                <?php } else { ?>
                    <!-- Direct Link for Items without Child -->
                    <a href="<?php echo $href; ?>" <?php echo $cat['tc_target'] == '_blank' ? 'target="_blank"' : ''; ?>>
                        <?php echo $cat['tc_name']; ?>
                    </a>
                <?php } ?>

                <?php if (count($sub_items) > 0) { ?>
                <ul class="sub-menu" style="<?php echo $is_active ? 'display:block;' : 'display:none;'; ?>">
                    <?php foreach ($sub_items as $sub) { 
                        $is_sub_active = ($active_code === $sub['tc_code']);
                        $sub_active_cls = $is_sub_active ? 'active' : '';
                        $sub_href = $sub['tc_link'] ? $sub['tc_link'] : G5_BBS_URL . '/board.php?bo_table=' . $bo_table . '&cate=' . $sub['tc_code'] . '#page_start';
                    ?>
                        <li class="menu-item depth-2 <?php echo $sub_active_cls; ?>">
                            <a href="<?php echo $sub_href; ?>" <?php echo $sub['tc_target'] == '_blank' ? 'target="_blank"' : ''; ?>>
                                - <?php echo $sub['tc_name']; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <?php } ?>
            </li>
        <?php 
            }
        } 
        ?>
    </ul>

    <!-- Contact Banner (Optional) -->
    <div class="sidebar-contact">
        <i class="fa fa-headset"></i>
    <div class="sidebar-contact-box">
        <div class="txt">
            <strong>온라인 문의</strong>
            <span>친절하게 상담해드립니다</span>
        </div>
        <a href="<?php echo G5_BBS_URL; ?>/qalist.php" class="contact-btn">문의하기</a>
    </div>
</div>

<style>
/* Clean Dark Sidebar Styling - Edge Bar Check */
/* Clean Dark Sidebar Styling - Edge Bar Check */
.product-sidebar-wrap {
    background: var(--color-bg-panel);
    border: none;
    border-radius: 0;
    overflow: visible;
    margin-bottom: 0;
    min-height: 100%;
    box-shadow: 2px 0 5px rgba(0,0,0,0.2);
}
.sidebar-header {
    background: var(--color-bg-dark); /* Darker header */
    padding: 25px 20px;
    text-align: left;
    border-bottom: 1px solid var(--color-metal-dark);
}
.sidebar-header h2 {
    color: var(--color-text-primary);
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.sidebar-header .sub-text {
    color: var(--color-accent-gold); /* Gold Accent Text */
    font-size: 0.85rem;
    margin-top: 5px;
    display: block;
    font-weight: 600;
}

/* Menu List */
.sidebar-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}
.sidebar-menu > li {
    border-bottom: 1px solid var(--color-metal-dark); /* Very subtle divider */
}
.sidebar-menu > li:last-child {
    border-bottom: none;
}
.sidebar-menu > li > a {
    display: block;
    padding: 18px 25px;
    color: var(--color-text-secondary);
    text-decoration: none;
    font-size: 0.95rem;
    transition: all 0.2s;
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.sidebar-menu > li > a:hover {
    background: var(--color-metal-dark);
    color: var(--color-accent-gold); /* Gold Hover */
}
.sidebar-menu > li.active > a {
    background: var(--color-metal-dark); /* Dark Active */
    color: var(--color-accent-gold); /* Gold Text */
    border-left: 3px solid var(--color-accent-gold); /* Gold Border */
}

/* Sub Menu */
.sidebar-menu .sub-menu {
    list-style: none;
    padding: 0;
    background: var(--color-bg-dark); /* Match bg dark */
    display: none; 
}
.sidebar-menu > li.active .sub-menu {
    display: block;
}
.sidebar-menu .sub-menu li a {
    display: block;
    padding: 12px 25px 12px 40px;
    color: var(--color-text-secondary);
    font-size: 0.9rem;
    transition: color 0.2s;
    border-bottom: none;
}
.sidebar-menu .sub-menu li a:hover,
.sidebar-menu .sub-menu li.current > a {
    color: var(--color-text-primary);
    background: transparent;
}
.sidebar-menu .sub-menu li.current > a::before {
    content: "• ";
    color: var(--color-accent-gold); /* Gold Dot */
    margin-right: 5px;
}

/* Contact Box - Integrated into Edge Bar */
.sidebar-contact-box {
    background: transparent;
    padding: 30px 20px;
    text-align: center;
    border-top: 1px solid var(--color-metal-dark);
    border-radius: 0;
    margin-top: 20px;
}
.sidebar-contact-box h3 {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 10px;
    color: var(--color-text-primary);
}
.sidebar-contact-box p {
    font-size: 0.85rem;
    color: var(--color-text-secondary);
    margin-bottom: 20px;
}
.contact-btn {
    display: block;
    background: var(--color-accent-gold); /* Gold Button */
    color: #000; /* Contrast black on gold */
    padding: 12px 0;
    text-decoration: none;
    border-radius: 0;
    font-size: 0.9rem;
    transition: background 0.3s;
    text-align: center;
    font-weight: 600;
}
.contact-btn:hover {
    background: var(--color-accent-gold-hover); /* Darker Gold Hover */
}

/* Icon */
/* Icon Animation */
.arrow-icon {
    transition: transform 0.3s;
}
.menu-item.active .arrow-icon,
.menu-item.open .arrow-icon {
    transform: rotate(90deg);
}
</style>

<script>
$(document).ready(function() {
    // Accordion Behavior
    $('.toggle-menu').on('click', function(e) {
        e.preventDefault(); // Stop page navigation
        
        var $parent = $(this).parent();
        var $submenu = $(this).next('.sub-menu');
        
        // Toggle Submenu
        $submenu.stop().slideToggle(300);
        
        // Toggle Active/Open State
        $parent.toggleClass('open');
        
        // Optional: Close others? (User said "naturally open", usually implies keeping others open or auto-close. 
        // Let's keep others open for multi-select feel, or close for accordion. Accordion is cleaner.)
        // $('.menu-item.depth-1').not($parent).removeClass('open').find('.sub-menu').slideUp(300);
    });
    
    // Ensure active menu is open on load
    $('.menu-item.depth-1.active').addClass('open').find('.sub-menu').show();
});
</script>
