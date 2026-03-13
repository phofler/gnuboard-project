# 상단 메뉴 관리 최종 마무리 및 작업 연속성 보장(Sync) 계획서 (2026-03-13 최신본)

본 계획서는 사무실과 자택 등 환경 변화에도 작업이 끊기지 않도록 **데이터 동기화**를 보장하고, **Phase 1.5 상단 메뉴 관리**를 완벽하게 매듭짓기 위한 지침입니다.

## 1. 환경 동기화 (Sync) 체크리스트
집에서 작업 시 다음 항목들을 반드시 확인해야 합니다.

### [파일 동기화 대상]
- **테마**: `C:\gnuboard\theme\kukdong_panel\` (전체)
- **플러그인**: 
    - `C:\gnuboard\plugin\top_menu_manager\` (전체)
    - `C:\gnuboard\plugin\pro_menu_manager\` (전체)
- **라이브러리**: `C:\gnuboard\extend\user_top_menu.extend.php`

### [데이터베이스(DB) 동기화]
- **테이블**: `g5_plugin_top_menu_config` (스키마 및 데이터)
- **필수 확인**: 상단 메뉴용 게시판 데이터 (`g5_write_menu_pdc` 등)

## 2. Phase 1.5 핵심 기술 과제

### [과제 A] 스킨 선택 오작동 원천 해결
- **해결**: `extend` 라이브러리에서 DB의 `tm_skin` 값을 전역 변수로 추출하여 `head.php`에서 디자인 분기 처리.

### [과제 B] 설정 UI 공통 라이브러리화 (Home Optimization)
- **해결**: `get_top_menu_id_config_html()` 함수를 `lib.php`에 등록하여 중복 로직 제거.

## 3. 작업 시 절대 수칙 (Rule 0, 7)
- **Rule 0 (백업)**: 작업 시작 전 `_backups/` 폴더에 원본 복사.
- **Rule 7 (저장)**: 모든 파일은 **BOM 없는 UTF-8**로 PowerShell을 통해 저장.

## 4. 환경 이전 (Sync) 가이드: 사무실 → 집
1. **DB 추출**: `sqldump -u root -p gnuboard5 g5_plugin_top_menu_config > menu_config.sql`
2. **파일 이동**: `theme/kukdong_panel`, `plugin/top_menu_manager` 폴더 등 챙기기.
3. **집에서 복구**: `C:\gnuboard` 내 동일 경로에 풀고 DB 임포트.

## 5. 향후 일정
1. Phase 1.5 완결 및 검증 (집/사무실 교차 테스트)
2. Phase 2 서브 레이아웃 본격 착수