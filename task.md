# Tasks

## 🚀 Current Priorities (Immediate Fixes)
- [x] **Top Menu Manager Improvement**
    - [x] Refactor skin structure (Delete old _dark/_light, Unify to 5 core skins)
    - [x] Create new skins (`Centered`, `Transparent`, `Minimal`) from HTML samples
    - [x] Implement Live Preview system (`preview.php` + Modal iframe)
    - [x] Apply Theme Inheritance (Color vars & Height) to all skins
- [x] **Tree Category Plugin Completion**
    - [x] Implement HTML Replacement AJAX for Admin Tree
    - [x] Fix "Administrator Access Only" Error
    - [x] Add `[미사용]` Visual Indicator
    - [x] Update Guidelines with "Analyze First" Rule
- [x] **Refining Navigation and Layout**
    - [x] Implement 'Edge Bar' (Section Header) in Skins
    - [x] Fix Breadcrumb Truncation
    - [x] Standardize Sub-Page Layout Class (`.sub-layout-width-height`)
- [ ] **Company Intro Skin Refinement**
    - [x] Standardize Header Alignment (All Left)
    - [x] Implement Organization Chart Skins (Image Type A/B)
    - [x] Implement Business Area Skins (Grid A, Zigzag B, Overlay C)
    - [x] Implement Recruitment Skins (Standard A, Card B, Minimal C)
    - [x] Refine Typography & Icons (Bold Branding)
    - [ ] Final Layout Verification
- [x] **Product Board Skin Implementation**
    - [x] Create sophisticated Product List Skin (`list.skin.php`)
    - [x] Implement Category Tree Sidebar (`sidebar.product.php`)
    - [x] Add Featured Product Gallery & Related Products grid
    - [x] Correct PHP syntax leak and stray symbols
    - [x] Standardize Product View Layout & Aesthetics
    - [x] Implement 'cate' URL auto-selection for Write Page
    - [x] Preserve 'cate' parameter in Featured Product Edit link
- [ ] **Debugging & Optimization (Tomorrow)**
    - [ ] Debug any issues arising from new menu skin integration
    - [ ] Refine Theme CSS Rules & Inheritance logic (`default.css`)

## Project Status

- [ ] **프로젝트 원칙 문서화** <!-- id: 0 -->
    - [x] 개발 원칙 정리 및 `project_rules.md` 생성 <!-- id: 1 -->
    - [x] 서브 비주얼(Hero) 작업 규칙 문서화 (`작업시유의사항.md`) <!-- id: 18 -->
- [x] **관리자 페이지 개선** <!-- id: 2 -->
    - [x] 온라인 문의 리스트 기능 구현 (`theme/corporate/skin/adm/inquiry_list.php`) <!-- id: 3 -->
    - [x] 관리자 메뉴에 '온라인 문의' 연동 (`adm/inquiry_list.php` 래퍼 생성) <!-- id: 4 -->
    - [x] 레거시 메뉴 '온라인 접수 리스트' 제거 (`adm/admin.menu300.php` 주석 처리)
    - [x] 관리자 목록 개선 (10개씩 보기, 선택 삭제 기능 추가)
- [x] **Phase 3: 지도 API 플러그인 개발 (`plugin/map_api`)** <!-- id: 9 -->
    - [x] 플러그인 구조 생성 및 훅 등록 (`hook.php`) <!-- id: 10 -->
    - [x] 관리자 설정 페이지 구현 (`adm/config_form.php`) <!-- id: 11 -->
    - [x] 지도 출력 라이브러리 구현 (`lib/map.lib.php`) <!-- id: 12 -->
    - [x] 테마 연동 (`theme/corporate/index.php` 적용) <!-- id: 13 -->
- [x] **Phase 7: 관리자 페이지 경험 개선 (Company Intro)**
    - [x] 회사소개 스킨 그룹화 및 선택 UI 개선 (`adm/write.php`)
    - [x] 신규 스킨 대거 추가 및 디자인 고도화
