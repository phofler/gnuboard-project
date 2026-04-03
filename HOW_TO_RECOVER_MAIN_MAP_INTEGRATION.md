# 메인 페이지 지도 연동 복구 가이드 (HOW_TO_RECOVER_MAIN_MAP_INTEGRATION.md)

## 🚨 1. 개요 (Overview)
메인 페이지 하단(Copyright 위)에 지도를 출력하기 위해 **Bridge Pattern**을 적용한 내역입니다.
`company_intro`의 데이터와 `main_content_manager`의 섹션 관리가 연동되어 동작합니다.

---

## 🛠 2. 주요 아키텍처 (Architecture)

### [Bridge Pattern Flow]
1.  **Source**: `company_intro`에서 지도 레이아웃(HTML) 관리.
2.  **Bridge**: `main_content_manager`의 `main_loader` 스킨이 소스 데이터를 호출.
3.  **Expansion**: 글로벌 라이브러리(`lib/premium_module.lib.php`)의 `expand_premium_placeholder` 함수가 `{MAP_API_DISPLAY}` 등을 실제 데이터로 치환.

---

## 🚨 3. 복구 방법 (Restore Procedure)

### 파일 복구
문제가 발생할 경우 `_backups/` 내의 해당 날짜 폴더에서 다음 파일을 복구하십시오:
- `plugin/main_content_manager/lib/main_content.lib.php`
- `plugin/main_content_manager/skins/main_loader/main.skin.php`
- `lib/premium_module.lib.php`

### 지도 미출력 시 체크리스트
1.  **라이브러리 확인**: `plugin/map_api/lib/map.lib.php` 파일이 존재하는지 확인.
2.  **ID 일치 확인**: 메인 컨텐츠 관리의 [회사소개 연동 ID]가 `company_intro`에 등록된 ID와 정확히 일치하는지 확인.
3.  **치환자 오타**: `main_map.html` 시안에 `{MAP_API_DISPLAY}` 치환자가 정확히 박혀있는지 확인.

---

## 💡 4. 관리 팁
- 오시는 길 주소나 전화번호를 수정하려면 **'카피라이트 관리'**에서 정보를 수정하면 지도의 텍스트도 자동으로 바뀝니다. (동적 바인딩)

---
**최종 업데이트**: 2026-03-16
**보고자**: Antigravity (AI Agent)


## 📝 5. 수정 이력 (Bug Fix History)

### [2026-03-16] SQL Error & Placeholder Mapping Fix
- **증상**: 메인 페이지 지도 출력 시 Unknown column 'kukdong_panel' in 'where clause' 오류 발생 및 주소/전화번호 미출력.
- **원인**: 
    1. map.lib.php에서 get_premium_config 호출 시 인자(컬럼명 vs ID) 순서가 뒤바뀜.
    2. premium_module.lib.php에서 잘못된 함수(get_footer_config) 호출 및 비표준 키값(cp_address 등) 사용.
- **조치**: 인자 순서 정정 및 get_copyright_config() 호출-ddr_val 매핑으로 정규화 완료.


## 📝 6. 디자인 시스템 표준화 (Design System Standardization) [2026-03-16]

테마스킨.md 가이드의 "무관용 원칙"에 따라 파편화된 디자인 변수를 통합했습니다.

### 적용 사항
- **글로벌 토큰 정의**: 	heme/corporate_light/css/default.css에 --color-title-main, --color-title-sub, --letter-spacing-h 등 시맨틱 변수 구축.
- **스킨 CSS 리팩토링**: 
    - Product Intro 메인 스킨의 하드코딩 색상 및 비표준 변수(primary-dark)를 제거하고 전역 토큰으로 교체.
    - Main Map 스킨의 모든 스타일 요소를 테마 표준 변수와 동기화.
- **효과**: 테마 컬러 변경 시 메인 페이지의 모든 섹션(지도, 제품 소개 등)이 일관되게 반응함.


### ⚠️ [중요] 루트 스타일(style.css) 중복 선언 해결 [2026-03-16]
- **증상**: 스킨 CSS 수정 후에도 브라우저에서 --primary-dark 등 비표준 변수가 계속 유지됨.
- **원인**: C:\gnuboard\style.css (루트 위치)에서 구형 디자인 규격이 강제로 선언되어 스킨 설정을 덮어쓰고 있었음.
- **해결**: 루트 style.css 내의 비표준 변수를 ar(--color-title-main) 등으로 전면 치환하여 테마 토큰 시스템과 동기화함.
## 📝 7. 지도 섹션 디자인 표준화 (Map Section Design Standardization) [2026-03-16]
- **증상**: 지도 섹션(LOCATION)의 타이틀 크기, 자간, 폰트가 다른 메인 섹션과 미묘하게 달라 불협화음 발생.
- **조치 사항**:
    - plugin/company_intro/skin/main_map.html 내부의 모든 하드코딩 스타일 제거.
    - 테마 전역 변수(--font-heading, --mc-title-size, --spacing-title-gap 등)를 강제 상속시켜 프로젝트 전체 미감과 100% 동기화.
- **복구**: _backups/ 내의 map_standardization 폴더에서 main_map.html.bak 파일을 원본 경로로 복사하십시오.