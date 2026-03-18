<?php
if (!defined('_GNUBOARD_'))
    exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH . '/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $board_skin_url . '/style.css?v=' . time() . '">', 0);
add_stylesheet('<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Nanum+Myeongjo:wght@400;700&family=Nanum+Gothic:wght@400;700&display=swap" rel="stylesheet">', 0);
add_stylesheet('<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">', 0);
?>



<div class="skin-container">
    <!-- Category Filter (Type B: Strategic Dropdown) -->
    <?php if ($is_category) {
        $add_query = '';
        if (isset($_GET['me_code'])) {
            $add_query = '&me_code=' . urlencode($_GET['me_code']);
        }
        $category_href = G5_BBS_URL . '/board.php?bo_table=' . $bo_table . $add_query;
        $raw_cats = explode('|', $board['bo_category_list']);
        $structure = array();

        // 1. Build Hierarchy
        foreach ($raw_cats as $cat) {
            $cat = trim($cat);
            $cat = preg_replace('/\s*>\s*/', ' > ', $cat); // Normalize spacing ' > '
            if (!$cat)
                continue;

            $parts = explode(' > ', $cat);
            $root = trim($parts[0]);

            if (!isset($structure[$root])) {
                $structure[$root] = array(
                    'path' => $root,
                    'children' => array()
                );
            }

            if (count($parts) == 2) {
                $sub = trim($parts[1]);
                $structure[$root]['children'][$cat] = $sub;
            }
        }

        // Determine Active Root
        $current_root = '';
        $current_stx = isset($_GET['stx']) ? $_GET['stx'] : '';
        if ($sca) {
            $sca_temp = explode('>', $sca);
            $current_root = trim($sca_temp[0]);
        } else if ($current_stx) {
            $stx_temp = explode('>', $current_stx);
            $current_root = trim($stx_temp[0]);
        }
        ?>
        <div id="bo_cate" class="category-ui-wrap" data-aos="fade-up" data-aos-delay="100">
            <ul class="cate-tabs">
                <!-- 'All' Tab -->
                <li class="cate-item">
                    <a href="<?php echo $category_href ?>#bo_cate"
                        class="cat-btn <?php echo ($sca == '' && $current_stx == '') ? 'active' : ''; ?>">All</a>
                </li>

                <!-- Root Tabs -->
                <?php foreach ($structure as $root_name => $data) {
                    $has_children = !empty($data['children']);
                    $is_active_root = ($current_root == $root_name);
                    ?>
                    <li class="cate-item <?php echo $has_children ? 'has-sub' : ''; ?>">
                        <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=<?php echo $bo_table . $add_query; ?>&amp;sfl=ca_name&amp;stx=<?php echo urlencode($root_name); ?>#bo_cate"
                            class="cat-btn <?php echo ($current_root == $root_name || $current_stx == $root_name) ? 'active' : ''; ?>">
                            <?php echo $root_name; ?>
                        </a>

                        <?php if ($has_children) { ?>
                            <div class="cate-dropdown">
                                <?php foreach ($data['children'] as $full_path => $sub_name) {
                                    $is_active_sub = ($sca == $full_path || $current_stx == $full_path);
                                    ?>
                                    <a href="<?php echo G5_BBS_URL; ?>/board.php?bo_table=<?php echo $bo_table . $add_query; ?>&amp;sfl=ca_name&amp;stx=<?php echo urlencode($full_path); ?>#bo_cate"
                                        class="sub-link <?php echo $is_active_sub ? 'active' : ''; ?>">
                                        <?php echo $sub_name; ?>
                                    </a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <div class="mag-grid">
        <?php
        for ($i = 0; $i < count($list); $i++) {
            // 썸네일 생성
            $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height'], false, true);
            $img_url = ($thumb['src']) ? $thumb['src'] : 'https://via.placeholder.com/800x800?text=No+Image';

            // Extract all attached images for Layer Gallery (Standard)
            $images = [];
            $res = sql_query(" select bf_file from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$list[$i]['wr_id']}' order by bf_no ");
            while ($row = sql_fetch_array($res)) {
                $images[] = G5_DATA_URL . '/file/' . $bo_table . '/' . $row['bf_file'];
            }

            // Fallback to thumbnail/placeholder if no actual files attached
            if (empty($images)) {
                $images[] = $img_url;
            }

            // edit link
            $edit_href = '';
            if ($is_admin == 'super' || $is_auth) {
                $edit_href = G5_BBS_URL . '/write.php?w=u&bo_table=' . $bo_table . '&wr_id=' . $list[$i]['wr_id'];
                if (isset($_GET['me_code']))
                    $edit_href .= '&me_code=' . urlencode($_GET['me_code']);
                $edit_href .= '#bo_w';
            }

            // Detail view link with context
            $view_url = $list[$i]['href'];
            if (isset($_GET['me_code']))
                $view_url .= '&me_code=' . urlencode($_GET['me_code']);
            ?>
            <article class="mag-item" data-aos="fade-up" data-id="<?php echo $list[$i]['wr_id']; ?>"
                data-images='<?php echo json_encode($images); ?>'
                data-subject="<?php echo htmlspecialchars($list[$i]['subject']); ?>"
                data-content="<?php echo htmlspecialchars(cut_str(strip_tags($list[$i]['wr_content']), 300)); ?>"
                data-name="<?php echo htmlspecialchars($list[$i]['name']); ?>"
                data-date="<?php echo $list[$i]['datetime2']; ?>" data-edit="<?php echo $edit_href; ?>"
                data-view="<?php echo $view_url; ?>" onclick="openMagModal(this)">

                <img src="<?php echo $img_url; ?>" class="mag-thumb" alt="<?php echo $list[$i]['subject']; ?>">
                <div class="mag-content">
                    <?php if ($list[$i]['ca_name']) { ?>
                        <span class="mag-cat"><?php echo $list[$i]['ca_name']; ?></span>
                    <?php } ?>

                    <h3 class="mag-title">
                        <?php if ($edit_href) { ?>
                            <a href="<?php echo $edit_href; ?>" class="btn-edit-list" title="Edit"
                                onclick="event.stopPropagation()">✎</a>
                        <?php } ?>
                        <?php echo $list[$i]['subject']; ?>
                    </h3>

                    <p class="mag-desc"><?php echo cut_str(strip_tags($list[$i]['wr_content']), 100); ?></p>

                    <div class="mag-meta">
                        <span><?php echo $list[$i]['name']; ?></span>
                        <span><?php echo $list[$i]['datetime2']; ?></span>
                    </div>
                </div>
            </article>
        <?php } ?>

        <?php if (count($list) == 0) {
            echo '<p class="text-center" style="color:var(--mag-muted); padding:50px;">게시물이 없습니다.</p>';
        } ?>
    </div>

    <!-- Pagination (Context Standard (4)) -->
    <div style="margin-top:40px; text-align:center;">
        <?php
        if (isset($_GET['me_code'])) {
            $write_pages = preg_replace('/href="([^"]+)"/', 'href="$1&me_code=' . urlencode($_GET['me_code']) . '"', $write_pages);
        }
        echo $write_pages;
        ?>
    </div>
</div>

<?php if ($write_href) {
    $write_url = $write_href;
    if (isset($_GET['me_code']))
        $write_url .= '&me_code=' . urlencode($_GET['me_code']);
    $write_url .= '#bo_w';
    ?>
    <a href="<?php echo $write_url; ?>" class="btn-write" title="Write Post">+</a>
<?php } ?>

<!-- MODAL POPUP (Standard (2)) -->
<div id="magModal" class="modal-overlay">
    <button class="modal-nav prev" onclick="changeMagPost('prev')">‹</button>
    <button class="modal-nav next" onclick="changeMagPost('next')">›</button>

    <div class="modal-content">
        <button class="modal-close" onclick="closeMagModal()">×</button>

        <div class="modal-body">
            <div class="modal-gallery">
                <div class="gallery-main">
                    <img id="modalMainImg" src="" alt="Main Image">
                </div>
                <div class="gallery-thumbs" id="modalThumbs"></div>
            </div>

            <div class="modal-info">
                <span class="modal-cat" id="modalCat">Category</span>
                <div style="display:flex; align-items:flex-start; gap:10px; margin-bottom:20px;">
                    <a href="" class="btn-edit" id="modalEditBtn" title="Edit Post">✎</a>
                    <h2 class="modal-title" id="modalTitle" style="margin-bottom:0;">Title</h2>
                </div>
                <div class="modal-meta" id="modalMeta">
                    <span id="modalAuthor"></span>
                    <span id="modalDate"></span>
                </div>
                <div class="modal-desc" id="modalDesc"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();

    let currentMagIndex = 0;
    const magItems = document.querySelectorAll('.mag-item');

    function openMagModal(el) {
        magItems.forEach((item, index) => {
            if (item === el) currentMagIndex = index;
        });
        updateMagModalContent(el);
        document.getElementById('magModal').classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function changeMagPost(direction) {
        if (direction === 'prev') {
            currentMagIndex = (currentMagIndex > 0) ? currentMagIndex - 1 : magItems.length - 1;
        } else {
            currentMagIndex = (currentMagIndex < magItems.length - 1) ? currentMagIndex + 1 : 0;
        }
        updateMagModalContent(magItems[currentMagIndex]);
    }

    function updateMagModalContent(el) {
        const data = el.dataset;
        const images = JSON.parse(data.images);

        document.getElementById('modalMainImg').src = images[0];
        document.getElementById('modalTitle').innerText = data.subject;
        document.getElementById('modalCat').innerText = el.querySelector('.mag-cat') ? el.querySelector('.mag-cat').innerText : '';
        document.getElementById('modalAuthor').innerHTML = 'By ' + data.name;
        document.getElementById('modalDate').innerText = data.date;
        document.getElementById('modalDesc').innerText = data.content;

        const editBtn = document.getElementById('modalEditBtn');
        if (data.edit) {
            editBtn.href = data.edit;
            editBtn.style.display = 'inline-block';
        } else {
            editBtn.style.display = 'none';
        }


        const thumbsContainer = document.getElementById('modalThumbs');
        thumbsContainer.innerHTML = '';
        if (images.length > 1) {
            thumbsContainer.style.display = 'flex';
        } else {
            thumbsContainer.style.display = 'none';
        }
        images.forEach((img, i) => {
            const thumb = document.createElement('img');
            thumb.src = img;
            thumb.className = i === 0 ? 'thumb-item active' : 'thumb-item';
            thumb.onclick = function () {
                document.getElementById('modalMainImg').src = this.src;
                document.querySelectorAll('.thumb-item').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            };
            thumbsContainer.appendChild(thumb);
        });
    }

    function closeMagModal() {
        document.getElementById('magModal').classList.remove('open');
        document.body.style.overflow = '';
    }

    document.getElementById('magModal').addEventListener('click', function (e) {
        if (e.target === this) closeMagModal();
    });

    document.addEventListener('keydown', function (e) {
        if (!document.getElementById('magModal').classList.contains('open')) return;
        if (e.key === 'ArrowLeft') changeMagPost('prev');
        if (e.key === 'ArrowRight') changeMagPost('next');
        if (e.key === 'Escape') closeMagModal();
    });
</script>