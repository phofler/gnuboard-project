<?php
if (!defined('_GNUBOARD_'))
    exit;
?>

<div class="tbl_head01 tbl_wrap">
    <table>
        <caption><?php echo $g5['title']; ?></caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
            <tr>
                <th scope="row">제목</th>
                <td><?php echo get_text($view['subject']); ?></td>
            </tr>
            <tr>
                <th scope="row">작성자</th>
                <td><?php echo get_text($view['name']); ?></td>
            </tr>
            <tr>
                <th scope="row">연락처</th>
                <td><?php echo get_text($view['contact']); ?></td>
            </tr>
            <tr>
                <th scope="row">이메일</th>
                <td><?php echo get_text($view['email']); ?></td>
            </tr>
            <tr>
                <th scope="row">접수일시</th>
                <td><?php echo $view['reg_date']; ?></td>
            </tr>
            <tr>
                <th scope="row">IP</th>
                <td><?php echo $view['ip']; ?></td>
            </tr>
            <tr>
                <th scope="row">내용</th>
                <td><?php echo nl2br(get_text($view['content'])); ?></td>
            </tr>
        </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <a href="./list.php" class="btn btn_02">목록</a>
    <a href="./delete.php?id=<?php echo $view['id']; ?>" onclick="return confirm('정말 삭제하시겠습니까?');"
        class="btn btn_02">삭제</a>
</div>