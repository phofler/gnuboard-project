/**
 * Smart Image Manager Library (Standardization)
 * 쟉성일: 2026-03-17
 * 역할: 전역 이미지 비율 감직 및 Unsplash 팝업 동기화 관리
 */

var SmartImageManager = {
    targetId: null,      // 에디터 ID 또는 셀렉터
    mi_id: null,         // 항목 고유 ID (AJAX 대응용)
    targetIndex: -1,     // 에디터 내 이미지 인덱스 (-1: 신규 삽입, 0+: 교체)
    callback: null,      // 이미지 선택 후 실행될 콜백

    /**
     * Unsplash 팝업 열기
     * @param {Object} options { id, index, callback, fallbackW, fallbackH, mi_id, forceW, forceH }
     */
    open: function(options) {
        this.targetId = options.id || 'co_content';
        this.mi_id = options.mi_id || null; 
        this.targetIndex = (options.index !== undefined) ? options.index : -1;
        this.callback = options.callback || null;

        var w, h;
        // [UPDATED] Prioritize forced dimensions for high quality
        if (options.forceW && options.forceH) {
            w = options.forceW;
            h = options.forceH;
            console.log("[SmartImage] Using Forced Quality: " + w + "x" + h);
        } else {
            var ratio = this.detectRatio(this.targetId, this.targetIndex);
            w = ratio.w || options.fallbackW || 0;
            h = ratio.h || options.fallbackH || 0;
        }

        this.openPopup(w, h);
    },

    /**
     * 타겟 엘리먼트/에디터로부터 이미지 비율 추출
     */
    detectRatio: function(id, index) {
        var w = 0, h = 0;

        // 1. SmartEditor2 에디터 환경인 경우
        if (typeof oEditors !== 'undefined' && oEditors.getById[id]) {
            var doc = oEditors.getById[id].getWYSIWYGDocument();
            var imgs = doc.body.querySelectorAll("img");
            
            if (index >= 0 && imgs[index]) {
                var img = imgs[index];
                w = parseInt(img.getAttribute("width")) || parseInt(img.style.width) || img.naturalWidth || 0;
                h = parseInt(img.getAttribute("height")) || parseInt(img.style.height) || img.naturalHeight || 0;
            } else if (imgs.length === 1) {
                // 단일 이미지 자동 감지
                this.targetIndex = 0;
                w = parseInt(imgs[0].getAttribute("width")) || parseInt(imgs[0].style.width) || imgs[0].naturalWidth || 0;
                h = parseInt(imgs[0].getAttribute("height")) || parseInt(imgs[0].style.height) || imgs[0].naturalHeight || 0;
            }
        } 
        // 2. 일반 DOM 엘리먼트 (미리보기 박스 등)
        else {
            var el = document.getElementById(id);
            if (el) {
                w = $(el).width() || 0;
                h = $(el).height() || 0;
            }
        }

        console.log("[SmartImage] Detected Ratio: " + w + "x" + h + " for ID: " + id);
        return { w: w, h: h };
    },

    /**
     * 실제 팝업 호출
     */
    openPopup: function(w, h) {
        var url = './image_manager.php?v=' + Date.now();
        if (w > 0 && h > 0) {
            url += '&w=' + w + '&h=' + h;
        }
        
        if (this.mi_id) {
            url += '&mi_id=' + encodeURIComponent(this.mi_id);
        }
        
        // 부모 페이지에 정의된 iframe/modal 활용
        var iframe = document.getElementById('unsplash_iframe');
        var modal = document.getElementById('unsplash_modal');

        if (iframe && modal) {
            iframe.src = url;
            $(modal).css('display', 'flex').fadeIn(200);
        } else {
            // Fallback: 윈도우 팝업
            var winW = 1000, winH = 800;
            var winL = (screen.width - winW) / 2;
            var winT = (screen.height - winH) / 2;
            window.open(url, 'SmartImagePopup', 'width=' + winW + ',height=' + winH + ',left=' + winL + ',top=' + winT + ',scrollbars=yes');
        }
    },

    /**
     * 이미지 선택 완료 시 데이터 수신
     */
    receive: function(url) {
        // [1] 사용자 정의 콜백 실행
        if (this.callback && typeof this.callback === 'function') {
            this.callback(url, this.targetId, this.targetIndex, this.mi_id);
            return;
        }

        // [2] 기본 에디터 삽입 로직
        if (typeof oEditors !== 'undefined' && oEditors.getById[this.targetId]) {
            var doc = oEditors.getById[this.targetId].getWYSIWYGDocument();
            var imgs = doc.body.querySelectorAll("img");

            if (this.targetIndex >= 0 && imgs[this.targetIndex]) {
                imgs[this.targetIndex].src = url;
            } else {
                oEditors.getById[this.targetId].exec("PASTE_HTML", ["<img src='" + url + "' style='max-width:100%; height:auto;'>"]);
            }
        } 
        
        // 팝업 닫기 (부모창 함수 호출)
        if (typeof closeUnsplashModal === 'function') {
            closeUnsplashModal();
        }
    }
};

// 전역 수신 함수 (image_manager.php 팝업 내부에서 호출용)
window.receiveImageUrl = function(url, mi_id) {
    SmartImageManager.receive(url, mi_id);
};