<?php
include_once('./_common.php');

$target_w = isset($_GET['w']) ? (int) $_GET['w'] : 0;
$target_h = isset($_GET['h']) ? (int) $_GET['h'] : 0;
?>
<!doctype html>
<html lang="ko">

<head>
    <meta charset="utf-8">
    <title>이미지 매니저</title>
    <link rel="stylesheet" href="<?php echo G5_ADMIN_URL ?>/css/admin.css">
    <!-- CropperJS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Noto Sans KR', sans-serif;
            background: #f5f5f5;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Tabs */
        .tab-header {
            display: flex;
            background: #fff;
            border-bottom: 1px solid #ddd;
            padding: 0 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            flex-shrink: 0;
        }

        .tab-btn {
            padding: 15px 20px;
            font-size: 15px;
            font-weight: 500;
            color: #666;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.2s;
        }

        .tab-btn:hover {
            color: #333;
            background: #f9f9f9;
        }

        .tab-btn.active {
            color: #d4af37;
            border-bottom-color: #d4af37;
            font-weight: 700;
        }

        /* Content Area */
        .content-wrapper {
            flex: 1;
            position: relative;
            overflow: hidden;
        }

        .tab-content {
            width: 100%;
            height: 100%;
            overflow-y: auto;
            padding: 20px;
            box-sizing: border-box;
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Tab 1: Upload */
        .upload-zone {
            border: 2px dashed #ccc;
            border-radius: 8px;
            background: #fff;
            text-align: center;
            padding: 50px 20px;
            transition: all 0.2s;
            cursor: pointer;
            height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .upload-zone:hover,
        .upload-zone.dragover {
            border-color: #d4af37;
            background: #fffdf5;
        }

        .upload-msg {
            font-size: 16px;
            color: #888;
            margin-bottom: 15px;
        }

        .upload-btn {
            display: inline-block;
            padding: 10px 25px;
            background: #333;
            color: #fff;
            border-radius: 4px;
            font-size: 14px;
        }

        /* Tab 2: Library */
        .lib-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
        }

        .lib-item {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 4px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
        }

        .lib-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-color: #d4af37;
        }

        .lib-thumb {
            width: 100%;
            height: 120px;
            object-fit: cover;
            background: #fafafa;
            display: block;
        }

        .lib-info {
            padding: 8px;
            font-size: 12px;
            color: #666;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Tab 3: Unsplash */
        .unsplash-frame {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
        }

        /* Crop Interface */
        #crop_interface {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #333;
            z-index: 100;
            flex-direction: column;
        }

        .crop-header {
            padding: 15px 20px;
            background: #222;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .crop-body {
            flex: 1;
            position: relative;
            overflow: hidden;
            background: #000;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #crop_image {
            max-width: 100%;
            max-height: 100%;
            display: block;
        }

        .crop-footer {
            padding: 15px 20px;
            background: #222;
            text-align: right;
        }

        /* Footer Info */
        .mgr-footer {
            padding: 10px 20px;
            background: #fff;
            border-top: 1px solid #ddd;
            font-size: 13px;
            color: #666;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .target-info b {
            color: #d4af37;
            margin-left: 5px;
        }

        /* Loading Overlay */
        #loading_mask {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 999;
            display: none;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            color: #d4af37;
            flex-direction: column;
        }
    </style>
    <script src="<?php echo G5_JS_URL ?>/jquery-1.12.4.min.js"></script>
</head>

<body>

    <div class="tab-header" id="main_tabs">
        <div class="tab-btn active" onclick="switchTab('upload')">내 컴퓨터 업로드</div>
        <div class="tab-btn" onclick="switchTab('library')">라이브러리</div>
        <div class="tab-btn" onclick="switchTab('unsplash')">스톡 이미지 (Unsplash)</div>
    </div>

    <div class="content-wrapper">
        <!-- Tab 1: Upload -->
        <div id="tab_upload" class="tab-content active">
            <div class="upload-zone" id="drop_zone">
                <div class="upload-msg">이미지를 이곳에 드래그하거나 클릭하여 업로드하세요.</div>
                <span class="upload-btn">파일 선택</span>
                <input type="file" id="file_input" accept="image/*" style="display:none;">
            </div>
            <div style="margin-top:20px; text-align:center; color:#888; font-size:13px;">
                권장 확장자: JPG, PNG, WEBP (최대 10MB)
            </div>
        </div>

        <!-- Tab 2: Library -->
        <div id="tab_library" class="tab-content">
            <div class="lib-grid" id="lib_list">
                <!-- JS Loaded -->
            </div>
        </div>

        <!-- Tab 3: Unsplash -->
        <div id="tab_unsplash" class="tab-content" style="padding:0;">
            <iframe src="" id="unsplash_iframe" class="unsplash-frame"></iframe>
        </div>

        <!-- Crop Interface -->
        <div id="crop_interface">
            <div class="crop-header">
                이미지 편집 (자르기)
                <button type="button" class="btn btn_02" onclick="cancelCrop()"
                    style="padding: 5px 10px; font-size: 12px;">취소</button>
            </div>
            <div class="crop-body">
                <div style="height: 100%; width: 100%;">
                    <img id="crop_image" src="">
                </div>
            </div>
            <div class="crop-footer">
                <span style="color:#aaa; font-size:12px; margin-right:15px; float:left; line-height:30px;">* 이미지 비율이 <?php echo $target_w > 0 ? $target_w . "x" . $target_h : "자유"; ?> 로 고정됩니다.
            </span>
            <button type="button" class="btn btn_submit" onclick="applyCrop()">선택 영역 적용</button>
        </div>
    </div>
    
    <div id="loading_mask">
        <div style="margin-bottom:10px;">처리 중...</div>
    </div>
