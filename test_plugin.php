<?php
include_once('./common.php');
include_once(G5_THEME_PATH . '/head.php');
?>

<div style="max-width:1000px; margin:50px auto; padding:20px; background:#fff; border:1px solid #ddd;">
    <h2 style="margin-bottom:20px; border-bottom:2px solid #333; padding-bottom:10px;">온라인 문의 플러그인 테스트</h2>
    <p style="margin-bottom:20px; color:#666;">
        이 영역은 <code>plugin/online_inquiry/form.php</code> 파일을 include하여 출력한 결과입니다.<br>
        실제 데이터가 <b>관리자 페이지 > 온라인 문의 플러그인</b> 목록에 저장되는지 확인해 보세요.
    </p>

    <!-- 플러그인 폼 시작 -->
    <?php
    // 플러그인 로드 (실제 적용 시 이 한 줄만 복사하면 됨)
    include_once(G5_PLUGIN_PATH . '/online_inquiry/form.php');
    ?>
    <!-- 플러그인 폼 끝 -->

</div>

<?php
include_once(G5_THEME_PATH . '/tail.php');
?>