# HOW_TO_RECOVER_BREADCRUMB_SYNC.md

본 문서는 브레드크럼(Breadcrumb) DB 연동 작업 중 문제가 발생했을 때 1초 내에 복구하기 위한 가이드입니다.

## 1. 파일 복구 (Rule 0)
- **백업 위치**: `C:\gnuboard\_backups\20260317_1058_Breadcrumb_DBSync\`
- **복구 방법**: 백업된 `main.skin.php.bak` 파일을 원래 위치로 덮어씌웁니다.
  ```powershell
  copy 'C:\gnuboard\_backups\20260317_1058_Breadcrumb_DBSync\main.skin.php.bak' 'C:\gnuboard\plugin\sub_design\breadcrumb_skins\dropdown\main.skin.php'
  ```

## 2. 주요 로직 정보
- **브레드크럼 스킨**: `plugin/sub_design/breadcrumb_skins/dropdown/main.skin.php`
- **라이브러리**: `plugin/sub_design/lib/design.lib.php` (메뉴 코드 추출용)
- **DB 테이블**: `g5_menu` (또는 `G5_PRO_MENU_TABLE` 정의 시 해당 테이블)

## 3. 발생 가능한 이슈 및 해결
- **한글 깨짐**: PowerShell 수정 시 `$false` 인코딩 미사용 시 발생. `main.skin.php` 파일을 BOM 없는 UTF-8로 다시 저장하십시오.
- **메뉴 미출력**: `me_code` 또는 `ma_code` 길이 기반 필터링(length 2, 4)이 DB 스키마와 맞지 않을 때 발생. `g5_menu` 테이블의 실제 데이터를 확인하십시오.
- **AJAX/모달 에러**: 파일 앞에 BOM이 들어가면 JSON 파싱 에러가 발생할 수 있습니다.
