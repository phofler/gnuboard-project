<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css">', 0);
?>

<div class="sub-layout-width-height">
    <section id="bo_w">
        <h2 class="sound_only"><?php echo $g5['title'] ?></h2>

        <!-- 게시물 작성/수정 시작 { -->
        <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);"
            method="post" enctype="multipart/form-data" autocomplete="off" style="width:<?php echo $width; ?>">
            <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
            <input type="hidden" name="w" value="<?php echo $w ?>">
            <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
            <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
            <input type="hidden" name="sca" value="<?php echo $sca ?>">
            <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
            <input type="hidden" name="stx" value="<?php echo $stx ?>">
            <input type="hidden" name="spt" value="<?php echo $spt ?>">
            <input type="hidden" name="sst" value="<?php echo $sst ?>">
            <input type="hidden" name="sod" value="<?php echo $sod ?>">
            <input type="hidden" name="page" value="<?php echo $page ?>">
            <?php
            $option = '';
            $option_hidden = '';
            if ($is_notice || $is_html || $is_secret || $is_mail) {
                $option = '';
                if ($is_notice) {
                    $option .= PHP_EOL . '<li class="chk_box"><input type="checkbox" id="notice" name="notice"  class="selec_chk" value="1" ' . $notice_checked . '>' . PHP_EOL . '<label for="notice"><span></span>공지</label></li>';
                }
                if ($is_html) {
                    if ($is_dhtml_editor) {
                        $option_hidden .= '<input type="hidden" value="html1" name="html">';
                    } else {
                        $option .= PHP_EOL . '<li class="chk_box"><input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" class="selec_chk" value="' . $html_value . '" ' . $html_checked . '>' . PHP_EOL . '<label for="html"><span></span>html</label></li>';
                    }
                }
                if ($is_secret) {
                    if ($is_admin || $is_secret == 1) {
                        $option .= PHP_EOL . '<li class="chk_box"><input type="checkbox" id="secret" name="secret"  class="selec_chk" value="secret" ' . $secret_checked . '>' . PHP_EOL . '<label for="secret"><span></span>비밀글</label></li>';
                    } else {
                        $option_hidden .= '<input type="hidden" name="secret" value="secret">';
                    }
                }
                if ($is_mail) {
                    $option .= PHP_EOL . '<li class="chk_box"><input type="checkbox" id="mail" name="mail"  class="selec_chk" value="mail" ' . $recv_email_checked . '>' . PHP_EOL . '<label for="mail"><span></span>답변메일받기</label></li>';
                }
            }
            echo $option_hidden;
            ?>

            <?php if ($is_category) { ?>
                <div class="bo_w_select write_div">
                    <label for="ca_name" class="sound_only">분류<strong>필수</strong></label>
                    <select name="ca_name" id="ca_name" required>
                        <option value="">분류를 선택하세요</option>
                        <?php echo $category_option ?>
                    </select>
                </div>
            <?php } ?>

            <div class="bo_w_info write_div">
                <?php if ($is_name) { ?>
                    <label for="wr_name" class="sound_only">이름<strong>필수</strong></label>
                    <input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required
                        class="frm_input half_input required" placeholder="이름">
                <?php } ?>

                <?php if ($is_password) { ?>
                    <label for="wr_password" class="sound_only">비밀번호<strong>필수</strong></label>
                    <input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?>
                        class="frm_input half_input <?php echo $password_required ?>" placeholder="비밀번호">
                <?php } ?>

                <?php if ($is_email) { ?>
                    <label for="wr_email" class="sound_only">이메일</label>
                    <input type="text" name="wr_email" value="<?php echo $email ?>" id="wr_email"
                        class="frm_input half_input email " placeholder="이메일">
                <?php } ?>

                <?php if ($is_homepage) { ?>
                    <label for="wr_homepage" class="sound_only">홈페이지</label>
                    <input type="text" name="wr_homepage" value="<?php echo $homepage ?>" id="wr_homepage"
                        class="frm_input half_input" size="50" placeholder="홈페이지">
                <?php } ?>
            </div>

            <?php if ($option) { ?>
                <div class="write_div" style="display:none;"> <!-- Hidden as per user request -->
                    <span class="sound_only">옵션</span>
                    <ul class="bo_v_option">
                        <?php echo $option ?>
                    </ul>
                </div>
            <?php } ?>

            <div class="bo_w_tit write_div">
                <style>
                    .category-wrapper {
                        display: flex;
                        gap: 10px;
                        width: 100%;
                        margin-bottom: 10px;
                        flex-wrap: wrap;
                        /* Allow wrapping for many levels */
                    }

                    .product-category-select {
                        flex: 1;
                        min-width: 150px;
                        /* Minimum width for usability */
                        display: block;
                        background-color: #2b2b2b !important;
                        color: #fff !important;
                        border: 1px solid #444 !important;
                    }

                    .product-category-select option {
                        background-color: #2b2b2b;
                        color: #fff;
                    }

                    #wr_subject {
                        width: 100%;
                        display: block;
                    }

                    /* Fix: Override global board text-area style (min-height: 400px) for Spec field */
                    #bo_w textarea#wr_10 {
                        min-height: 0 !important;
                        height: 150px !important;
                        line-height: 1.5;
                        width: 100%;
                        display: block;
                        box-sizing: border-box;
                        background-color: #2b2b2b !important;
                        color: #fff !important;
                        border: 1px solid #444 !important;
                    }

                    /* Editor Height Increase and Dark Mode */
                    .wr_content textarea {
                        min-height: 600px !important;
                        height: 600px !important;
                    }

                    .wr_content iframe {
                        min-height: 650px !important;
                        height: 650px !important;
                    }
                </style>
                <label for="ca_name" class="sound_only">제품 카테고리</label>
                <!-- Hidden Input for Gnuboard -->
                <input type="hidden" name="ca_name" id="ca_name"
                    value="<?php echo isset($write['ca_name']) ? $write['ca_name'] : ''; ?>">
                <!-- [NEW] Hidden Input for Category Code (wr_1) -->
                <input type="hidden" name="wr_1" id="wr_1_code"
                    value="<?php echo isset($write['wr_1']) ? $write['wr_1'] : ''; ?>">

                <!-- [NEW] Hidden Input for Category Code (cate) to persist URL param -->
                <input type="hidden" name="cate" value="<?php echo isset($_GET['cate']) ? $_GET['cate'] : ''; ?>">
                <!-- [NEW] Hidden Input for Highlight ID -->
                <input type="hidden" name="highlight_wr_id" value="<?php echo isset($_GET['highlight_wr_id']) ? $_GET['highlight_wr_id'] : ''; ?>">

                <div class="category-wrapper" id="category_container">
                    <select data-depth="1" class="frm_input product-category-select dynamic-cate">
                        <option value="">대분류 선택</option>
                    </select>
                </div>

                <script>
                    $(function () {
                        // 0. Parse 'cate' from URL or existing value
                        var urlParams = new URLSearchParams(window.location.search);
                        var targetCate = urlParams.get('cate') || $("#ca_name").val();

                        // Initialize: Load Level 1 (Root 10)
                        loadChildren("10", $("#category_container .dynamic-cate").first(), 1, function () {
                            if (targetCate) {
                                autoSelectCategories(targetCate);
                            }
                        });

                        // Event Delegation for Dynamic Selects
                        $(document).on("change", ".dynamic-cate", function () {
                            var $this = $(this);
                            var code = $this.val();
                            var depth = parseInt($this.data("depth"));

                            // 1. Remove all subsequent select boxes
                            $this.nextAll("select").remove();

                            // 2. Update Hidden Input
                            updateFinalCaName();

                            // 3. Load Children if a valid code is selected
                            if (code) {
                                loadChildren(code, null, depth + 1);
                            }
                        });

                        function loadChildren(parentCode, $targetElement, nextDepth, callback) {
                            $.ajax({
                                url: "<?php echo G5_PLUGIN_URL; ?>/tree_category/ajax_get_list.php",
                                type: "GET",
                                data: { root_code: parentCode },
                                dataType: "json",
                                success: function (data) {
                                    if (data.length > 0) {
                                        var $select;
                                        if ($targetElement) {
                                            $select = $targetElement;
                                            $.each(data, function (i, item) {
                                                $select.append("<option value='" + item.code + "' data-name='" + item.name + "'>" + item.name + "</option>");
                                            });
                                        } else {
                                            $select = $('<select class="frm_input product-category-select dynamic-cate" data-depth="' + nextDepth + '"><option value="">하위분류 선택</option></select>');
                                            $.each(data, function (i, item) {
                                                $select.append("<option value='" + item.code + "' data-name='" + item.name + "'>" + item.name + "</option>");
                                            });
                                            $("#category_container").append($select);
                                        }
                                        if (typeof callback === "function") callback($select);
                                    }
                                }
                            });
                        }

                        function autoSelectCategories(fullCode) {
                            // fullCode example: 1010 or 101040 (starts with '10')
                            if (!fullCode || fullCode.length < 4) return;

                            var depths = [];
                            for (var i = 4; i <= fullCode.length; i += 2) {
                                depths.push(fullCode.substring(0, i));
                            }

                            function selectNext(index) {
                                if (index >= depths.length) {
                                    updateFinalCaName();
                                    return;
                                }

                                var currentCode = depths[index];
                                var $currentSelect = $(".dynamic-cate[data-depth='" + (index + 1) + "']");

                                if ($currentSelect.length > 0) {
                                    $currentSelect.val(currentCode);

                                    // Load next depth if exists
                                    if (index + 1 < depths.length) {
                                        loadChildren(currentCode, null, index + 2, function () {
                                            selectNext(index + 1);
                                        });
                                    } else {
                                        // Final depth selection
                                        updateFinalCaName();
                                    }
                                }
                            }

                            selectNext(0);
                        }

                        function updateFinalCaName() {
                            var finalName = "";
                            $(".dynamic-cate").each(function () {
                                var name = $(this).find("option:selected").data("name");
                                if (name) {
                                    finalName = name;
                                }
                            });
                            $("#ca_name").val(finalName);

                            // [NEW] Update wr_1 with the last selected code
                            var finalCode = "";
                            $(".dynamic-cate").each(function () {
                                var code = $(this).val();
                                if (code) {
                                    finalCode = code;
                                }
                            });
                            // If no specific code selected (only root?), logic might need refinement,
                            // but generally the last valid val() is the deepest code.
                            $("#wr_1_code").val(finalCode);
                        }
                    });
                </script>

                <!-- ... content field ... -->

                <!-- Link Section Hiding -->
                <?php /* Link section moved/modified below */ ?>



                <label for="wr_subject" class="sound_only">제품명<strong>필수</strong></label>

                <div id="autosave_wrapper" class="write_div" style="display:inline-block; width:calc(100% - 215px);">
                    <input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required
                        class="frm_input full_input required" size="50" maxlength="255" style="width:100%;"
                        placeholder="제품명 (Product Name)">
                    <?php if ($is_member) { // 임시 저장된 글 기능 ?>
                        <script src="<?php echo G5_JS_URL; ?>/autosave.js"></script>
                        <?php if ($editor_content_js)
                            echo $editor_content_js; ?>
                        <button type="button" id="btn_autosave" class="btn_frmline">임시 저장된 글 (<span
                                id="autosave_count"><?php echo $autosave_count; ?></span>)</button>
                        <div id="autosave_pop">
                            <strong>임시 저장된 글 목록</strong>
                            <ul></ul>
                            <div><button type="button" class="autosave_close">닫기</button></div>
                        </div>
                    <?php } ?>
                </div>
            </div> <!-- End bo_w_tit -->

            <!-- Product Specifications (wr_10) -->
            <div class="write_div">
                <label for="wr_10" class="sound_only">제품 사양</label>
                <textarea name="wr_10" id="wr_10" class="frm_input full_input" rows="5" placeholder="제품 사양을 입력해주세요. (줄바꿈 구분)
