<?php
$sub_menu = "800190"; // 메인 컨텐츠 관리 고유 번호
include_once('./_common.php');
define('G5_IS_ADMIN', true);
include_once(G5_ADMIN_PATH . '/admin.lib.php');

// 활성 스타일 설정 로드
$config_file = G5_PLUGIN_PATH . '/main_content_manager/active_style.php';
$active_style = 'A';
$section_title = 'PRODUCT COLLECTION';

if (file_exists($config_file)) {
    include($config_file);
}

// 현재 편집 중인 스타일
$edit_style = isset($_GET['style']) ? $_GET['style'] : $active_style;

// 테이블 생성 확인
if (!sql_query(" DESCRIBE g5_plugin_main_content ", false)) {
    $sql = " CREATE TABLE IF NOT EXISTS `g5_plugin_main_content` (
        `mc_id` int(11) NOT NULL AUTO_INCREMENT,
        `mc_style` char(1) NOT NULL DEFAULT 'A',
        `mc_sort` int(11) NOT NULL DEFAULT '0',
        `mc_image` varchar(255) NOT NULL DEFAULT '',
        `mc_title` varchar(255) NOT NULL DEFAULT '',
        `mc_desc` text NOT NULL DEFAULT '',
        `mc_link` varchar(255) NOT NULL DEFAULT '',
        `mc_target` varchar(20) NOT NULL DEFAULT '',
        PRIMARY KEY (`mc_id`)
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ";
    sql_query($sql);

    // 기본 데이터 생성 (4개)
    for ($i = 1; $i <= 4; $i++) {
        sql_query(" INSERT INTO `g5_plugin_main_content` SET mc_style = 'A', mc_sort = '{$i}' ");
        sql_query(" INSERT INTO `g5_plugin_main_content` SET mc_style = 'B', mc_sort = '{$i}' ");
        sql_query(" INSERT INTO `g5_plugin_main_content` SET mc_style = 'C', mc_sort = '{$i}' ");
    }
}

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '메인 컨텐츠 관리';
include_once(G5_ADMIN_PATH . '/admin.head.php');

$styles_map = array(
    'A' => 'Style A (Split Alternate)',
    'B' => 'Style B (Full Width Slider)',
    'C' => 'Style C (Vertical Slide)'
);
?>

<div class="local_desc01 local_desc">
    <p>메인 페이지의 컨텐츠 섹션(Product Collection 등)의 디자인 스킨과 내용을 관리합니다.</p>
</div>

<!-- 1. 섹션 메인 제목 관리 -->
<div class="tbl_frm01 tbl_wrap" style="margin-bottom:20px; border-top:2px solid #333;">
    <form name="fcommon" action="./update.style.php" method="post">
        <input type="hidden" name="active_style" value="<?php echo $active_style; ?>">
        <table>
            <colgroup>
                <col width="150">
                <col>
            </colgroup>
            <tbody>
                <tr>
                    <th scope="row">섹션 메인 제목</th>
                    <td>
                        <input type="text" name="section_title" value="<?php echo get_text($section_title); ?>"
                            class="frm_input" style="width:100%; max-width:400px; font-size:14px; font-weight:bold;"
                            placeholder="예: PRODUCT COLLECTION">
                        <span style="font-size:11px; color:#888; margin-left:10px;">* 해당 섹션 최상단에 공통으로 표시될 제목입니다.</span>
                    </td>
                </tr>
            </tbody>
        </table>
        <div style="margin-top:10px; text-align:right;">
            <input type="submit" value="제목 변경" class="btn_submit btn">
        </div>
    </form>
</div>

