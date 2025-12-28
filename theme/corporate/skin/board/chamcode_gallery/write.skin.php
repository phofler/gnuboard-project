<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css">', 0);
?>

<div id="bo_w" class="sub-layout-width-height">
    <h2 class="sound_only"><?php echo $g5['title'] ?></h2>

    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);"
        method="post" enctype="multipart/form-data" autocomplete="off">
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
                $option .= PHP_EOL . '<li class="chk_box notice_chk"><input type="checkbox" id="notice" name="notice"  class="selec_chk" value="1" ' . $notice_checked . '>' . PHP_EOL . '<label for="notice"><span></span><i class="fa fa-bullhorn" aria-hidden="true"></i> 공지글로 등록</label></li>';
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
                <label for="ca_name" class="sound_only">분류</label>
                <select name="ca_name" id="ca_name" required>
                    <option value="">분류를 선택하세요</option>
                    <?php echo $category_option ?>
                </select>
            </div>
        <?php } ?>
        <div class="fieldset-box">
            <?php if ($is_name) { ?>
                <fieldset>
                    <label for="wr_name">이름<span class="required-ico"></span></label>
                    <input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required
                        class="frm_input half_input required" placeholder="이름">
                </fieldset>
            <?php } ?>
            <?php if ($is_password) { ?>
                <fieldset>
                    <label for="wr_password">비밀번호</label>
                    <input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?>
                        class="frm_input half_input <?php echo $password_required ?>" placeholder="비밀번호">
                </fieldset>
            <?php } ?>
            <?php if ($is_email) { ?>
                <fieldset>
                    <label for="wr_email">이메일</label>
                    <input type="text" name="wr_email" value="<?php echo $email ?>" id="wr_email"
                        class="frm_input half_input email " placeholder="이메일">
                </fieldset>
            <?php } ?>
            <?php if ($is_homepage) { ?>
                <fieldset>
                    <label for="wr_homepage">홈페이지</label>
                    <input type="text" name="wr_homepage" value="<?php echo $homepage ?>" id="wr_homepage"
                        class="frm_input half_input" size="50" placeholder="홈페이지">
                </fieldset>
            <?php } ?>
        </div>
        <?php if ($option) { ?>
            <div class="write_div option-box">
                <span class="sound_only">옵션</span>
                <ul class="bo_v_option clf">
                    <?php echo $option ?>
                </ul>
            </div>
        <?php } ?>

        <div class="bo_w_tit write_div">
            <label for="wr_subject">제목<span class="required-ico"></span></label>
            <div id="autosave_wrapper" class="write_div">
                <input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required
                    class="frm_input full_input required" size="50" maxlength="255" placeholder="제목">
                <?php if ($is_member) { // 임시 저장된 글 기능 
                        ?>
                    <!-- <script src="<?php echo G5_JS_URL; ?>/autosave.js"></script>
                    <?php if ($editor_content_js)
                        echo $editor_content_js; ?>
                    <button type="button" id="btn_autosave" class="btn_frmline">임시 저장된 글 (<span
                            id="autosave_count"><?php echo $autosave_count; ?></span>)</button>
                    <div id="autosave_pop">
                        <strong>임시 저장된 글 목록</strong>
                        <ul></ul>
                        <div><button type="button" class="autosave_close">닫기</button></div>
                    </div> -->
                <?php } ?>
            </div>
        </div>

        <div class="write_div wr_content-box">
            <label for="wr_content">내용<span class="required-ico"></span></label>
            <div class="wr_content <?php echo $is_dhtml_editor ? $config['cf_editor'] : ''; ?>">
                <?php if ($write_min || $write_max) { ?>
                    <!-- 최소/최대 글자 수 사용 시 -->
                    <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대
                        <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.
                    </p>
                <?php } ?>
                <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 
                ?>
                <?php if ($write_min || $write_max) { ?>
                    <!-- 최소/최대 글자 수 사용 시 -->
                    <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                <?php } ?>
            </div>

        </div>
        <div class="link-box">
            <?php for ($i = 1; $is_link && $i <= G5_LINK_COUNT; $i++) { ?>
                <div class="bo_w_link write_div">
                    <label for="wr_link<?php echo $i ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-link">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 15l6 -6" />
                            <path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" />
                            <path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" />
                        </svg>링크 #<?php echo $i ?></label>
                    <input type="text" name="wr_link<?php echo $i ?>" value="<?php if ($w == "u") {
                           echo $write['wr_link' . $i];
                       } ?>" id="wr_link<?php echo $i ?>" class="frm_input full_input" size="50">
                </div>
            <?php } ?>
        </div>
        <div class="file-box">
            <?php for ($i = 0; $is_file && $i < $file_count; $i++) { ?>
                <div class="bo_w_flie write_div">
                    <div class="file_wr write_div">
                        <label for="bf_file_<?php echo $i + 1 ?>"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-photo">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 8h.01" />
                                <path d="M3 6a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3v-12z" />
                                <path d="M3 16l5 -5c.928 -.893 2.072 -.893 3 0l5 5" />
                                <path d="M14 14l1 -1c.928 -.893 2.072 -.893 3 0l3 3" />
                            </svg>이미지 #<?php echo $i + 1 ?></label>
                        <input type="file" name="bf_file[]" id="bf_file_<?php echo $i + 1 ?>"
                            title="파일첨부 <?php echo $i + 1 ?> : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능"
                            class="frm_file ">
                        <?php if ($w == '') { ?>
                            <figure class="preview"></figure>
                        <?php } ?>
                        <?php if ($w == 'u' && $file[$i]['file']) { ?>
                            <figure class="preview">
                                <?php
                                $extension = '';
                                if (mb_strlen($file[$i]['source'], 'utf-8') > 32) {
                                    $filename = $file[$i]['source'];
                                    $extension = '... .';
                                    preg_match('/\.([a-z0-9]+)$/i', $filename, $matches);

                                    if (!empty($matches[1])) {
                                        $extension .= $matches[1];
                                    }
                                } ?>
                                <span class="file_del">
                                    <input type="checkbox" id="bf_file_del<?php echo $i ?>"
                                        name="bf_file_del[<?php echo $i; ?>]" value="1"> <label
                                        for="bf_file_del<?php echo $i ?>"><?php echo cut_str($file[$i]['source'], 32, $extension) . ' (' . $file[$i]['size'] . ')'; ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="currentColor"
                                            class="icon icon-tabler icons-tabler-filled icon-tabler-square-rounded-x">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M12 2l.324 .001l.318 .004l.616 .017l.299 .013l.579 .034l.553 .046c4.785 .464 6.732 2.411 7.196 7.196l.046 .553l.034 .579c.005 .098 .01 .198 .013 .299l.017 .616l.005 .642l-.005 .642l-.017 .616l-.013 .299l-.034 .579l-.046 .553c-.464 4.785 -2.411 6.732 -7.196 7.196l-.553 .046l-.579 .034c-.098 .005 -.198 .01 -.299 .013l-.616 .017l-.642 .005l-.642 -.005l-.616 -.017l-.299 -.013l-.579 -.034l-.553 -.046c-4.785 -.464 -6.732 -2.411 -7.196 -7.196l-.046 -.553l-.034 -.579a28.058 28.058 0 0 1 -.013 -.299l-.017 -.616c-.003 -.21 -.005 -.424 -.005 -.642l.001 -.324l.004 -.318l.017 -.616l.013 -.299l.034 -.579l.046 -.553c.464 -4.785 2.411 -6.732 7.196 -7.196l.553 -.046l.579 -.034c.098 -.005 .198 -.01 .299 -.013l.616 -.017c.21 -.003 .424 -.005 .642 -.005zm-1.489 7.14a1 1 0 0 0 -1.218 1.567l1.292 1.293l-1.292 1.293l-.083 .094a1 1 0 0 0 1.497 1.32l1.293 -1.292l1.293 1.292l.094 .083a1 1 0 0 0 1.32 -1.497l-1.292 -1.293l1.292 -1.293l.083 -.094a1 1 0 0 0 -1.497 -1.32l-1.293 1.292l-1.293 -1.292l-.094 -.083z"
                                                fill="currentColor" stroke-width="0" />
                                        </svg><span class="sound_only">파일 삭제</span></label>
                                </span>
                                <?php
                                $file = get_file($bo_table, $wr_id);
                                $image = urlencode($file[$i]['file']);
                                $image_path = G5_DATA_PATH . '/file/' . $bo_table;
                                $image_url = G5_DATA_URL . '/file/' . $bo_table;
                                if (preg_match("/\.(gif|jpg|jpeg|png)$/i", $image)) {
                                    $thumb = thumbnail($image, $image_path, $image_path, 200, 200, false, true);
                                    $image_content = $image_url . '/' . $thumb;
                                    echo "<img class=\"current\" src=" . $image_content . " alt=''>";
                                }
                                ?>
                            </figure>
                        <?php } ?>
                    </div>
                    <?php if ($is_file_content) { ?>
                        <input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>"
                            title="파일 설명을 입력해주세요." class="full_input frm_input" size="50" placeholder="파일 설명을 입력해주세요.">
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

        <?php if ($is_use_captcha) { //자동등록방지  
                ?>
            <div class="write_div">
                <?php echo $captcha_html ?>
            </div>
        <?php } ?>

        <div class="btn_confirm write_div">
            <a href="<?php echo get_pretty_url($bo_table); ?>" class="btn_cancel btn"><svg
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-left">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 12l14 0" />
                    <path d="M5 12l4 4" />
                    <path d="M5 12l4 -4" />
                </svg>취소</a>
            <button type="submit" id="btn_submit" accesskey="s" class="btn_submit btn"><svg
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                    <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M14 4l0 4l-6 0l0 -4" />
                </svg>저장</button>
        </div>
    </form>

    <script>
        $(function () {
            $('.frm_file').on('change', function (e) {
                thumbs.uploadPreview(e);
            });
            if ($('.fieldset-box fieldset').size() == 0) {
                $('.fieldset-box').remove();
            }
        });
        var thumbs = {
            uploadPreview: function (evt) {
                var files = evt.target.files;
                for (var i = 0, f; f = files[i]; i++) {
                    if (!f.type.match('image.*')) {
                        alert('이미지 파일만 업로드할 수 있습니다!');
                        evt.target.value = ''; // 파일 선택을 초기화하여 업로드를 방지
                        return;

                    }
                    var reader = new FileReader();
                    reader.onload = (function (theFile) {
                        return function (e) {
                            $(evt.target).next('.preview').find('img:not(.current)').remove();
                            $('<img src="' + e.target.result + '" title="' + escape(theFile.name) + '" />').appendTo($(evt.target).next('.preview'));
                        };
                    })(f);
                    reader.readAsDataURL(f);
                }
            }
        }
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
            } else
                obj.value = "";
        }

        function fwrite_submit(f) {
            <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   
            ?>

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
                    } else if (char_max > 0 && char_max < cnt) {
                        alert("내용은 " + char_max + "글자 이하로 쓰셔야 합니다.");
                        return false;
                    }
                }
            }

            <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  
            ?>

            document.getElementById("btn_submit").disabled = "disabled";

            return true;
        }
    </script>
</div>
<!-- } 게시물 작성/수정 끝 -->