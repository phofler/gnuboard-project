# HOW_TO_LIB_ABOUT_PAGE.md

이 문서는 CEO 인사말 페이지(`about.html`)의 구조와 디자인 시스템에 대한 기술 명세서입니다.

## 1. 디자인 컨셉
- **Premium Visual**: 다크 블루(`--color-brand`)와 레드(`--about-accent`)를 활용한 고발색 포인트 디자인.
- **Glassmorphism**: 히어로 섹션과 컨텐츠 박스에 은은한 그라데이션과 그림자를 사용하여 입체감 부여.
- **Micro-Animations**: JavaScript `IntersectionObserver`를 활용하여 스크롤 시 컨텐츠가 순차적으로 떠오르는(fade-up) 효과 구현.

## 2. 파일 구조
- **HTML**: 세만틱 마크업 (header, section, div)
- **CSS**: 내장 스타일링 및 테마 공통 스타일(`style.css`) 연동.
    - **핵심**: `.greeting-section` 등 주요 스타일이 `style.css` 전역에 반영되어 `company_intro` 플러그인(웹에디터 컨텐츠)에서도 즉시 적용됩니다.
- **Assets**: 현재는 CSS 박스 모델로 이미지를 대체함 (유지보수 용이성).

## 3. 주요 클래스 및 변수
- `.about-page-wrapper`: 전체 페이지 컨테이너.
- `.ceo-visual-box`: 메인 비주얼 영역 (현재 그라데이션 처리).
- `.customer-card`: 하단 고객센터 정보 카드 (2열 그리드).
- `data-aos="fade-up"`: 애니메이션 대상 요소에 부여하는 속성.

## 4. 커스텀 가이드
- **텍스트 수정**: `greeting-lead` 및 `greeting-body` 클래스 내부 텍스트를 수정하십시오.
- **색상 변경**: `:root`의 `--about-accent` 변수를 수정하여 포인트 컬러를 일괄 변경할 수 있습니다.
- **모바일 대응**: 브레이크포인트 `991px` 및 `768px`를 기준으로 레이아웃이 유동적으로 변경되도록 설계되었습니다.
