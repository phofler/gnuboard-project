# HOW_TO_LIB_LAYOUT_FIX.md

이 문서는 프로젝트의 전역 레이아웃 및 반응형 컨테이너 구조에 대한 기술적 이해를 돕기 위한 라이브러리 지침서입니다.

## 1. 핵심 구조 (Core Structure)

본 프로젝트는 GnuBoard의 기본 ID 구조를 유지하면서 테마의 주권(Theme Sovereignty)을 지키기 위해 다음과 같은 규칙을 따릅니다.

### 1-1. 전역 컨테이너 (#container)
- **너비 전략**: `width: 100% !important`로 가변성을 확보하되, `max-width: 1200px`로 PC에서의 무한 확장을 방지합니다.
- **정렬 전략**: `margin: 0 auto !important`를 통해 항상 화면 중앙에 위치시킵니다.
- **여백 전략**: `--container-padding` 변수를 사용하여 모바일에서도 컨텐츠가 화면 끝에 붙지 않도록 유동적인 패딩을 제공합니다.

### 1-2. CSS 변수 (Tokens)
- `--container-padding`: 기본값 `20px`. 모바일 여백의 기준이 됩니다.
- `--max-width`: 기본값 `1200px`. 전체 레이아웃의 최대 폭입니다.

## 2. 주요 수정 내역 (2026-03-18)

- **style.css**: `#container`의 `padding: 0 !important`를 `padding: 0 var(--container-padding) !important`로 변경하여 텍스트 왼쪽 붙음 현상을 해결했습니다.
- **style.css**: `#container_wr`에 `overflow: visible`을 추가하여 중복 스크롤 및 레이아웃 짤림 현상을 방지했습니다.

## 3. 유지보수 가이드
새로운 섹션이나 스킨을 제작할 때는 반드시 `.container` 클래스 또는 상위 `#container`의 여백 체계를 활용하십시오. 인라인 스타일로 `padding: 0`을 강제하는 행위는 반응형을 파괴하므로 금지됩니다.
