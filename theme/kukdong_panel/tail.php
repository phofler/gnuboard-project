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
                    <img src="<?php echo G5_THEME_IMG_URL ?>/m_logo.png" alt="logo" style="height: 40px; filter: brightness(0) invert(1);">
                </div>
                <p>COPYRIGHT © 2026 SUNGWOO ADVANCED PANEL. ALL RIGHTS RESERVED.</p>
            </div>
        </div>
    </div>
</footer>
<?php } ?>

<script>
    $(function () {
        // Initialize AOS
        if (typeof AOS !== "undefined") {
            AOS.init({
                once: true,
                duration: 1000,
                easing: 'ease-out-quad'
            });
        }

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

        // Reveal Animation Handler
        function handleReveal() {
            var reveals = $(".reveal");
            var windowHeight = $(window).height();
            reveals.each(function() {
                var elementTop = $(this).get(0).getBoundingClientRect().top;
                var elementVisible = 100;
                if (elementTop < windowHeight - elementVisible) {
                    $(this).addClass("active");
                }
            });
        }
        $(window).on('scroll load', handleReveal);
        handleReveal();
    });
</script>

<?php
include_once(G5_THEME_PATH . "/tail.sub.php");
?>