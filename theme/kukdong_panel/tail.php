<?php
if (!defined('_GNUBOARD_')) exit;
?>

        </div> <!-- #container -->
    </div> <!-- #container_wr -->
</div> <!-- #wrapper -->

<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="footer-logo" style="margin-bottom: 20px;">
                    <img src="<?php echo G5_THEME_URL ?>/m_logo.png" alt="성우첨단패널 로고" style="height: 40px; filter: brightness(0) invert(1);">
                </div>
                <p>COPYRIGHT © 2026 SUNGWOO ADVANCED PANEL.<br>ALL RIGHTS RESERVED.</p>
            </div>
            <div class="footer-info">
                <p>주소 : 경기도 하남시 검단산로 239, 6층(하남시 벤처집적시설)</p>
                <p>대표전화 : 1551-9123 | 이메일 : dearceo@naver.com</p>
                <p>사업자등록번호 : 560-87-02627</p>
            </div>
        </div>
    </div>
</footer>

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