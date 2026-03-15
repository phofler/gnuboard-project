<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가

// 선택된 스타일 add_stylesheet 로 추가
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css">', 0);
?>

<div class="custom-board-wrap">
    <!-- 1. 게시판 카테고리 (있을 경우) -->
    <?php if ($is_category) { ?>
        <nav class="board-category">
            <ul>
                <?php echo $category_option ?>
            </ul>
        </nav>
    <?php } ?>

    <!-- 2. 게시물 목록 (GRID Layout) -->
    <div class="board-list-head">
        <div class="cell num">번호</div>
        <div class="cell subject">제목</div>
        <div class="cell writer">글쓴이</div>
        <div class="cell date">날짜</div>
        <div class="cell hit">조회</div>
    </div>

    <ul class="board-list-body">
        <?php
        for ($i = 0; $i < count($list); $i++) {
            ?>
            <li class="list-row">
                <div class="cell num"><?php echo $list[$i]['num'] ?></div>
                <div class="cell subject">
                    <?php if ($is_checkbox) { ?>
                        <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>">
                    <?php } ?>
                    <a href="<?php echo $list[$i]['href'] ?>">
                        <?php echo $list[$i]['subject'] ?>
                        <?php if ($list[$i]['comment_cnt']) { ?><span
                                class="cnt"><?php echo $list[$i]['comment_cnt'] ?></span><?php } ?>
                    </a>
                </div>
                <div class="cell writer"><?php echo $list[$i]['name'] ?></div>
                <div class="cell date"><?php echo $list[$i]['datetime2'] ?></div>
                <div class="cell hit"><?php echo $list[$i]['wr_hit'] ?></div>
            </li>
        <?php } ?>
        <?php if (count($list) == 0) {
            echo "<li class='empty_table'>게시물이 없습니다.</li>";
        } ?>
    </ul>

    <!-- 3. 버튼 영역 -->
    <div class="board-btn-area">
        <?php if ($list_href) { ?><a href="<?php echo $list_href ?>" class="btn_b01">목록</a><?php } ?>
        <?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn_b02">글쓰기</a><?php } ?>
    </div>
</div>

<style>
    /* 간단하고 깔끔한 스타일 */
    .custom-board-wrap {
        max-width: 100%;
        margin: 20px 0;
        font-family: 'Noto Sans KR', sans-serif;
    }

    .board-list-head {
        display: grid;
        grid-template-columns: 60px 1fr 100px 100px 60px;
        background: #f9f9f9;
        padding: 15px 0;
        border-top: 2px solid #333;
        font-weight: bold;
        text-align: center;
    }

    .board-list-body .list-row {
        display: grid;
        grid-template-columns: 60px 1fr 100px 100px 60px;
        padding: 12px 0;
        border-bottom: 1px solid #eee;
        align-items: center;
        text-align: center;
    }

    .board-list-body .subject {
        text-align: left;
        padding-left: 10px;
    }

    .board-list-body .subject a {
        text-decoration: none;
        color: #333;
    }

    .board-list-body .subject .cnt {
        color: #e83e8c;
        font-size: 0.9em;
        margin-left: 5px;
    }

    /* 모바일 반응형 */
    @media (max-width: 768px) {
        .board-list-head {
            display: none;
        }

        .board-list-body .list-row {
            display: block;
            text-align: left;
            padding: 15px;
        }

        .cell {
            display: inline-block;
            margin-right: 10px;
            color: #888;
            font-size: 0.9em;
        }

        .cell.subject {
            display: block;
            font-size: 1.1em;
            color: #000;
            margin-bottom: 5px;
            width: 100%;
            padding: 0;
        }

        .cell.num,
        .cell.hit {
            display: none;
        }
    }
</style>