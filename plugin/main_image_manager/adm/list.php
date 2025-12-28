<?php
$sub_menu = "800180";
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

// 활성 스타일 설정 로드
$config_file = G5_PLUGIN_PATH . '/main_image_manager/active_style.php';
$active_style = 'A';
if (file_exists($config_file)) {
    include($config_file);
}

// 현재 편집 중인 스타일 (GET 파라미터가 없으면 활성 스타일을 기본 편집 대상으로 함)
$edit_style = isset($_GET['style']) ? $_GET['style'] : $active_style;

// 1. 아이템 추가/삭제 로직 (AJAX로 변경됨)
// list.php 하단 스크립트 참조

// 3. 테이블 생성 확인 및 초기화
if (!sql_query(" DESCRIBE g5_plugin_main_image_add ", false)) {
    $sql = " CREATE TABLE IF NOT EXISTS `g5_plugin_main_image_add` (
        `mi_id` int(11) NOT NULL AUTO_INCREMENT,
        `mi_style` char(1) NOT NULL DEFAULT 'A',
        `mi_sort` int(11) NOT NULL DEFAULT '0',
        `mi_image` varchar(255) NOT NULL DEFAULT '',
        `mi_title` varchar(255) NOT NULL DEFAULT '',
        `mi_desc` varchar(255) NOT NULL DEFAULT '',
        `mi_link` varchar(255) NOT NULL DEFAULT '',
        `mi_target` varchar(20) NOT NULL DEFAULT '',
        PRIMARY KEY (`mi_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ";
    sql_query($sql);
    // 기본 데이터 생성 (각 스타일별로 기본 3개씩 생성하여 시작)
    for ($s = 0; $s < 3; $s++) {
        $style_char = chr(65 + $s);
        for ($i = 1; $i <= 3; $i++) {
            sql_query(" INSERT INTO `g5_plugin_main_image_add` SET mi_style = '{$style_char}', mi_sort = '{$i}' ");
        }
    }
}

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '메인 이미지 관리';
include_once(G5_ADMIN_PATH . '/admin.head.php');

// 스타일 정의
$styles_map = array(
    'A' => 'Style A (Split)',
    'B' => 'Style B (Full)',
    'C' => 'Style C (Fade)'
);
?>

<div class="local_desc01 local_desc">
    <p>메인 이미지의 디자인 스킨을 선택할 수 있습니다.</p>
</div>

<!-- 1. 스킨 목록 및 활성화 영역 -->
<div class="tbl_head01 tbl_wrap" style="margin-bottom:50px;">
    <table>
        <caption>스킨 목록</caption>
        <colgroup>
            <col width="150">
            <col>
            <col width="100">
        </colgroup>
        <thead>
            <tr>
                <th>스킨명</th>
                <th>미리보기</th>
                <th>선택</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($styles_map as $key => $name) {
                $is_active = ($active_style == $key);
                $is_editing = ($edit_style == $key);
                // Reference uses 'bg2' for active. We will use it for active.
                // But we also want to highlight 'editing'.
                $row_class = $is_active ? 'bg2' : '';
                if ($is_editing && !$is_active)
                    $row_class = 'bg1'; // Optional: highlight editing if different?
                ?>
                <tr class="<?php echo $row_class; ?>">
                    <td class="td_category">
                        <a href="./list.php?style=<?php echo $key; ?>" style="font-weight:bold; font-size:14px;">
                            <?php echo $name; ?>
                        </a>
                        <?php if ($is_active) { ?>
                            <span
                                style="display:block; color:#e52727; font-size:12px; margin-top:5px; font-weight:bold;">[사용중]</span>
                        <?php } ?>
                        <?php if ($is_editing && !$is_active) { ?>
                            <span style="display:block; color:#253dbe; font-size:12px; margin-top:5px;">(편집 중)</span>
                        <?php } ?>
                    </td>
                    <td style="padding:10px; text-align:center;">
                        <?php
                        $preview_url = "./preview_style.php?style=" . $key;
                        $rec_size = "";
                        if ($key == 'A') {
                            $rec_size = "640 x 960 px";
                        } else if ($key == 'B') {
                            $rec_size = "1920 x 1080 px";
                        } else if ($key == 'C') {
                            $rec_size = "1920 x 1080 px";
                        }
                        ?>
                        <button type="button" class="btn btn_01"
                            onclick="showPreview('<?php echo $preview_url; ?>')">미리보기</button>

                        <?php if ($rec_size) { ?>
                            <div style="margin-top:5px; font-size:11px; color:#888;">
                                이미지 사이즈 : <?php echo $rec_size; ?>
                            </div>
                        <?php } ?>
                    </td>
                    <td class="td_mng">
                        <?php if ($is_active) { ?>
                            <button type="button" class="btn btn_02" disabled>적용중</button>
                        <?php } else { ?>
                            <form method="post" action="./update.style.php">
                                <input type="hidden" name="token" value="">
                                <input type="hidden" name="active_style" value="<?php echo $key; ?>">
                                <input type="submit" value="이 스킨 적용" class="btn btn_03">
                            </form>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- 2. 하단 데이터 에디터 영역 -->
<form name="fimglist" id="fimglist" action="./update.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="style" value="<?php echo $edit_style; ?>">
    <?php
    // Determine target dimensions for this style
    $target_w = 0;
    $target_h = 0;
    if ($edit_style == 'A') {
        $target_w = 640;
        $target_h = 960;
    } else if ($edit_style == 'B' || $edit_style == 'C') {
        $target_w = 1920;
        $target_h = 1080;
    }
    ?>
    <script>
        var unsplashTargetW = <?php echo $target_w; ?>;
        var unsplashTargetH = <?php echo $target_h; ?>;
    </script>
    <input type="hidden" name="token" value="">



    <div class="tbl_head01 tbl_wrap">
        <table>
            <caption>Style <?php echo $edit_style; ?> 이미지 데이터 관리</caption>
            <colgroup>
                <col width="10%">
                <col width="50%">
                <col width="40%">
            </colgroup>
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">이미지/설정</th>
                    <th scope="col">링크</th>
                </tr>
            </thead>
            <tbody id="image_list_body">
                <?php
                $sql = " select * from g5_plugin_main_image_add where mi_style = '{$edit_style}' order by mi_sort asc ";
                $result = sql_query($sql);
                for ($i = 0; $row = sql_fetch_array($result); $i++) {
                    $mi_id = $row['mi_id'];
                    ?>
                    <tr class="bg<?php echo $i % 2; ?>">
                        <td class="td_num">
                            <?php echo $i + 1; ?>
                            <input type="hidden" name="mi_id[<?php echo $mi_id; ?>]" value="<?php echo $mi_id; ?>">
                        </td>
                        <td class="td_left" style="padding:15px;">
                            <!-- 이미지 프리뷰 및 업로드 -->
                            <div style="border:1px solid #eee; padding:10px; background:#fff; margin-bottom:10px;">
                                <?php
                                $file_url = "";
                                $mi_image_url_val = "";

                                if (isset($row['mi_image']) && $row['mi_image']) {
                                    if (preg_match("/^(http|https):/i", $row['mi_image'])) {
                                        // It's a URL
                                        $file_url = $row['mi_image'];
                                        $mi_image_url_val = $row['mi_image'];
                                    } else {
                                        // It's a local file
                                        $file_url = G5_DATA_URL . '/main_visual/' . $row['mi_image'];
                                    }
                                }
                                ?>
                                <div style="margin-bottom:5px;">
                                    <?php if ($file_url) { ?>
                                        <a href="<?php echo $file_url; ?>" target="_blank">
                                            <img src="<?php echo $file_url; ?>"
                                                style="max-height:150px; width:auto; border:1px solid #ccc; display:block; margin-bottom:5px;">
                                        </a>
                                        <label><input type="checkbox" name="mi_image_del[<?php echo $mi_id; ?>]" value="1">
                                            삭제</label>
                                    <?php } else { ?>
                                        <span style="font-size:11px; color:#888;">[이미지 없음]</span>
                                    <?php } ?>
                                </div>
                                <div style="display:flex; align-items:center; gap:5px; margin-bottom:5px;">
                                    <input type="file" name="mi_image[<?php echo $mi_id; ?>]" class="frm_input"
                                        style="width:100%;">
                                    <button type="button" class="btn btn_02" onclick="openUnsplashSearch(this)"
                                        style="white-space:nowrap; flex-shrink:0;">이미지 검색</button>
                                </div>
                                <div>
                                    <input type="text" name="mi_image_url[<?php echo $mi_id; ?>]"
                                        value="<?php echo get_text($mi_image_url_val); ?>" class="frm_input full_input"
                                        placeholder="이미지 URL (직접 입력 또는 Unsplash 검색)" style="width:100%;">
                                </div>
                                <div class="params_box" style="margin-top:5px; display:none;">
                                    <img src="" class="preview_thumb"
                                        style="max-height:150px; width:auto; border:1px solid #ddd;">
                                    <button type="button" onclick="removeUnsplashImage(this)"
                                        style="display:block; margin-top:5px; font-size:11px; color:red; border:none; background:none; cursor:pointer;">[x]
                                        취소</button>
                                </div>
                            </div>

                            <!-- 텍스트 입력 -->
                            <table class="box_tbl" style="width:100%;">
                                <tr>
                                    <th style="width:60px; font-size:11px;">Title</th>
                                    <td><textarea name="mi_title[<?php echo $mi_id; ?>]" class="frm_input full_input"
                                            rows="2"><?php echo get_text($row['mi_title']); ?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width:60px; font-size:11px;">Desc</th>
                                    <td><textarea name="mi_desc[<?php echo $mi_id; ?>]"
                                            class="frm_input full_input mi_desc_textarea" rows="3"
                                            maxlength="80"><?php echo get_text($row['mi_desc']); ?></textarea>
                                        <div
                                            style="font-size:11px; color:#888; margin-top:3px; display:flex; justify-content:space-between;">
                                            <span>* 설명부분은 80자 이내 (2줄 권장)로 작성해 주세요.</span>
                                            <span
                                                class="char_count"><strong><?php echo mb_strlen($row['mi_desc']); ?></strong>
                                                / 80자</span>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="td_center" style="vertical-align:top; padding-top:25px;">
                            <input type="text" name="mi_link[<?php echo $mi_id; ?>]"
                                value="<?php echo get_text($row['mi_link']); ?>" class="frm_input" size="30"
                                placeholder="Link URL" style="width:100%; margin-bottom:5px;">
                            <select name="mi_target[<?php echo $mi_id; ?>]" class="frm_input" style="width:100%;">
                                <option value="" <?php echo ($row['mi_target'] == '') ? 'selected' : ''; ?>>현재창</option>
                                <option value="_blank" <?php echo ($row['mi_target'] == '_blank') ? 'selected' : ''; ?>>새창
                                </option>
                            </select>

                            <div style="margin-top:20px; text-align:right;">
                                <button type="button" class="btn btn_02 btn_del_ajax" data-id="<?php echo $mi_id; ?>"> 항목 삭제
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px; text-align:center;">
        <button type="button" id="btn_add_ajax" class="btn btn_02"
            style="padding:10px 50px; font-size:14px; background:#f73966; color:#fff; border:0;"> + 항목 추가하기 </button>
    </div>

    <div class="btn_fixed_top">
        <input type="submit" value="저장 (업로드)" class="btn_submit btn">
    </div>
</form>



<script>
    function showPreview(url) {
        var modal = document.getElementById('previewModal');
        var frame = document.getElementById('previewFrame');
        if (!modal) return;
        frame.src = url;
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closePreview() {
        var modal = document.getElementById('previewModal');
        var frame = document.getElementById('previewFrame');
        if (!modal) return;
        modal.style.display = 'none';
        frame.src = '';
        document.body.style.overflow = '';
    }

    // Close when clicking outside
    // document ready에서 이벤트 바인딩 하거나, 여기서 직접 바인딩

    // Unsplash 검색 팝업
    var currentBtn = null;
    function openUnsplashSearch(btn) {
        currentBtn = $(btn);
        var url = "<?php echo G5_PLUGIN_URL; ?>/unsplash_api/popup.php";

        // Append dimensions if available
        if (unsplashTargetW > 0 && unsplashTargetH > 0) {
            url += "?w=" + unsplashTargetW + "&h=" + unsplashTargetH;
        }

        var modal = document.getElementById('unsplashModal');
        var frame = document.getElementById('unsplashFrame');

        if (!modal) return;

        frame.src = url;
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeUnsplashSearch() {
        var modal = document.getElementById('unsplashModal');
        var frame = document.getElementById('unsplashFrame');
        if (!modal) return;

        modal.style.display = 'none';
        frame.src = '';
        document.body.style.overflow = '';
    }

    // 콜백 함수: 팝업(iframe)에서 호출됨
    function receiveUnsplashUrl(url) {
        closeUnsplashSearch(); // 닫기

        if (!currentBtn) return;

        // currentBtn is inside the flex div. Parent is td.
        var wrapper = currentBtn.closest("td");

        // Find inputs within the td
        var urlInput = wrapper.find("input[name^='mi_image_url']");
        var fileInput = wrapper.find("input[type=file]");
        var previewBox = wrapper.find(".params_box");
        var previewImg = previewBox.find(".preview_thumb");

        // 값 설정
        urlInput.val(url);
        fileInput.val(""); // 파일을 비워야 URL이 우선순위를 가짐

        // 미리보기 업데이트
        previewImg.attr("src", url);
        previewBox.show();
    }

    function removeUnsplashImage(btn) {
        var wrapper = $(btn).closest("td");
        wrapper.find("input[name^='mi_image_url']").val("");
        wrapper.find(".params_box").hide();
    }

    $(document).ready(function () {
        // [Critical Fix] Move modals to body to ensure top-layer visibility
        // This solves the issue where sidebars or headers overlap the modal
        $("body").append($("#previewModal"));
        $("body").append($("#unsplashModal"));

        document.getElementById('previewModal').addEventListener('click', function (e) {
            if (e.target === this) closePreview();
        });

        // 항목 추가 AJAX
        $("#btn_add_ajax").click(function () {
            var rowCount = $("#image_list_body > tr").length;
            if (rowCount >= 10) {
                alert("10장까지 입력이 가능합니다.");
                return;
            }

            var style = $("input[name='style']").val();
            $.post("./ajax.add_item.php", { style: style }, function (data) {
                var $newRow = $(data);

                // 현재 행 개수(홀/짝)에 따라 배경색 결정
                var rowCount = $("#image_list_body tr").length;
                var nextClass = (rowCount % 2 == 0) ? "bg0" : "bg1";

                $newRow.removeClass("bg0 bg1").addClass(nextClass);
                $("#image_list_body").append($newRow);

                // 자연스러운 스크롤 이동
                $('html, body').animate({
                    scrollTop: $newRow.offset().top - 100
                }, 500);
            });
        });

        // 항목 삭제 AJAX
        $(document).on("click", ".btn_del_ajax", function () {
            if (!confirm("정말 삭제하시겠습니까?")) return;

            var btn = $(this);
            var id = btn.data("id");

            $.post("./ajax.del_item.php", { mi_id: id }, function (data) {
                if ($.trim(data) == "OK") {
                    btn.closest("tr").remove();
                } else {
                    alert("삭제 실패: " + data);
                }
            });
        });

        // 실시간 글자수 체크
        $(document).on("input", ".mi_desc_textarea", function () {
            var len = $(this).val().length;
            $(this).parent().find(".char_count strong").text(len);

            if (len >= 80) {
                $(this).parent().find(".char_count").css("color", "red");
            } else {
                $(this).parent().find(".char_count").css("color", "#888");
            }
        });
    });
</script>

<!-- Preview Modal (Moved to bottom) -->
<div id="previewModal"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:99999; justify-content:center; align-items:center;">
    <div
        style="position:relative; width:90%; height:90%; background:#fff; border-radius:5px; overflow:hidden; box-shadow:0 0 30px rgba(0,0,0,0.8);">
        <button type="button" onclick="closePreview()"
            style="position:absolute; top:20px; right:20px; font-size:30px; color:#333; background:none; border:none; cursor:pointer; z-index:10000;">&times;</button>
        <iframe id="previewFrame" style="width:100%; height:100%; border:none;"></iframe>
    </div>
</div>

<!-- Unsplash Search Modal (Moved to bottom) -->
<div id="unsplashModal"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:99999; justify-content:center; align-items:center;">
    <div
        style="position:relative; width:90%; height:90%; background:#fff; border-radius:5px; overflow:hidden; box-shadow:0 0 30px rgba(0,0,0,0.8);">
        <button type="button" onclick="closeUnsplashSearch()"
            style="position:absolute; top:20px; right:20px; font-size:30px; color:#333; background:none; border:none; cursor:pointer; z-index:10000;">&times;</button>
        <iframe id="unsplashFrame" style="width:100%; height:100%; border:none;"></iframe>
    </div>
</div>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>