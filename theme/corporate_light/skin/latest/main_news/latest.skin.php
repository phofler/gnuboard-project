<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가

// $options로 me_code 전달 받음 (latest 함수의 5번째 인자)
$me_code_param = isset($options) && $options ? '&amp;me_code=' . $options : '';
?>

<div class="news-item">
    <h3
        style="border-bottom: 1px solid #333; padding-bottom: 15px; margin-bottom: 20px; color: #fff; font-family: 'Malgun Gothic', 'Dotum', sans-serif;">
        <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?><?php echo $me_code_param ?>"
            style="color:#fff; text-decoration:none;">
            <?php echo $bo_subject ?>
        </a>
    </h3>
    <ul style="list-style: none; padding: 0;">
        <?php for ($i = 0; $i < count($list); $i++) { ?>
            <li style="padding: 10px 0; border-bottom: 1px solid #222; color: #888;">
                <span style="float: right; font-size: 0.8rem; color: #555;">
                    <?php echo $list[$i]['datetime2'] ?>
                </span>
                <a href="<?php echo $list[$i]['href'] ?><?php echo $me_code_param ?>" style="color: #ccc;">
                    <?php echo $list[$i]['subject'] ?>
                    <?php if ($list[$i]['icon_new'])
                        echo "<span style='color:#dac49d; font-size:10px; margin-left:5px;'>N</span>"; ?>
                </a>
            </li>
        <?php } ?>
        <?php if (count($list) == 0) { // 게시물이 없을 때 ?>
            <li style="padding: 10px 0; border-bottom: 1px solid #222; color: #888; text-align:center;">
                게시물이 없습니다.
            </li>
        <?php } ?>
    </ul>
</div>