# HOW_TO_LIB_GLOBAL_RESPONSIVE.md

이 문서는 모든 테마 스킨에 공용으로 적용되는 반응형 라이브러리 및 토큰 체계 기술 명세서입니다.

## 1. 디자인 시스템 (Design Tokens)
모든 스킨은 	heme/kukdong_panel/style.css에 정의된 다음 전역 변수를 참조합니다.

### 미디어 쿼리 표준 (Breakpoints)
- --bp-lg: 1200px (Large Desktop)
- --bp-md: 992px (Tablet Landscape)
- --bp-sm: 768px (Mobile Wide) - 핵심 크로스오버 지점
- --bp-xs: 576px (Mobile Standard)

### 유동 타이포그래피 (Fluid Typography)
- --fs-h-hero-main: Hero 메인 타이틀 (clamp 방식)
- --fs-h-hero-desc: Hero 설명문 (clamp 방식)

## 2. 핵심 유틸리티 (Core Utilities)

### Center-focused Scaling (.img-center-focus)
메인 비주얼 이미지가 폭이 좁아지는 모바일 환경에서 피사체(중앙)를 유지하며 자연스럽게 잘리도록 강제하는 로직입니다.
- object-fit: cover
- object-position: center center
- 	ransform-origin: center center

### Mobile Fluid Imaging (.img-mobile-fluid)
768px 이하에서 이미지의 폭을 'auto'로 풀고 'min-width: 100%'를 부여하여 종횡비를 유지하며 화면을 꽉 채우는 유동적 스케일링 기법입니다.

## 3. 가이드라인
- 새로운 스킨 제작 시 고정 높이/폭을 지양하고 가급적 토큰을 사용하십시오.
- 메인 비주얼은 가급적 **중앙 집중형 이미지**를 사용해야 이 라이브러리의 효과가 극대화됩니다.