예:
- 재질/설치타입 협의
- 목재 협의 가능"><?php echo isset($write['wr_10']) ? $write['wr_10'] : ''; ?></textarea>
            </div>

            <div class="write_div">
                <label for="wr_content" class="sound_only">내용<strong>필수</strong></label>
                <div class="wr_content <?php echo $is_dhtml_editor ? $config['cf_editor'] : ''; ?>">
                    <?php if ($write_min || $write_max) { ?>
                        <!-- 최소/최대 글자 수 사용 시 -->
                        <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대
                            <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.
                        </p>
                    <?php } ?>
                    <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
                    <?php if ($write_min || $write_max) { ?>
                        <!-- 최소/최대 글자 수 사용 시 -->
                        <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                    <?php } ?>
                </div>

            </div>

            <?php for ($i = 1; $is_link && $i <= G5_LINK_COUNT; $i++) { ?>
                <div class="bo_w_link write_div" style="display:none;">
                    <label for="wr_link<?php echo $i ?>"><i class="fa fa-link" aria-hidden="true"></i><span
                            class="sound_only">
                            링크 #<?php echo $i ?></span></label>
                    <input type="text" name="wr_link<?php echo $i ?>" value="<?php if ($w == "u") {
                           echo $write['wr_link' . $i];
                       } ?>" id="wr_link<?php echo $i ?>" class="frm_input full_input" size="50">
                </div>
            <?php } ?>

            <?php for ($i = 0; $is_file && $i < $file_count; $i++) { ?>
                <div class="bo_w_flie write_div">
                    <div class="file_wr write_div">
                        <label for="bf_file_<?php echo $i + 1 ?>" class="lb_icon"><i class="fa fa-folder-open"
                                aria-hidden="true"></i><span class="sound_only"> 파일 #<?php echo $i + 1 ?></span></label>
                        <input type="file" name="bf_file[]" id="bf_file_<?php echo $i + 1 ?>"
                            title="파일첨부 <?php echo $i + 1 ?> : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능"
                            class="frm_file ">
                    </div>
                    <?php if ($i == 0) { ?>
                        <p class="frm_info" style="margin-top:5px; color:var(--color-primary);">※ 첫 번째 이미지는 <strong>대표
                                이미지</strong>로
                            사용됩니다.</p>
                    <?php } ?>
                    <?php if ($is_file_content) { ?>
                        <input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>"
                            title="파일 설명을 입력해주세요." class="full_input frm_input" size="50" placeholder="파일 설명을 입력해주세요.">
                    <?php } ?>

                    <?php if ($w == 'u' && $file[$i]['file']) { ?>
                        <span class="file_del">
                            <input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i; ?>]"
                                value="1">
                            <label
                                for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'] . '(' . $file[$i]['size'] . ')'; ?>
                                파일
                                삭제</label>
                        </span>
                    <?php } ?>

                </div>
            <?php } ?>


            <?php if ($is_use_captcha) { //자동등록방지  ?>
                <div class="write_div">
                    <?php echo $captcha_html ?>
                </div>
            <?php } ?>

            <div class="btn_confirm write_div">
                <a href="<?php echo get_pretty_url($bo_table); ?>" class="btn_cancel btn">취소</a>
                <button type="submit" id="btn_submit" accesskey="s" class="btn_submit btn">작성완료</button>
            </div>
        </form>

        <script>
            <?php if ($write_min || $write_max) { ?>
                // 글자수 제한
                var char_min = parseInt(<?php echo $write_min; ?>); // 최소
                var char_max = parseInt(<?php echo $write_max; ?>); // 최대
                check_byte("wr_content", "char_count");

                $(function () {
                    $("#wr_content").on("keyup", function () {
                        check_byte("wr_content", "char_count");
                    });
                });

            <?php } ?>
            function html_auto_br(obj) {
                if (obj.checked) {
                    result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
                    if (result)
                        obj.value = "html2";
                    else
                        obj.value = "html1";
                }
                else
                    obj.value = "";
            }

            function fwrite_submit(f) {
                <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

                var subject = "";
                var content = "";
                $.ajax({
                    url: g5_bbs_url + "/ajax.filter.php",
                    type: "POST",
                    data: {
                        "subject": f.wr_subject.value,
                        "content": f.wr_content.value
                    },
                    dataType: "json",
                    async: false,
                    cache: false,
                    success: function (data, textStatus) {
                        subject = data.subject;
                        content = data.content;
                    }
                });

                if (subject) {
                    alert("제목에 금지단어('" + subject + "')가 포함되어있습니다");
                    f.wr_subject.focus();
                    return false;
                }

                if (content) {
                    alert("내용에 금지단어('" + content + "')가 포함되어있습니다");
                    if (typeof (ed_wr_content) != "undefined")
                        ed_wr_content.returnFalse();
                    else
                        f.wr_content.focus();
                    return false;
                }

                if (document.getElementById("char_count")) {
                    if (char_min > 0 || char_max > 0) {
                        var cnt = parseInt(check_byte("wr_content", "char_count"));
                        if (char_min > 0 && char_min > cnt) {
                            alert("내용은 " + char_min + "글자 이상 쓰셔야 합니다.");
                            return false;
                        }
                        else if (char_max > 0 && char_max < cnt) {
                            alert("내용은 " + char_max + "글자 이하로 쓰셔야 합니다.");
                            return false;
                        }
                    }
                }

                <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

                document.getElementById("btn_submit").disabled = "disabled";

                return true;
            }
        </script>

        <script>
            // 상품 글쓰기 페이지를 위한 스마트에디터2 높이 조절
            $(window).on("load", function () {
                var seInterval = setInterval(function () {
                    var $editorIframes = $(".wr_content iframe");
                    if ($editorIframes.length > 0) {
                        var allLoaded = true;
                        $editorIframes.each(function () {
                            try {
                                var $doc = $(this).contents();
                                var $innerFrame = $doc.find("#se2_iframe");
                                var $inputArea = $doc.find(".se2_input_area");
                                var $resizeBar = $doc.find(".husky_seditor_editingArea_verticalResizer");

                                if ($innerFrame.length > 0) {
                                    $innerFrame.css({ "height": "600px", "min-height": "600px" });
                                    $inputArea.css({ "height": "600px", "min-height": "600px" });
                                    // 선택사항: 텍스트 모드 높이도 조절
                                    $doc.find("textarea.se2_input_syntax").css("height", "600px");
                                    $doc.find("textarea.se2_input_text").css("height", "600px");

                                    // 자동 리사이즈 바 숨김 (오동작 방지) 또는 위치 조정
                                    if ($resizeBar.length > 0) {
                                        // $resizeBar.hide(); // 혹은 아래로 위치 조정
                                        // 리사이즈 바가 있다면, 컨테이너 높이에 맞춰 상대적으로 위치를 잡아야 할 수 있음.
                                    }

                                    // 부모 iframe (현재 페이지의 iframe) 높이도 넉넉하게 조정 (스크립트로 가능한 경우)
                                    // CSS로 650px 잡았으므로 생략 가능하나, 확실히 하기 위해 추가 가능
                                    $(this).css("height", "650px");

                                } else {
                                    allLoaded = false;
                                }
                            } catch (e) {
                                // 크로스 오리진 문제나 로딩 대기 무시
                            }
                        });

                        // 내부 요소를 찾았으면 중단, 그렇지 않으면 잠시 계속 시도
                        if ($editorIframes.length > 0 && allLoaded) clearInterval(seInterval);
                    }
                }, 500);

                // 메모리 누수 방지를 위해 5초 후 확인 중단
                setTimeout(function () { clearInterval(seInterval); }, 5000);
            });
        </script>
    </section>
</div>
<!-- } 게시물 작성/수정 끝 -->