# HOW_TO_LIB_JS_IMAGE_MANAGER.md

이 문서는 섹션 관리자에서 사용되는 이미지 매니저(SmartImageManager)와 관리 페이지(`write.php`) 간의 상호작용 로직을 정리한 기술 서입니다.

## 1. 전역 헬퍼 함수 (Helpers)
관리 페이지(`adm/write.php`)에는 이미지 매니저 팝업과 통신하기 위한 세 가지 핵심 가교 함수가 정의되어 있습니다.

1.  **`openUnsplashPopup(id)`**:
    - 역할: `SmartImageManager.open`을 호출하여 팝업을 엽니다.
    - 매개변수: `id` (아이템의 고유 ID, 예: `35` 또는 `new_123456`)
    - 특징: 콜백을 통해 `receiveImageUrl`과 자동 연결됩니다.

2.  **`receiveImageUrl(url, id)`**:
    - 역할: 이미지 매니저에서 선택된 이미지 URL을 수신하여 UI를 업데이트합니다.
    - 동작: 해당하는 `hidden input`의 값을 변경하고, 미리보기 영역(`mc_preview_`)에 이미지를 출력합니다.

3.  **`closeUnsplashModal()`**:
    - 역할: 열려있는 Unsplash 모달 팝업을 닫습니다.

## 2. 호출 구조
- **기존 항목**: PHP 루프 내에서 버튼의 `onclick` 이벤트에 `openUnsplashPopup('<?php echo $mi_id; ?>')`가 바인딩됩니다.
- **신규 항목 (AJAX)**: `adm/ajax.add_item.php`에서 반환되는 HTML 버튼에도 동일한 함수 호출이 포함되어 있어, 페이지 새로고침 없이도 즉시 이미지 관리가 가능합니다.

## 3. 주의사항
- `SmartImageManager` 객체는 `js/image_smart_manager.js`에 정의되어 있으며, `write.php` 상단에서 로드됩니다.
- 모든 JavaScript 수정은 AJAX 응답 파손을 방지하기 위해 **BOM 없는 UTF-8** 인코딩을 준수해야 합니다.
