# HOW TO LIB: Product Intro Responsive Standard (Final)

이 문서는 `product_intro` 스킨과 테마 전체에 적용된 반응형 표준 사양을 기록합니다.

## 1. 반응형 핵심 원칙 (The Nuclear Standards)

### 1-1. 구조적 유연성 (Structural Fluidity)
- **Hard Lock 제거**: `default.css`의 `min-width: 1200px` 설정을 1200px 이하 뷰포트에서 `min-width: 0 !important`로 덮어씌워 왼쪽 짤림 현상을 방지함.
- **Sovereign Reset**: `#wrapper`, `#container_wr`, `#hd`, `#ft` 등 모든 주요 구조 ID에 `width: 100% !important`를 적용하여 뷰포트 피팅 강제.

### 1-2. 클래스 명명 표준 (Harmonization)
- 모든 스킨 클래스는 하이픈(`-`) 기반으로 통일함.
- `.product-intro`: 섹션 루트
- `.product-row`: 제품 행 (교차 배치 지원)
- `.product-text`, `.product-img`: 제품 상세 구성요소

## 2. 모바일 핵중앙 정렬 (Nuclear Centering) 사양

### 2-1. 텍스트 및 이미지 배치 (768px 이하)
- **배치**: `flex-direction: column !important`로 수직 스택.
- **정렬**: `text-align: center !important` 및 `margin: 0 auto !important`로 가로 중앙 정렬 보장.
- **이미지**: `aspect-ratio: 4/3` 또는 `16/9`를 유지하며 `width: 100%`로 꽉 차게 배치.

### 2-2. 애니메이션 오프셋 제거
- 모바일에서 `translateX` 등으로 인한 시각적 치우침을 방지하기 위해 `reveal.active` 상태에서 `transform: none !important`를 적용.

## 3. 기술적 특이사항 (Developer Notes)

- **CSS 직접 주입**: AJAX 로드나 뒤늦은 스킨 로드 시 `add_stylesheet`가 작동하지 않는 문제를 해결하기 위해 PHP 라이브러리에서 스킨 CSS를 직접 `echo` 방식으로 주입함.
- **우선순위 관리**: 테마의 강력한 고정 수치를 이기기 위해 `#wrapper`를 접두어로 사용하고 필요한 경우 `!important`를 적극 활용함.

---
**기록 일시**: 2026-03-17 21:30
**담당 에이전트**: Antigravity (Standardization Core)