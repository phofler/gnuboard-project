# HOW_TO_RECOVER_PRODUCT_PAGE.md (제품 페이지UI 회복 지침서)

## 📌 개요
이 문서는 `product_01.html` 및 관련 UI 스타일을 최상의 상태로 복구하기 위한 기술 지침서입니다. AI 작업 중 발생할 수 있는 레이아웃 깨짐, 스크립트 오류, 파일 파손 시 이 문서를 참조하여 즉시 복구하십시오.

## 🗂️ 1. 복구용 백업 파일 정보
*   **백업 경로**: `C:\gnuboard\_backups\20260313_1352_ProductLayoutOptimization\`
*   **대상 파일**: 
    1.  `product_01.html`: 제품 서브페이지 마크업 및 JS 로직
    2.  `style.css`: 레이아웃 및 브레드크럼 전용 스타일

## 🛠️ 2. 긴급 복구 단계 (1초 복구)

### 단계 1: 파일 복원 (PowerShell 사용)
```powershell
cp "C:\gnuboard\_backups\20260313_1352_ProductLayoutOptimization\product_01.html" "C:\gnuboard\main\판넬\2\product_01.html" -Force
cp "C:\gnuboard\_backups\20260313_1352_ProductLayoutOptimization\style.css" "C:\gnuboard\main\판넬\2\style.css" -Force
```

### 단계 2: 캐시 초기화
*   브라우저에서 **`Ctrl + F5`** (강력 새로고침)를 수행하십시오.

## 🔍 3. 주요 점검 사항 (UI/Logic)

### A. 브레드크럼 위치 및 디자인
*   **위치**: 서브 헤더(이미지 영역) 바로 하단에 밀착되어야 함.
*   **동작**: 1차, 2차 드롭다운 버튼 클릭 시 하단 메뉴가 정상 노출되어야 함.
*   **연동**: GNB의 메뉴 데이터와 동기화되어야 함 (JS 로직 확인).

### B. 삭제된 그리드 영역
*   기존의 바둑판식 제품 리스트(`.product-grid-wrap`)가 완전히 제거되었는지 확인하십시오.
*   콘텐츠 영역(`.sub-section`)이 위로 적절히 밀려 올라왔는지 확인하십시오.

### C. 자바스크립트 중복 방지
*   `initDynamicBreadcrumbs()` 함수가 실행될 때 `$('#bread1-list').empty()` 호출을 통해 데이터 중복 적재를 방지해야 합니다.

## 🚨 4. 문제 발생 시 대응
1.  **메뉴 데이터 중복**: `empty()` 로직 누락 확인.
2.  **브레드크럼 클릭 불가**: `z-index` 충돌이나 `event.stopPropagation()` 설정 확인.
3.  **한글 깨짐**: Rule 7에 의거하여 **BOM 없는 UTF-8**로 재저장 하십시오.

---
최종 업데이트: 2026-03-13
작성자: Antigravity AI
