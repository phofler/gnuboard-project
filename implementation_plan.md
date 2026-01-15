# Implementation Plan - Webzine Skin Integration

그누보드 테마의 포트폴리오/뉴스 섹션을 위한 고품질 **웹진(Webzine)** 스킨을 구현합니다. 이 스킨은 `테마스킨.md`의 표준을 준수하며, 텍스트 가독성과 에디토리얼 디자인을 강조합니다.

## Goal Description
- **목표**: `theme/corporate_light` 테마 전용 **웹진 스타일 게시판 스킨** 제작.
- **핵심 가치**: 
    1.  **Readability**: 긴 글을 편안하게 읽을 수 있는 타이포그래피 중심 디자인.
    2.  **Editorial Look**: 잡지처럼 세련된 교차형 리스트(Alternating List)와 스티키 메타 뷰(Sticky Meta View).
    3.  **Theme Sovereignty**: 테마의 `default.css` 변수(`--color-bg-panel`, `--font-body`)를 철저히 상속.

## User Review Required
> [!IMPORTANT]
> **디자인 패턴 결정**: 리스트 레이아웃을 '지그재그(Zigzag)' 형태로 고정할지, 옵션으로 제공할지 결정이 필요합니다. 현재는 **무조건 지그재그(홀/짝 교차)**를 표준으로 진행합니다.

## Proposed Changes

### Theme & Skin Directory
`theme/corporate_light/skin/board/webzine/`

#### [NEW] `list.skin.php`
- **Structure**: `ul.webzine-list > li.webzine-item`
- **Logic**:
    - `$i`가 짝수/홀수임에 따라 클래스 교차 (`.is-odd`, `.is-even`).
    - 썸네일이 없으면 텍스트가 100% 차지하는 유동적 레이아웃.
- **Style**:
    - 이미지와 텍스트 비율 5:5 (PC 기준).
    - 모바일에서는 수직 적층(Stack).

#### [NEW] `view.skin.php`
- **Structure**: Split Layout (7:3)
    - **Main Content (Left/Center)**: 본문, 타이틀, 거대한 리드 텍스트.
    - **Sticky Sidebar (Right)**: 작성일, 카테고리, 공유 버튼, 글쓴이 정보.
- **Features**:
    - 스크롤 시 우측 메타 정보가 따라오는 `position: sticky` 적용.
    - 본문 내 `img` 태그는 `max-width: 100%` 및 `height: auto` 강제.

#### [NEW] `write.skin.php`
- **Standard**: 기존 `Magazine` 스킨의 `write.skin.php`를 기반으로 하되, 불필요한 필드를 제거하고 심플하게 유지.

#### [NEW] `style.css`
- **Variables**: `default.css` 변수 매핑.
- **Components**: `.webzine-item`, `.webzine-meta`, `.sticky-sidebar`.

## Verification Plan

### Automated Tests
- 없음 (UI 스킨 작업이므로 육안 검수 필요).

### Manual Verification
1.  **Board Skin Manager 등록**: 관리자 페이지에서 `webzine` 스킨 선택 가능 여부 확인.
2.  **데이터 입력 테스트**:
    - 글 5개 이상 등록 (썸네일 있는 것/없는 것 섞어서).
    - 리스트 페이지에서 지그재그 레이아웃이 제대로 나오는지 확인.
3.  **반응형 테스트**:
    - 모바일(375px)에서 1단으로 붕괴(Collapse)되는지 확인.
    - 태블릿(768px)에서의 여백 확인.
4.  **다크 모드 테스트**:
    - 테마 설정을 Dark로 바꿨을 때 배경색/글자색이 `default.css` 변수를 따라 자동으로 변하는지 확인.
