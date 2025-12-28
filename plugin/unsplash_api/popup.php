<?php
include_once('./_common.php');

if (!defined('G5_IS_ADMIN'))
    define('G5_IS_ADMIN', true);

include_once(G5_PATH . '/head.sub.php');
?>
<link rel="stylesheet" href="<?php echo G5_ADMIN_URL; ?>/css/admin.css">
<!-- Cropper.js CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<style>
    /* Editor styles */
    #image_editor_wrap {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #fff;
        z-index: 100;
        flex-direction: column;
    }

    .editor-header {
        padding: 15px;
        border-bottom: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #f9f9f9;
    }

    .editor-body {
        flex: 1;
        overflow: hidden;
        background: #333;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .editor-footer {
        padding: 15px;
        border-top: 1px solid #ddd;
        text-align: right;
        background: #fff;
    }

    #image_to_crop {
        max-width: 100%;
        max-height: 80vh;
        display: block;
    }
</style>

<!-- Search View -->
<div id="unsplash_search_wrap" style="padding:20px; background:#fff;">
    <div class="local_desc01 local_desc">
        <p>Unsplash에서 고해상도 무료 이미지를 검색하여 바로 적용할 수 있습니다.</p>
    </div>

    <!-- Search Form -->
    <div style="margin-bottom:20px; text-align:center;">
        <form id="funsplash" onsubmit="return searchUnsplash();">
            <input type="text" id="keyword" class="frm_input" size="50" placeholder="검색어를 입력하세요 (예: nature, business)"
                autofocus>
            <button type="submit" class="btn btn_submit">검색</button>
        </form>
    </div>

    <!-- Results Grid -->
    <div id="unsplash_results"
        style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:15px;">
        <!-- Images will be loaded here via AJAX -->
        <div style="grid-column:1/-1; text-align:center; padding:50px; color:#888;">
            검색어를 입력해 주세요.
        </div>
    </div>

    <!-- Load More -->
    <div id="btn_more" style="text-align:center; margin-top:20px; display:none;">
        <button type="button" class="btn btn_02" onclick="loadMore()">더 보기</button>
    </div>
</div>

<!-- Editor View (Hidden) -->
<div id="image_editor_wrap">
    <div class="editor-header">
        <h2 style="font-size:16px; font-weight:bold; margin:0;">이미지 편집 (자르기)</h2>
        <button type="button" class="btn btn_02" onclick="closeEditor()">취소</button>
    </div>
    <div class="editor-body">
        <div>
            <img id="image_to_crop" src="">
        </div>
    </div>
    <div class="editor-footer">
        <span style="float:left; font-size:12px; color:#666; line-height:30px;">
            * 드래그하여 영역을 선택하세요.
        </span>
        <button type="button" class="btn btn_submit" onclick="applyCrop()" style="padding:5px 20px; font-size:14px;">선택
            영역 적용</button>
    </div>
</div>

