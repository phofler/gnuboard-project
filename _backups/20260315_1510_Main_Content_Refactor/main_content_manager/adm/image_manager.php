<?php
include_once('./_common.php');

$target_w = isset($_GET['w']) ? (int) $_GET['w'] : 0;
$target_h = isset($_GET['h']) ? (int) $_GET['h'] : 0;
$mi_id = isset($_GET['mi_id']) ? $_GET['mi_id'] : '';
?>
<!doctype html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <title>이미지 매니저</title>
    <link rel="stylesheet" href="<?php echo G5_ADMIN_URL ?>/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <style>
        body { margin: 0; padding: 0; font-family: 'Noto Sans KR', sans-serif; background: #f5f5f5; height: 100vh; display: flex; flex-direction: column; overflow: hidden; }
        .tab-header { display: flex; background: #fff; border-bottom: 1px solid #ddd; padding: 0 20px; flex-shrink: 0; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); }
        .tab-btn { padding: 15px 20px; font-size: 14px; font-weight: 500; color: #666; cursor: pointer; border-bottom: 3px solid transparent; transition: all 0.2s; }
        .tab-btn:hover { color: #333; background: #f9f9f9; }
        .tab-btn.active { color: #d4af37; border-bottom-color: #d4af37; font-weight: 700; }
        .content-wrapper { flex: 1; position: relative; overflow: hidden; }
        .tab-content { width: 100%; height: 100%; overflow-y: auto; padding: 20px; box-sizing: border-box; display: none; }
        .tab-content.active { display: block; }
        .upload-zone { border: 2px dashed #ccc; border-radius: 8px; background: #fff; text-align: center; padding: 50px 20px; transition: all 0.2s; cursor: pointer; height: 300px; display: flex; flex-direction: column; justify-content: center; align-items: center; margin-top: 20px; }
        .upload-zone:hover, .upload-zone.dragover { border-color: #d4af37; background: #fffdf5; }
        .upload-msg { font-size: 15px; color: #888; margin-bottom: 15px; }
        .upload-btn { display: inline-block; padding: 8px 20px; background: #333; color: #fff; border-radius: 4px; font-size: 13px; }
        .lib-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 15px; }
        .lib-item { background: #fff; border: 1px solid #eee; border-radius: 4px; overflow: hidden; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; position: relative; }
        .lib-item:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); border-color: #d4af37; }
        .lib-thumb { width: 100%; height: 110px; object-fit: cover; background: #fafafa; display: block; }
        .lib-info { padding: 6px; font-size: 11px; color: #666; text-align: center; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        #crop_interface { display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: #222; z-index: 100; flex-direction: column; }
        .crop-header { padding: 12px 20px; background: #111; color: #fff; font-size: 15px; font-weight: bold; display: flex; justify-content: space-between; align-items: center; }
        .crop-body { flex: 1; position: relative; overflow: hidden; display: flex; justify-content: center; align-items: center; }
        #crop_image { max-width: 100%; max-height: 100%; display: block; }
        .crop-footer { padding: 12px 20px; background: #111; text-align: right; display: flex; justify-content: space-between; align-items: center; }
        .mgr-footer { padding: 10px 20px; background: #fff; border-top: 1px solid #ddd; font-size: 12px; color: #666; display: flex; justify-content: space-between; align-items: center; flex-shrink: 0; }
        .target-info b { color: #d4af37; margin-left: 3px; }
        #loading_mask { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.9); z-index: 999; display: none; justify-content: center; align-items: center; font-weight: bold; color: #d4af37; flex-direction: column; }
    </style>
    <script src="<?php echo G5_JS_URL ?>/jquery-1.12.4.min.js"></script>
</head>
<body>
    <div class="tab-header">
        <div class="tab-btn active" onclick="switchTab('upload')">내 컴퓨터 업로드</div>
        <div class="tab-btn" onclick="switchTab('library')">라이브러리</div>
        <div class="tab-btn" onclick="switchTab('unsplash')">스톡 이미지 (Unsplash)</div>
    </div>
    <div class="content-wrapper">
        <div id="tab_upload" class="tab-content active">
            <div class="upload-zone" id="drop_zone">
                <div class="upload-msg">이미지를 이곳에 드래그하거나 클릭하여 업로드하세요.</div>
                <span class="upload-btn">파일 선택</span>
                <input type="file" id="file_input" accept="image/*" style="display:none;">
            </div>
            <div style="margin-top:15px; text-align:center; color:#999; font-size:12px;">권장 확장자: JPG, PNG, WEBP (최대 10MB)</div>
        </div>
        <div id="tab_library" class="tab-content"><div class="lib-grid" id="lib_list"></div></div>
        <div id="tab_unsplash" class="tab-content" style="padding:0;"><iframe src="" id="unsplash_iframe" style="width:100%; height:100%; border:none;"></iframe></div>
        <div id="crop_interface">
            <div class="crop-header">이미지 편집 (자르기) <button type="button" class="btn btn_02" onclick="cancelCrop()" style="padding: 4px 8px; font-size: 11px;">취소</button></div>
            <div class="crop-body"><img id="crop_image" src=""></div>
            <div class="crop-footer">
                <span style="color:#888; font-size:11px;">* 비율: <?php echo $target_w > 0 ? $target_w . "x" . $target_h : "자유"; ?> 고정</span>
                <button type="button" class="btn btn_submit" onclick="applyCrop()">선택 영역 적용</button>
            </div>
        </div>
        <div id="loading_mask">처리 중...</div>
    </div>
    <div class="mgr-footer">
        <div class="target-info">
            <div id="storage_info" style="font-size: 10px; color: #999; margin-bottom: 2px;">라이브러리 사용량: 계산 중...</div>
            현재 선택 영역 크기: <?php if($target_w > 0) { ?><b><?php echo $target_w ?> x <?php echo $target_h ?></b><?php } else { ?><b>자유</b><?php } ?>
        </div>
        <button type="button" class="btn btn_02" onclick="parent.closeUnsplashModal();">닫기</button>
    </div>
    <script>
        var targetW = <?php echo $target_w ?>;
        var targetH = <?php echo $target_h ?>;
        var mi_id = '<?php echo $mi_id ?>';
        var cropper = null;
        var unsplashLoaded = false;
        $(document).ready(function(){ loadLib(); });
        function switchTab(tab) {
            $('.tab-btn').removeClass('active');
            $('.tab-content').removeClass('active');
            if(tab == 'upload') $('.tab-btn:eq(0)').addClass('active');
            if(tab == 'library') { $('.tab-btn:eq(1)').addClass('active'); loadLib(); }
            if(tab == 'unsplash') {
                $('.tab-btn:eq(2)').addClass('active');
                if(!unsplashLoaded) { $('#unsplash_iframe').attr('src', '../../unsplash_api/popup.php?w='+targetW+'&h='+targetH+'&mi_id='+mi_id); unsplashLoaded = true; }
            }
            $('#tab_'+tab).addClass('active');
        }
        var dropZone = document.getElementById('drop_zone'), fileInput = document.getElementById('file_input');
        dropZone.onclick = function(){ fileInput.click(); };
        dropZone.ondragover = function(e){ e.preventDefault(); this.classList.add('dragover'); };
        dropZone.ondragleave = function(e){ e.preventDefault(); this.classList.remove('dragover'); };
        dropZone.ondrop = function(e){ e.preventDefault(); this.classList.remove('dragover'); if(e.dataTransfer.files.length > 0) handleFile(e.dataTransfer.files[0]); };
        fileInput.onchange = function(){ if(this.files.length > 0) handleFile(this.files[0]); };
        function handleFile(file) { var reader = new FileReader(); reader.onload = function(e){ initCrop(e.target.result); }; reader.readAsDataURL(file); }
        function loadLib() {
            $.getJSON('./ajax.list_images.php', function(data){
                if(data.total_size) $('#storage_info').text('라이브러리 사용량: ' + data.total_size);
                var h = '';
                if(data.images && data.images.length > 0) {
                    $.each(data.images, function(i, img){ h += '<div class="lib-item" onclick="initCrop(\''+img.url+'\')"><img src="'+img.url+'" class="lib-thumb"><div class="lib-info">'+img.name+'</div></div>'; });
                } else { h = '<div style="grid-column:1/-1; text-align:center; padding:50px; color:#999;">이미지가 없습니다.</div>'; }
                $('#lib_list').html(h);
            });
        }
        function initCrop(url) {
            $('#crop_interface').css('display', 'flex');
            var img = document.getElementById('crop_image');
            img.src = url;
            if(cropper) cropper.destroy();
            cropper = new Cropper(img, { aspectRatio: targetW > 0 ? targetW/targetH : NaN, viewMode: 2, autoCropArea: 0.9 });
        }
        function cancelCrop() { if(cropper) { cropper.destroy(); cropper = null; } $('#crop_interface').hide(); }
        function applyCrop() {
            if(!cropper) return;
            $('#loading_mask').css('display', 'flex');
            cropper.getCroppedCanvas({ width: targetW > 0 ? targetW : undefined }).toBlob(function(blob){
                var f = new FormData();
                f.append('file', blob, 'crop.jpg');
                $.ajax({ url: './ajax.upload.php', type: 'POST', data: f, contentType: false, processData: false, dataType: 'json',
                    success: function(r){ $('#loading_mask').hide(); if(r.url) selectImage(r.url); else alert(r.error || '저장 실패'); },
                    error: function(){ $('#loading_mask').hide(); alert('서버 오류'); }
                });
            }, 'image/jpeg', 0.9);
        }
        function selectImage(url) {
            var p = window.opener || window.parent;
            if(p && p.receiveImageUrl) {
                p.receiveImageUrl(url, mi_id);
                if(window.opener) window.close();
                else if(p.closeUnsplashModal) p.closeUnsplashModal();
            }
        }
        window.receiveUnsplashUrl = function(url){ selectImage(url); };
    </script>
</body>
</html>