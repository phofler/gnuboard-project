<?php
if (!defined("_GNUBOARD_"))
    exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<div class="product-layout-container" id="page_start">
    <aside class="product-sidebar-area">
        <?php include_once(G5_THEME_PATH . '/skin/board/product/sidebar.product.php'); ?>
    </aside>

    <main class="product-content-area">
        <article id="bo_v">
            <header>
                <h2 id="bo_v_title">
                    <span class="bo_v_tit"><?php echo cut_str(get_text($view['wr_subject']), 255); ?></span>
                </h2>
            </header>

            <!-- [1] Product Main Image Area -->
            <div class="product-view-image">
                <?php
                if ($view['file'] && count($view['file'])) {
                    echo '<div id="bo_v_img">';
                    foreach ($view['file'] as $view_file) {
                        if (isset($view_file['view']) && $view_file['view']) {
                            echo get_view_thumbnail($view_file['view']);
                        }
                    }
                    echo '</div>';
                }
                ?>
            </div>

            <!-- [2] Product Title Bar -->
            <div class="product-title-bar">
                <h3><?php echo $view['wr_subject']; ?></h3>
            </div>

            <!-- [3] Product Specs & Content -->
            <section id="bo_v_atc">
                <h2 class="sound_only">본문</h2>

                <?php if ($view['wr_1']) { ?>
                    <div class="product-spec-table">
                        <?php echo nl2br($view['wr_1']); ?>
                    </div>
                <?php } ?>

                <div id="bo_v_con"><?php echo get_view_thumbnail($view['content']); ?></div>
            </section>

            <!-- [4] Related Products Gallery (Grid) -->
            <div class="related-products-gallery">
                <h3>RELATED PRODUCTS</h3>
                <div class="gallery-grid">
                    <?php
                    // Query related products (Same Category, Exclude Current)
                    $sql_related = " select * from {$write_table} where ca_name = '{$view['ca_name']}' and wr_id <> '{$view['wr_id']}' and wr_is_comment = 0 order by wr_datetime desc limit 4 ";
                    $result_related = sql_query($sql_related);

                    for ($i = 0; $row = sql_fetch_array($result_related); $i++) {
                        $thumb = get_list_thumbnail($board['bo_table'], $row['wr_id'], 400, 300, false, true);
                        $img_src = $thumb['src'] ? $thumb['src'] : G5_THEME_URL . '/img/no_image.gif';
                        ?>
                        <div class="gallery-item">
                            <a
                                href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>&wr_id=<?php echo $row['wr_id'] ?>">
                                <div class="thumb">
                                    <img src="<?php echo $img_src ?>" alt="<?php echo $row['wr_subject'] ?>">
                                </div>
                                <p class="title"><?php echo $row['wr_subject'] ?></p>
                            </a>
                        </div>
                    <?php }

                    if ($i == 0)
                        echo '<p class="no-related">관련 제품이 없습니다.</p>';
                    ?>
                </div>
            </div>

            <style>
                /* Product Layout Container (Shared with list) */
                .product-layout-container {
                    display: flex;
                    width: 100%;
                    max-width: 1400px;
                    margin: 0 auto;
                    padding-top: 20px;
                    gap: 50px;
                }

                .product-content-area {
                    flex: 1;
                    min-width: 0;
                }

                /* View Skin Theme Customization (Dark/Gold) */
                .product-view-image {
                    margin-bottom: 30px;
                    text-align: center;
                    background: var(--color-bg-panel);
                    padding: 40px;
                    border: 1px solid var(--color-metal-dark);
                }

                .product-view-image img {
                    max-width: 100%;
                    height: auto;
                    border: 1px solid var(--color-metal-dark);
                    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
                }

                .product-title-bar {
                    background-color: var(--color-bg-panel);
                    border-left: 5px solid var(--color-accent-gold);
                    color: var(--color-text-primary);
                    padding: 20px;
                    margin-bottom: 20px;
                }

                .product-title-bar h3 {
                    margin: 0;
                    font-size: 1.5rem;
                    font-weight: 700;
                    letter-spacing: 1px;
                    color: var(--color-accent-gold) !important;
                    text-transform: uppercase;
                }

                .product-spec-table {
                    background: var(--color-bg-panel);
                    padding: 20px;
                    border: 1px solid var(--color-metal-dark);
                    margin-bottom: 30px;
                    font-size: 0.95rem;
                    line-height: 1.6;
                    color: var(--color-text-primary);
                }

                /* Related Gallery */
                .related-products-gallery {
                    margin-top: 60px;
                    border-top: 2px solid var(--color-accent-gold);
                    padding-top: 40px;
                }

                .related-products-gallery h3 {
                    font-size: 1.2rem;
                    font-weight: 700;
                    margin-bottom: 20px;
                    text-transform: uppercase;
                    color: var(--color-accent-gold);
                }

                .gallery-grid {
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    gap: 20px;
                }

                .gallery-item {
                    text-align: center;
                }

                .gallery-item .thumb {
                    width: 100%;
                    height: 180px;
                    overflow: hidden;
                    border: 1px solid var(--color-metal-dark);
                    margin-bottom: 10px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    background: var(--color-bg-dark);
                }

                .gallery-item .thumb img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    transition: transform 0.3s;
                }

                .gallery-item:hover .thumb img {
                    transform: scale(1.05);
                }

                .gallery-item .title {
                    font-size: 0.9rem;
                    color: var(--color-text-secondary);
                    font-weight: 500;
                }

                @media (max-width: 768px) {
                    .product-layout-container {
                        flex-direction: column;
                        gap: 30px;
                    }

                    .gallery-grid {
                        grid-template-columns: repeat(2, 1fr);
                    }
                }
            </style>
        </article>
    </main>
</div>

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

    $(function () {
        $("a.view_image").click(function () {
            window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
            return false;
        });

        // 이미지 리사이즈
        $("#bo_v_atc").viewimageresize();
    });
</script>