<script>
    var currentPage = 1;
    var currentKeyword = '';
    var cropper = null;
    var originalRawUrl = '';
    var displayImageUrl = '';
    var originalImageW = 0;
    var originalImageH = 0;
    var globalTargetW = 0;
    var globalTargetH = 0;

    function searchUnsplash() {
        var keyword = $.trim($("#keyword").val());
        if (!keyword) {
            alert("검색어를 입력해 주세요.");
            return false;
        }

        currentKeyword = keyword;
        currentPage = 1;
        $("#unsplash_results").html('<div style="grid-column:1/-1; text-align:center; padding:50px;"><i class="fa fa-spinner fa-spin fa-2x"></i> 검색 중...</div>');
        $("#btn_more").hide();

        $.post("./ajax.search.php", { keyword: keyword, page: currentPage }, function (data) {
            $("#unsplash_results").html(data);
            if ($(".unsplash-item").length > 0) {
                $("#btn_more").show();
            }
        }).fail(function () {
            $("#unsplash_results").html('<div style="grid-column:1/-1; text-align:center; padding:50px; color:red;">검색 중 오류가 발생했습니다.</div>');
        });

        return false;
    }

    function loadMore() {
        currentPage++;
        $.post("./ajax.search.php", { keyword: currentKeyword, page: currentPage }, function (data) {
            $("#unsplash_results").append(data);
        });
    }

    // Helper to get URL params
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    // Phase 1: Image Selection -> Open Editor
    function selectImage(displayUrl, rawUrl, width, height) {
        displayImageUrl = displayUrl;
        originalRawUrl = rawUrl;
        originalImageW = width;
        originalImageH = height;

        $("#image_editor_wrap").css("display", "flex"); // Show Editor

        // Set image source
        var img = document.getElementById('image_to_crop');
        img.src = displayUrl;

        // Determine Aspect Ratio from URL params
        globalTargetW = parseInt(getUrlParameter('w')) || 0;
        globalTargetH = parseInt(getUrlParameter('h')) || 0;
        var aspectRatio = NaN;

        var guideText = "* 드래그하여 영역을 선택하세요.";
        if (globalTargetW && globalTargetH) {
            aspectRatio = globalTargetW / globalTargetH;
            guideText = "* 이미지 비율이 " + globalTargetW + "x" + globalTargetH + " (" + (globalTargetW / globalTargetH).toFixed(2) + ":1) 로 고정됩니다.";
        }
        $(".editor-footer span").text(guideText);

        // Initialize Cropper
        if (cropper) {
            cropper.destroy();
        }
        // Wait for image load
        img.onload = function () {
            cropper = new Cropper(img, {
                viewMode: 1, // Restrict crop box to canvas
                dragMode: 'move',
                aspectRatio: aspectRatio, // Dynamic Ratio Lock
                autoCropArea: 0.8,
                restore: false,
                guides: true,
                center: true,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
            });
        };
    }

    function closeEditor() {
        $("#image_editor_wrap").hide();
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        $("#image_to_crop").attr("src", "");
    }

    // Phase 2: Apply Crop
    function applyCrop() {
        if (!cropper) return;

        // 1. Get Crop Data (based on displayed image size)
        var data = cropper.getData(true); // true = rounded

        // 2. Calculate Scale Factor (Original vs Displayed)
        var img = document.getElementById('image_to_crop');
        var naturalW = img.naturalWidth;
        var naturalH = img.naturalHeight;

        // If API didn't return W/H, assume 1:1 or rely on display (risky but fallback)
        if (originalImageW == 0) originalImageW = naturalW;
        if (originalImageH == 0) originalImageH = naturalH;

        var scaleX = originalImageW / naturalW;
        var scaleY = originalImageH / naturalH;

        // 3. Scale Coordinates to Original Image
        var finalX = Math.round(data.x * scaleX);
        var finalY = Math.round(data.y * scaleY);
        var finalW = Math.round(data.width * scaleX);
        var finalH = Math.round(data.height * scaleY);

        // 4. Construct URL using Raw URL + Scaled Rect
        var rectParam = '&rect=' + finalX + ',' + finalY + ',' + finalW + ',' + finalH;

        // Use Raw URL (without params) to ensure clean start
        var finalUrl = originalRawUrl + rectParam + '&q=80&fm=jpg&fit=crop';

        // Apply Resize if target dimensions exist
        if (globalTargetW > 0 && globalTargetH > 0) {
            finalUrl += '&w=' + globalTargetW + '&h=' + globalTargetH;
        }

        // Send to parent (or opener)
        var targetWindow = null;
        if (window.opener && !window.opener.closed) {
            targetWindow = window.opener;
        } else if (window.parent && window.parent !== window) {
            targetWindow = window.parent;
        }

        if (targetWindow && targetWindow.receiveUnsplashUrl) {
            targetWindow.receiveUnsplashUrl(finalUrl);
            // Close popup if it is a separate window
            if (window.opener) {
                window.close();
            }
        } else {
            console.error("Target window not found", { opener: window.opener, parent: window.parent });
            alert("부모 창을 연결할 수 없습니다.\n창이 닫혔거나 접근이 차단되었을 수 있습니다.");
        }
    }
</script>

<?php
include_once(G5_PATH . '/tail.sub.php');
?>