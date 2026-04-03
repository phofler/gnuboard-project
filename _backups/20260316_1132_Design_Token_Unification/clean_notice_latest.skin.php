<?php
if (!defined('_GNUBOARD_')) exit;

// Load shared skin header (Standardized Typography)
include_once(dirname(__FILE__) . '/../skin.head.php');

/**
 * [Premium Standardization] 
 * 테마스킨.md 매뉴얼에 따라 전역 변수($txt_title, $more_url, $list) 사용
 */
global $txt_title, $more_url, $list, $skin_cls;

$uniqid = uniqid('clean_');
?>

<section class="sec-clean-notice <?php echo $skin_cls; ?>" id="<?php echo $uniqid; ?>">
    <style>
        .sec-clean-notice {
            padding: 20px 0;
            background: transparent;
        }
        .clean-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 25px;
            border-bottom: 2px solid var(--color-accent-gold, #d4af37);
            padding-bottom: 10px;
        }
        /* Override core section-title for notice style */
        .sec-clean-notice .section-title {
            margin: 0 !important;
            text-align: left !important;
            font-size: 1.5rem !important;
            letter-spacing: 0 !important;
        }
        .clean-more {
            font-size: 0.85rem;
            color: var(--color-text-secondary, #666);
            text-decoration: none;
            font-weight: 600;
            text-transform: uppercase;
            transition: color 0.3s;
        }
        .clean-more:hover {
            color: var(--color-accent-gold, #d4af37);
        }

        .clean-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .clean-item {
            border-bottom: 1px solid #eee;
            transition: background 0.2s;
        }
        .clean-item:last-child {
            border-bottom: none;
        }
        .clean-item a {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 5px;
            text-decoration: none;
            color: var(--color-text-primary, #333);
        }
        .clean-item:hover {
            background: #fafafa;
        }
        .clean-subject {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding-right: 20px;
            font-size: 0.95rem;
        }
        .clean-date {
            font-size: 0.85rem;
            color: #999;
            font-weight: 400;
        }
        .clean-empty {
            padding: 40px 0;
            text-align: center;
            color: #999;
            font-size: 0.9rem;
        }
    </style>

    <div class="clean-header">
        <h2 class="section-title">
            <?php echo $txt_title; ?>
        </h2>
        <?php if ($more_url) { ?>
        <a href="<?php echo $more_url; ?>" class="clean-more">MORE +</a>
        <?php } ?>
    </div>

    <ul class="clean-list">
        <?php for ($i=0; $i<count($list); $i++) { 
            // Date Formatting (e.g., 2026.03.16)
            $datetime = date("Y.m.d", strtotime($list[$i]['wr_datetime']));
        ?>
        <li class="clean-item">
            <a href="<?php echo $list[$i]['href']; ?>">
                <span class="clean-subject"><?php echo $list[$i]['subject']; ?></span>
                <span class="clean-date"><?php echo $datetime; ?></span>
            </a>
        </li>
        <?php } ?>
        <?php if (count($list) == 0) { ?>
            <li class="clean-empty">등록된 새 소식이 없습니다.</li>
        <?php } ?>
    </ul>
</section>