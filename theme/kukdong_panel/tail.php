<?php
if (!defined('_GNUBOARD_')) exit;
?>

        </div> <!-- #container -->
    </div> <!-- #container_wr -->
</div> <!-- #wrapper -->

<?php
// [Premium] Dynamic Footer Integration
if (function_exists('copyright_widget')) {
    copyright_widget(); 
} else {
    // Plugin Disabled Fallback
?>
<footer>
    <div class="container">
        <div class="footer-grid" style="text-align:center; padding:40px 0;">
            <div class="footer-brand">
                <div class="footer-logo" style="margin-bottom: 20px;">
                    <img src="<?php echo G5_THEME_URL ?>/m_logo.png" alt="logo" style="height: 40px; filter: brightness(0) invert(1);">
                </div>
                <p>COPYRIGHT © 2026 SUNGWOO ADVANCED PANEL. ALL RIGHTS RESERVED.</p>
            </div>
        </div>
    </div>
</footer>
<?php } ?>

<script>
    $(function () {
        // Header Scroll Effect
        $(window).on('scroll', function () {
            if ($(window).scrollTop() > 80) {
                $('#mainHeader').addClass('active');
            } else {
                $('#mainHeader').removeClass('active');
            }
        });

        // GNB Interaction
        $('.gnb > li').on('mouseenter', function () {
            $('.gnb > li').removeClass('on');
            $(this).addClass('on');
        });
        $('header').on('mouseleave', function () {
            $('.gnb > li').removeClass('on');
        });

        // Mobile Menu Logic
        $('.btnAllmenu').on('click', function (e) {
            e.preventDefault();
            $('.m-menu-wrap, .m-menu-overlay').fadeIn(0).addClass('active');
            $('.m-menu-overlay').fadeIn(300);
            $('body').addClass('m-menu-open');
        });

        $('.btn-m-close, .m-menu-overlay').on('click', function () {
            $('.m-menu-wrap').removeClass('active');
            $('.m-menu-overlay').fadeOut(300);
            $('body').removeClass('m-menu-open');
            setTimeout(function () {
                $('.m-gnb li').removeClass('on');
                $('.m-dep2, .m-dep3').hide();
            }, 400);
        });

        $('.m-gnb > li > a').on('click', function (e) {
            const subMenu = $(this).next('.m-dep2');
            if (subMenu.length > 0) {
                e.preventDefault();
                const parentLi = $(this).parent();
                if (parentLi.hasClass('on')) {
                    parentLi.removeClass('on');
                    subMenu.slideUp(300);
                } else {
                    parentLi.addClass('on');
                    subMenu.slideDown(300);
                }
            }
        });
    });
</script>

<?php
include_once(G5_THEME_PATH . "/tail.sub.php");
?>