</div>

<div class="mgr-footer">
    <div class="target-info">
        현재 선택 영역 크기: 
        <?php if ($target_w > 0) { ?>
                <b><?php echo $target_w; ?> x <?php echo $target_h; ?> (비율 고정)</b>
        <?php } else { ?>
                <b>자유 (비율 없음)</b>
        <?php } ?>
    </div>
    <div>
        <button type="button" class="btn btn_02" onclick="parent.closeUnsplashModal();">닫기</button>
    </div>
</div>

<script>
    var unsplashLoaded = false;
    var targetW = <?php echo $target_w; ?>;
    var targetH = <?php echo $target_h; ?>;
    var cropper = null;

    function switchTab(tabName) {
        $('.tab-btn').removeClass('active');
        $('.tab-content').removeClass('active');
        
        if(tabName == 'upload') $('.tab-btn:eq(0)').addClass('active');
        if(tabName == 'library') {
            $('.tab-btn:eq(1)').addClass('active');
            loadLibrary();
        }
        if(tabName == 'unsplash') {
            $('.tab-btn:eq(2)').addClass('active');
            if(!unsplashLoaded) {
                var url = '../../unsplash_api/popup.php?w=' + targetW + '&h=' + targetH;
                $('#unsplash_iframe').attr('src', url);
                unsplashLoaded = true;
            }
        }
        
        $('#tab_' + tabName).addClass('active');
    }

    // --- Upload Logic ---
    var dropZone = document.getElementById('drop_zone');
    var fileInput = document.getElementById('file_input');

    dropZone.addEventListener('click', function() { fileInput.click(); });
    
    dropZone.addEventListener('dragover', function(e) { e.preventDefault(); $(this).addClass('dragover'); });
    dropZone.addEventListener('dragleave', function(e) { e.preventDefault(); $(this).removeClass('dragover'); });
    
    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
        var files = e.dataTransfer.files;
        if(files.length > 0) handleUpload(files[0]);
    });

    fileInput.addEventListener('change', function() {
        if(this.files.length > 0) handleUpload(this.files[0]);
    });

    function handleUpload(file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            initWrappedCrop(e.target.result);
        };
        reader.readAsDataURL(file);
    }

    // --- Library Logic ---
    function loadLibrary() {
        $.ajax({
            url: './ajax.list_images.php',
            dataType: 'json',
            success: function(data) {
                var html = '';
                if(data.images && data.images.length > 0) {
                    $.each(data.images, function(i, img) {
                        html += '<div class="lib-item" onclick="initWrappedCrop(\'' + img.url + '\')">';
                        html += '<img src="' + img.url + '" class="lib-thumb">';
                        html += '<div class="lib-info">' + img.name + '</div>';
                        html += '</div>';
                    });
                } else {
                    html = '<div style="grid-column: 1/-1; text-align:center; padding:50px; color:#999;">업로드된 이미지가 없습니다.</div>';
                }
                $('#lib_list').html(html);
            }
        });
    }

    // --- Cropper Logic ---
    function initWrappedCrop(imageUrl) {
        $('#crop_interface').css('display', 'flex');
        var image = document.getElementById('crop_image');
        image.src = imageUrl;

        if(cropper) {
            cropper.destroy();
        }

        var aspectRatio = NaN;
        if(targetW > 0 && targetH > 0) {
            aspectRatio = targetW / targetH;
        }

        cropper = new Cropper(image, {
            aspectRatio: aspectRatio,
            viewMode: 2, // Restrict crop box to not exceed canvas
            autoCropArea: 0.9,
            zoomable: true,
            background: false
        });
    }

    function cancelCrop() {
        if(cropper) {
            cropper.destroy();
            cropper = null;
        }
        $('#crop_interface').hide();
        $('#crop_image').attr('src', '');
    }

    function applyCrop() {
        if(!cropper) return;

        $('#loading_mask').css('display', 'flex');

        var canvas = cropper.getCroppedCanvas({
            width: targetW > 0 ? targetW : undefined, 
        });

        // Convert to blob and upload
        canvas.toBlob(function(blob) {
            var formData = new FormData();
            formData.append('file', blob, 'cropped_image.jpg');

            $.ajax({
                url: './ajax.upload.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    $('#loading_mask').hide();
                    if(response.url) {
                        selectImage(response.url);
                    } else {
                        alert(response.error || '저장 실패');
                    }
                },
                error: function() {
                    $('#loading_mask').hide();
                    alert('서버 저장 오류');
                }
            });
        }, 'image/jpeg', 0.9);
    }

    // --- Final Selection ---
    function selectImage(url) {
        // Parent callback
        if(parent.receiveImageUrl) {
            parent.receiveImageUrl(url);
        } else if(parent.receiveUnsplashUrl) {
           parent.receiveUnsplashUrl(url); 
        } else {
            console.error("Parent callback not found");
        }
    }
    
    window.receiveUnsplashUrl = function(url) {
        selectImage(url);
    };

</script>
</body>
</html>