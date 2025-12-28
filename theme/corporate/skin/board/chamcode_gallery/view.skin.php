<?php
if (!defined("_GNUBOARD_"))
    exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 게시물 읽기 시작 { -->

<div id="bo_v" class="sub-layout-width-height">
    <header>
        <?php if ($category_name || $view['is_notice']) { ?>
            <div class="bo_v_top_info">
                <?php if ($category_name) { ?>
                    <span class="bo_v_cate"><?php echo $view['ca_name']; ?></span>
                <?php } ?>
                <?php if ($view['is_notice']) { ?>
                    <span class="bo_v_notice">공지</span>
                <?php } ?>
            </div>
        <?php } ?>

        <h2 id="bo_v_title">
            <span class="bo_v_tit"><?php echo get_text($view['wr_subject']); ?></span>
        </h2>

        <ul class="etc_info">
            <li class="date"><i class="fa fa-clock-o"></i>
                <?php echo date("Y-m-d H:i", strtotime($view['wr_datetime'])) ?></li>
            <li class="views"><i class="fa fa-eye"></i> <strong><?php echo number_format($view['wr_hit']) ?></strong>
                views</li>
            <?php /* if ($scrap_href) { ?>
      <li class="scrap">
          <a href="<?php echo $scrap_href; ?>" target="_blank" onclick="win_scrap(this.href); return false;">
              스크랩
          </a>
      </li>
  <?php } */ ?>
        </ul>

        <article class="profile_info">
            <div class="writer">
                <figure class="pf_img"><?php echo get_member_profile_img($view['mb_id']) ?></figure>
                <p>
                    <span class="writer_name"><?php echo $view['name'] ?></span>
                    <?php if ($is_ip_view) {
                        echo "<span class=\"ip\">($ip)</span>";
                    } ?>
                </p>
            </div>
            <div class="profile_info_ct">
                <strong>
                    <a href="#bo_vc">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-message-dots">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <circle cx="12" cy="11" r="0.01" fill="currentColor" />
                            <circle cx="8" cy="11" r="0.01" fill="currentColor" />
                            <circle cx="16" cy="11" r="0.01" fill="currentColor" />
                            <path
                                d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3z" />
                        </svg>
                        <span><?php echo number_format($view['wr_comment']) ?> Comments</span>
                    </a>
                </strong>
            </div>
        </article>
    </header>
    <!-- 게시물 메뉴 시작 { -->
    <nav id="board-menu">
        <?php ob_start(); ?>
        <button><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-dots">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M5 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                <path d="M19 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
            </svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M18 6l-12 12" />
                <path d="M6 6l12 12" />
            </svg></button>
        <ul>
            <li><a href="<?php echo $list_href ?>" title="목록"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-menu-2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 6l16 0" />
                        <path d="M4 12l16 0" />
                        <path d="M4 18l16 0" />
                    </svg>목록</a></li>
            <?php /* if ($reply_href) { ?>
           <li><a href="<?php echo $reply_href ?>" title="답변"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                       height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                       stroke-linecap="round" stroke-linejoin="round"
                       class="icon icon-tabler icons-tabler-outline icon-tabler-corner-down-right">
                       <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                       <path d="M6 6v6a3 3 0 0 0 3 3h10l-4 -4m0 8l4 -4" />
                   </svg>답변</a></li><?php } */ ?>
            <?php if ($write_href) { ?>
                <li><a href="<?php echo $write_href ?>" title="글쓰기"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>글쓰기</a></li><?php } ?>
            <?php if ($update_href || $delete_href || $copy_href || $move_href || $search_href) { ?>
                <?php if ($update_href) { ?>
                    <li><a href="<?php echo $update_href ?>" title="수정"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-eraser">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M19 20h-10.5l-4.21 -4.3a1 1 0 0 1 0 -1.41l10 -10a1 1 0 0 1 1.41 0l5 5a1 1 0 0 1 0 1.41l-9.2 9.3" />
                                <path d="M18 13.3l-6.3 -6.3" />
                            </svg>수정</a></li><?php } ?>
                <?php if ($delete_href) { ?>
                    <li><a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;" title="삭제"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7l16 0" />
                                <path d="M10 11l0 6" />
                                <path d="M14 11l0 6" />
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            </svg>삭제</a></li><?php } ?>
                <?php /* if ($copy_href) { ?>
                   <li><a href="<?php echo $copy_href ?>" onclick="board_move(this.href); return false;" title="복사"><svg
                               xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                               class="icon icon-tabler icons-tabler-outline icon-tabler-copy">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                               <path
                                   d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                               <path
                                   d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                           </svg>복사</a></li><?php } */ ?>
                <?php /* if ($move_href) { ?>
                   <li><a href="<?php echo $move_href ?>" onclick="board_move(this.href); return false;" title="이동"><svg
                               xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                               class="icon icon-tabler icons-tabler-outline icon-tabler-arrows-move">
                               <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                               <path d="M18 9l3 3l-3 3" />
                               <path d="M15 12h6" />
                               <path d="M6 9l-3 3l3 3" />
                               <path d="M3 12h6" />
                               <path d="M9 18l3 3l3 -3" />
                               <path d="M12 15v6" />
                               <path d="M15 6l-3 -3l-3 3" />
                               <path d="M12 3v6" />
                           </svg>이동</a></li><?php } */ ?>
                <?php if ($search_href) { ?>
                    <li><a href="<?php echo $search_href ?>" title="검색"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                <path d="M21 21l-6 -6" />
                            </svg>검색</a></li><?php } ?>
            <?php } ?>
        </ul>
        <script>
            jQuery(function ($) {
                setTimeout(function () {
                    $('#board-menu button').click();
                }, 600);

                $('#board-menu > button').on('click', function (e) {
                    e.preventDefault();
                    $(this).parent().toggleClass('active');
                });
            });
        </script>
        <?php
        $link_buttons = ob_get_contents();
        ob_end_flush();
        ?>
    </nav>
    <!-- } 게시물 메뉴 끝 -->
    <section id="bo_v_atc">
        <h2 id="bo_v_atc_title">본문</h2>
        <div id="bo_v_share">
            <?php include_once(G5_SNS_PATH . "/view.sns.skin.php"); ?>
        </div>

        <?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if ($v_img_count) {
            echo "<div id=\"bo_v_img\">\n";

            foreach ($view['file'] as $view_file) {
                echo get_file_thumbnail($view_file);
            }

            echo "</div>\n";
        }
        ?>

        <!-- 본문 내용 시작 { -->
        <div id="bo_v_con"><?php echo get_view_thumbnail($view['content']); ?></div>
        <?php //echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 
        ?>
        <!-- } 본문 내용 끝 -->

        <?php if ($is_signature) { ?>
            <p><?php echo $signature ?></p><?php } ?>


        <!--  추천 비추천 시작 { -->
        <?php if ($good_href || $nogood_href) { ?>
            <div id="bo_v_act">
                <?php if ($good_href) { ?>
                    <span class="bo_v_act_gng">
                        <a href="<?php echo $good_href . '&amp;' . $qstr ?>" id="good_button" class="bo_v_good"><i
                                class="fa fa-thumbs-o-up" aria-hidden="true"></i><span
                                class="sound_only">추천</span><strong><?php echo number_format($view['wr_good']) ?></strong></a>
                        <b id="bo_v_act_good"></b>
                    </span>
                <?php } ?>
                <?php if ($nogood_href) { ?>
                    <span class="bo_v_act_gng">
                        <a href="<?php echo $nogood_href . '&amp;' . $qstr ?>" id="nogood_button" class="bo_v_nogood"><i
                                class="fa fa-thumbs-o-down" aria-hidden="true"></i><span
                                class="sound_only">비추천</span><strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
                        <b id="bo_v_act_nogood"></b>
                    </span>
                <?php } ?>
            </div>
        <?php } else {
            if ($board['bo_use_good'] || $board['bo_use_nogood']) {
                ?>
                <div id="bo_v_act">
                    <?php if ($board['bo_use_good']) { ?><span class="bo_v_good"><i class="fa fa-thumbs-o-up"
                                aria-hidden="true"></i><span
                                class="sound_only">추천</span><strong><?php echo number_format($view['wr_good']) ?></strong></span><?php } ?>
                    <?php if ($board['bo_use_nogood']) { ?><span class="bo_v_nogood"><i class="fa fa-thumbs-o-down"
                                aria-hidden="true"></i><span
                                class="sound_only">비추천</span><strong><?php echo number_format($view['wr_nogood']) ?></strong></span><?php } ?>
                </div>
                <?php
            }
        }
        ?>
        <!-- }  추천 비추천 끝 -->
    </section>

    <?php
    $cnt = 0;
    if ($view['file']['count']) {
        for ($i = 0; $i < count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
    ?>

    <?php if ($cnt) { ?>
        <!-- 첨부파일 시작 { -->
        <section id="bo_v_file">
            <h2>첨부파일</h2>
            <ul>
                <?php
                // 가변 파일
                for ($i = 0; $i < count($view['file']); $i++) {
                    if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
                        ?>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-paperclip">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M15 7l-6.5 6.5a1.5 1.5 0 0 0 3 3l6.5 -6.5a3 3 0 0 0 -6 -6l-6.5 6.5a4.5 4.5 0 0 0 9 9l6.5 -6.5" />
                            </svg>
                            <a href="<?php echo $view['file'][$i]['href']; ?>" class="view_file_download">
                                <strong><?php echo $view['file'][$i]['source'] ?></strong>
                                <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                            </a>
                            <span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드 | DATE :
                                <?php echo $view['file'][$i]['datetime'] ?></span>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </section>
        <!-- } 첨부파일 끝 -->
    <?php } ?>

    <?php if (isset($view['link']) && array_filter($view['link'])) { ?>
        <!-- 관련링크 시작 { -->
        <section id="bo_v_link">
            <h2>관련링크</h2>
            <ul>
                <?php
                // 링크
                $cnt = 0;
                for ($i = 1; $i <= count($view['link']); $i++) {
                    if ($view['link'][$i]) {
                        $cnt++;
                        $link = cut_str($view['link'][$i], 70);
                        ?>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-link">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 15l6 -6" />
                                <path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" />
                                <path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" />
                            </svg>
                            <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                                <strong><?php echo $link ?></strong>
                            </a>
                            <span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </section>
        <!-- } 관련링크 끝 -->
    <?php } ?>

    <?php if ($prev_href || $next_href) { ?>
        <ul class="bo_v_nb">
            <?php if ($prev_href) { ?>
                <li class="btn_prv"><span class="nb_tit"><i class="fa fa-chevron-up" aria-hidden="true"></i> 이전글</span><a
                        href="<?php echo $prev_href ?>"><?php echo $prev_wr_subject; ?></a> <span
                        class="nb_date"><?php echo str_replace('-', '.', substr($prev_wr_date, '2', '8')); ?></span></li>
            <?php } ?>
            <?php if ($next_href) { ?>
                <li class="btn_next"><span class="nb_tit"><i class="fa fa-chevron-down" aria-hidden="true"></i> 다음글</span><a
                        href="<?php echo $next_href ?>"><?php echo $next_wr_subject; ?></a> <span
                        class="nb_date"><?php echo str_replace('-', '.', substr($next_wr_date, '2', '8')); ?></span></li>
            <?php } ?>
        </ul>
    <?php } ?>

    <?php
    // 코멘트 입출력
    // include_once(G5_BBS_PATH . '/view_comment.php');
    ?>
</div>
<!-- } 게시판 읽기 끝 -->

<script>
    <?php if ($board['bo_download_point'] < 0) { ?>
        $(function () {
            $("a.view_file_download").click(function () {
                if (!g5_is_member) {
                    alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
                    return false;
                }

                var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

                if (confirm(msg)) {
                    var href = $(this).attr("href") + "&js=on";
                    $(this).attr("href", href);

                    return true;
                } else {
                    return false;
                }
            });
        });
    <?php } ?>

    function board_move(href) {
        window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
    }
</script>

<script>
    $(function () {
        $("a.view_image").click(function () {
            window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
            return false;
        });

        // 추천, 비추천
        $("#good_button, #nogood_button").click(function () {
            var $tx;
            if (this.id == "good_button")
                $tx = $("#bo_v_act_good");
            else
                $tx = $("#bo_v_act_nogood");

            excute_good(this.href, $(this), $tx);
            return false;
        });

        // 이미지 리사이즈
        $("#bo_v_atc").viewimageresize();
    });

    function excute_good(href, $el, $tx) {
        $.post(
            href, {
            js: "on"
        },
            function (data) {
                if (data.error) {
                    alert(data.error);
                    return false;
                }

                if (data.count) {
                    $el.find("strong").text(number_format(String(data.count)));
                    if ($tx.attr("id").search("nogood") > -1) {
                        $tx.text("이 글을 비추천하셨습니다.");
                        $tx.fadeIn(200).delay(2500).fadeOut(200);
                    } else {
                        $tx.text("이 글을 추천하셨습니다.");
                        $tx.fadeIn(200).delay(2500).fadeOut(200);
                    }
                }
            }, "json"
        );
    }
</script>
<!-- } 게시글 읽기 끝 -->