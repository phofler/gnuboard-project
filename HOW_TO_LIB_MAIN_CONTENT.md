# HOW TO LIB MAIN CONTENT MANAGER

본 문서는 메인 페이지 최신글 및 동격 섹션 관리 시스템의 로직을 설명합니다.

## 1. 아키텍처 개요
메인 페이지(`index.php`)는 `main_content_manager` 플러그인을 사용하여 관리자 페이지에서 설정한 섹션들을 동적으로 렌더링합니다.

## 2. 핵심 로직
1.  **플러그인 로드**: `index.php` 상단에서 `main_content.lib.php`를 `include_once` 합니다.
2.  **데이터 추출**: `display_main_content($lang)` 함수가 호출되면 DB에서 활성화된(`ms_active=1`) 섹션들을 언어별로 가져옵니다.
3.  **스킨 렌더링**: 각 섹션은 지정된 `ms_skin` 경로의 `main.skin.php`를 통해 출력됩니다.
4.  **보안 세이프가드**: `G5_PLUGIN_PATH`를 사용하여 경로를 동적으로 생성하며, 테마의 `head.php`와 `tail.php` 사이에서 본문을 구성합니다.

## 3. 주요 구성 요소
*   **DB 테이블**: 
    *   `g5_plugin_main_content_sections`: 섹션 설정 (제목, 스타일, 노출 여부 등)
    *   `g5_plugin_main_content`: 각 섹션 내부의 아이템 (이미지, 텍스트, 링크 등)
*   **스킨 상속**: 각 스킨은 `skin.head.php`를 포함하여 공통 스타일과 애니메이션(AOS 등)을 처리할 수 있습니다.

## 4. 유지보수 가이드
*   새로운 스타일을 추가하려면 `plugin/main_content_manager/skins/` 아래에 폴더를 만들고 `main.skin.php`와 `style.css`를 작성하십시오.
*   반응형 처리는 `style.css` 내에서 미디어 쿼리를 사용하여 해당 스킨 전용으로 적용됩니다.
