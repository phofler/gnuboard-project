# HOW_TO_RECOVER_MAIN_VISUAL_LOGIC_FIX.md

## 1. 개요
'Main Visual' 매니저의 Theme & Lang 선택 로직을 개선하기 위해 진행된 DB 스키마 변경 및 코드 리팩토링을 복구하기 위한 가이드입니다.

## 2. 장애 유형 및 복구 방법

### 상황 1: 관리자 페이지 접속 시 DB 오류 (Missing Columns)
- **현상**: `mi_theme`, `mi_lang` 등 컬럼이 없다는 SQL 에러 발생.
- **복구**: 
  1. 아래 SQL을 실행하여 컬럼이 있는지 확인하고, 없으면 수동으로 추가하거나 백업된 `update.php`로 되돌리기 전 DB 상태를 유지합니다.
  ```sql
  ALTER TABLE g5_plugin_main_image_config ADD COLUMN mi_theme VARCHAR(255) NOT NULL AFTER mi_id;
  ALTER TABLE g5_plugin_main_image_config ADD COLUMN mi_lang VARCHAR(255) NOT NULL AFTER mi_theme;
  ALTER TABLE g5_plugin_main_image_config ADD COLUMN mi_custom VARCHAR(255) NOT NULL AFTER mi_lang;
  ```

### 상황 2: 파일 저장 후 고스트 세이브 또는 BOM 이슈 발생
- **현상**: 화면이 하얗게 나오거나(White screen), AJAX 응답 파손 등으로 모달이 동작하지 않음.
- **복구**: 
  1. `_backups/20260313_2245_Main_Visual_Logic_Fix/` 폴더의 `.bak` 파일을 원본 경로로 복사합니다.
  2. 반드시 PowerShell의 `[System.IO.File]::WriteAllText($file, $content, $utf8NoBom)` 방식을 사용하여 BOM 없이 저장하십시오.

## 3. 원본 복구 스크립트 (Rule 0 참조)
```powershell
$dt = "20260313_2245";
$backupDir = "C:\gnuboard\_backups\${dt}_Main_Visual_Logic_Fix";
$utf8NoBom = New-Object System.Text.UTF8Encoding $false

# 1. 파일 복원
$c1 = [System.IO.File]::ReadAllText("$backupDir\write.php.bak")
[System.IO.File]::WriteAllText("C:\gnuboard\plugin\main_image_manager\adm\write.php", $c1, $utf8NoBom)

$c2 = [System.IO.File]::ReadAllText("$backupDir\update.php.bak")
[System.IO.File]::WriteAllText("C:\gnuboard\plugin\main_image_manager\adm\update.php", $c2, $utf8NoBom)

$c3 = [System.IO.File]::ReadAllText("$backupDir\project_ui.extend.php.bak")
[System.IO.File]::WriteAllText("C:\gnuboard\extend\project_ui.extend.php", $c3, $utf8NoBom)

# 2. DB 컬럼 제거 (필요시)
# C:\xampp\mysql\bin\mysql.exe -u root gnuboard5 -e "ALTER TABLE g5_plugin_main_image_config DROP COLUMN mi_theme, DROP COLUMN mi_lang, DROP COLUMN mi_custom;"
```

## 4. 핵심 체크포인트
- `kukdong_panel`과 같이 테마 이름에 `_`가 포함된 경우, `mi_theme` 컬럼에 정확히 `kukdong_panel`이 저장되어야 합니다.
- `project_ui.extend.php`의 JS 로직이 `id_custom` 필드의 값을 가져올 때 언더바를 허용하는지 확인하십시오.