<!-- 2. 스킨 목록 관리 -->
<div class="tbl_head01 tbl_wrap" style="margin-bottom:30px;">
    <table>
        <caption>스킨 목록</caption>
        <colgroup>
            <col width="25%">
            <col width="50%">
            <col width="25%">
        </colgroup>
        <thead>
            <tr>
                <th>스킨명</th>
                <th>설명</th>
                <th>상태/적용</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($styles_map as $key => $name) {
                $is_active = ($active_style == $key);
                $row_class = $is_active ? 'bg2' : '';
                ?>
                <tr class="<?php echo $row_class; ?>">
                    <td class="td_category">
                        <a href="./list.php?style=<?php echo $key; ?>" style="font-weight:bold; font-size:14px;">
                            <?php echo $name; ?>
                        </a>
                    </td>
                    <td>
                        <div style="font-size:13px; color:#333; margin-bottom:5px;">
                            <?php
                            if ($key == 'A')
                                echo "좌우 교차 배치되는 리스트 스타일";
                            if ($key == 'B')
                                echo "꽉찬 이미지과 글이 양쪽 슬라이드";
                            if ($key == 'C')
                                echo "이미지과 글이 아래에서 위로 슬라이드";
                            ?>
                        </div>
                        <?php
                        $rec_size = "";
                        if ($key == 'A')
                            $rec_size = "800 x 600 px";
                        else if ($key == 'B')
                            $rec_size = "1200 x 600 px";
                        else if ($key == 'C')
                            $rec_size = "800 x 600 px";

                        if ($rec_size) {
                            echo '<div style="font-size:11px; color:#e52727;">(권장 이미지 사이즈: ' . $rec_size . ')</div>';
                        }
                        ?>
                    </td>
                    <td class="td_mng">
                        <form action="./update.style.php" method="post" style="display:inline;">
                            <input type="hidden" name="active_style" value="<?php echo $key; ?>">
                            <input type="hidden" name="section_title" value="<?php echo get_text($section_title); ?>">
                            <?php if ($is_active) { ?>
                                <span style="color:#e52727; font-weight:bold; font-size:14px;">[현재 사용중]</span>
                            <?php } else { ?>
                                <input type="submit" value="스킨 적용" class="btn btn_03">
                            <?php } ?>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- 3. 하단 데이터 에디터 영역 -->
<form name="fmaincontent" id="fmaincontent" action="./update.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="style" value="<?php echo $edit_style; ?>">
    <input type="hidden" name="token" value="">
    <div class="tbl_head01 tbl_wrap">
        <table>
            <caption>Style <?php echo $edit_style; ?> 컨텐츠 데이터 관리</caption>
            <colgroup>
                <col width="10%">
                <col width="50%">
                <col width="40%">
            </colgroup>
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">이미지/텍스트</th>
                    <th scope="col">링크/상세</th>
                </tr>
            </thead>
            <tbody id="content_list_body">
                <?php
                $sql = " select * from g5_plugin_main_content where mc_style = '{$edit_style}' order by mc_sort asc ";
                $result = sql_query($sql);
                for ($i = 0; $row = sql_fetch_array($result); $i++) {
                    $mc_id = $row['mc_id'];
                    ?>
                    <tr class="bg<?php echo $i % 2; ?>">
                        <td class="td_num">
                            <?php echo $i + 1; ?>
                            <input type="hidden" name="mc_id[<?php echo $mc_id; ?>]" value="<?php echo $mc_id; ?>">
                        </td>
                        <td class="td_left" style="padding:15px;">
                            <div style="border:1px solid #eee; padding:10px; background:#fff; margin-bottom:10px;">
                                <?php
                                $file_url = "";
                                if ($row['mc_image']) {
                                    if (preg_match("/^(http|https):/i", $row['mc_image'])) {
                                        $file_url = $row['mc_image'];
                                    } else {
                                        $file_url = G5_DATA_URL . '/main_content/' . $row['mc_image'];
                                    }
                                }
                                ?>
                                <?php
                                $is_url = preg_match("/^(http|https):/i", $row['mc_image']);
                                ?>
                                <div class="old_img_box"
                                    style="margin-bottom:5px; display:<?php echo $is_url ? 'none' : 'block'; ?>;">
                                    <?php if ($row['mc_image'] && !$is_url) { ?>
                                        <img src="<?php echo G5_DATA_URL . '/main_content/' . $row['mc_image']; ?>"
                                            style="max-height:100px; border:1px solid #ccc;">
                                        <label><input type="checkbox" name="mc_image_del[<?php echo $mc_id; ?>]" value="1">
                                            삭제</label>
                                    <?php } else {
                                        echo "<span style='color:#888; font-size:11px;'>[이미지 없음]</span>";
                                    } ?>
                                </div>
                                <div style="margin-bottom:5px;">
                                    <input type="file" name="mc_image[<?php echo $mc_id; ?>]" class="frm_input"
                                        style="width:100%;">
                                </div>
                                <div style="display:flex; gap:5px; margin-bottom:5px;">
                                    <input type="text" name="mc_image_url[<?php echo $mc_id; ?>]"
                                        value="<?php echo $is_url ? get_text($row['mc_image']) : ''; ?>" class="frm_input"
                                        style="flex:1;" placeholder="이미지 URL">
                                    <button type="button" class="btn btn_02" onclick="openUnsplashSearch(this)"
                                        style="white-space:nowrap;">이미지 검색</button>
                                </div>

                                <div class="params_box"
                                    style="margin-top:5px; display:<?php echo $is_url ? 'block' : 'none'; ?>;">
                                    <img src="<?php echo $is_url ? get_text($row['mc_image']) : ''; ?>"
                                        class="preview_thumb" style="max-height:150px; width:auto; border:1px solid #ddd;">
                                    <button type="button" onclick="removeUnsplashImage(this)"
                                        style="display:block; margin-top:5px; font-size:11px; color:red; border:none; background:none; cursor:pointer;">[x]
                                        취소</button>
                                </div>
                            </div>

                            <table class="box_tbl" style="width:100%;">
                                <tr>
                                    <th style="width:60px;">Title</th>
                                    <td><input type="text" name="mc_title[<?php echo $mc_id; ?>]"
                                            value="<?php echo get_text($row['mc_title']); ?>" class="frm_input full_input">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Desc</th>
                                    <td>
                                        <textarea name="mc_desc[<?php echo $mc_id; ?>]"
                                            class="frm_input full_input mc_desc_textarea" rows="3"
                                            maxlength="500"><?php echo get_text($row['mc_desc']); ?></textarea>
                                        <div style="text-align:right; font-size:11px; color:#888;"><span
                                                class="char_count"><strong><?php echo mb_strlen($row['mc_desc']); ?></strong></span>
                                            / 500자</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td class="td_center" style="vertical-align:top; padding-top:25px;">
                            <input type="text" name="mc_link[<?php echo $mc_id; ?>]"
                                value="<?php echo get_text($row['mc_link']); ?>" class="frm_input full_input"
                                placeholder="Link URL (VIEW DETAIL)">
                            <select name="mc_target[<?php echo $mc_id; ?>]" class="frm_input full_input"
                                style="margin-top:5px;">
                                <option value="" <?php echo $row['mc_target'] == '' ? 'selected' : ''; ?>>현재창</option>
                                <option value="_blank" <?php echo $row['mc_target'] == '_blank' ? 'selected' : ''; ?>>새창
                                </option>
                            </select>
                            <div style="margin-top:20px; text-align:right;">
                                <button type="button" class="btn btn_02 btn_del_ajax" data-id="<?php echo $mc_id; ?>">항목
                                    삭제</button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px; text-align:center;">
        <button type="button" id="btn_add_ajax" class="btn btn_02"
            style="background:#f73966; color:#fff; border:0; padding:10px 30px;">+ 항목 추가하기 (최대 7개)</button>
    </div>

    <div class="btn_fixed_top">
        <input type="submit" value="저장하기" class="btn_submit btn">
    </div>
</form>

<div id="unsplashModal"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:99999; justify-content:center; align-items:center;">
    <div style="position:relative; width:90%; height:90%; background:#fff; border-radius:5px; overflow:hidden;">
        <button type="button" onclick="closeUnsplashSearch()"
            style="position:absolute; top:20px; right:20px; font-size:30px; border:none; background:none; cursor:pointer;">&times;</button>
        <iframe id="unsplashFrame" style="width:100%; height:100%; border:none;"></iframe>
    </div>
</div>

<script>
    function applyStyle(styleKey) {
        // 이 함수는 이제 사용되지 않거나 단순 안내용으로 바뀔 수 있습니다.
        if (!confirm("해당 스킨을 적용하시겠습니까?")) return;
        // 각 스킨 적용 버튼은 개별 폼을 통해 update.style.php로 전송됩니다.
        // 이 함수는 더 이상 직접적인 폼 제출을 담당하지 않습니다.
    }

    var currentBtn = null;
    function openUnsplashSearch(btn) {
        currentBtn = $(btn);
        var modal = document.getElementById('unsplashModal');
        var frame = document.getElementById('unsplashFrame');
        var style = "<?php echo $edit_style; ?>";
        var w = 800;
        var h = 600;

        if (style === 'B') {
            w = 1200;
            h = 600;
        }

        frame.src = "<?php echo G5_PLUGIN_URL; ?>/unsplash_api/popup.php?w=" + w + "&h=" + h;
        modal.style.display = 'flex';
    }
    function closeUnsplashSearch() {
        document.getElementById('unsplashModal').style.display = 'none';
    }
    function receiveUnsplashUrl(url) {
        closeUnsplashSearch(); // 팝업 닫기
        if (!currentBtn) return;

        var td = currentBtn.closest("td");
        var urlInput = td.find("input[name^='mc_image_url']");
        var fileInput = td.find("input[type=file]");
        var previewBox = td.find(".params_box");
        var previewImg = previewBox.find(".preview_thumb");

        // 값 설정
        urlInput.val(url);
        fileInput.val(""); // 파일을 비워야 URL이 우선순위를 가짐

        // 미리보기 업데이트
        previewImg.attr("src", url);
        previewBox.show();

        // [추가] 기존 이미지가 보이지 않게 숨기고 삭제 체크박스를 체크함
        td.find(".old_img_box").hide();
        td.find("input[name^='mc_image_del']").prop("checked", true);
    }

    function removeUnsplashImage(btn) {
        var td = $(btn).closest("td");
        td.find("input[name^='mc_image_url']").val("");
        td.find(".params_box").hide();

        // [추가] 취소했을 때 다시 기존 이미지를 보여주고 삭제 체크 해제
        td.find(".old_img_box").show();
        td.find("input[name^='mc_image_del']").prop("checked", false);
    }

    $(document).ready(function () {
        $("#btn_add_ajax").click(function () {
            if ($("#content_list_body > tr").length >= 7) {
                alert("최대 7개까지만 추가할 수 있습니다.");
                return;
            }
            var style = "<?php echo $edit_style; ?>";
            $.post("./ajax.add_item.php", { style: style }, function (data) {
                $("#content_list_body").append(data);
            });
        });

        $(document).on("click", ".btn_del_ajax", function () {
            if (!confirm("삭제하시겠습니까?")) return;
            var btn = $(this);
            var id = btn.data("id");
            $.post("./ajax.del_item.php", { mc_id: id }, function (data) {
                if ($.trim(data) == "OK") btn.closest("tr").remove();
            });
        });

        $(document).on("input", ".mc_desc_textarea", function () {
            $(this).parent().find(".char_count strong").text($(this).val().length);
        });
    });
</script>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>