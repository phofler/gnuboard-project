# HOW_TO_RECOVER_THEME_LANG_UNIFICATION.md

## 1. 개요
'Theme & Lang' 선택 UI 및 식별코드 생성 로직을 공통 라이브러리(`extend/project_ui.extend.php`)로 통합하는 작업을 복구하기 위한 가이드입니다.

## 2. 장애 유형 및 복구 방법

### 상황 1: 관리자 페이지 접속 시 PHP Fatal Error 발생
- **원인**: `extend/project_ui.extend.php` 파일에 문법 오류가 있거나 파일이 손상됨.
- **복구**: 
  1. `C:\gnuboard\extend\project_ui.extend.php` 파일을 삭제하거나 이름을 변경합니다.
  2. 백업된 원본 파일들(Rule 0)을 복원합니다.

### 상황 2: 테마/언어 선택 시 식별코드(ID)가 자동 생성되지 않음
- **원인**: JavaScript 함수 `get_theme_lang_select_ui`의 내부 로직 오류 또는 브라우저 캐시 문제.
- **복구**: 
  1. 테마 폴더 권한 확인 및 브라우저 강력 새로고침(Ctrl + F5).
  2. `extend/project_ui.extend.php` 내의 `<script>` 섹션 검토.

## 3. 원본 복구 스크립트 (Rule 0 참조)
작업 전 백업된 파일을 사용하여 즉시 복구하려면 아래 명령어를 PowerShell에서 실행하십시오.

```powershell
$dt = "20260313_2226"; # 실제 백업된 폴더명 확인 필요
$backupDir = "C:\gnuboard\_backups\${dt}_Theme_Lang_Unification";
$utf8NoBom = New-Object System.Text.UTF8Encoding $false

# 1. Top Menu Manager 복구
$oldLib = [System.IO.File]::ReadAllText("$backupDir\top_menu_lib.php.bak")
[System.IO.File]::WriteAllText("C:\gnuboard\plugin\top_menu_manager\lib.php", $oldLib, $utf8NoBom)

# 2. Main Visual Manager 복구
$oldWrite = [System.IO.File]::ReadAllText("$backupDir\main_visual_write.php.bak")
[System.IO.File]::WriteAllText("C:\gnuboard\plugin\main_image_manager\adm\write.php", $oldWrite, $utf8NoBom)

# 3. 공통 확장 파일 삭제
Remove-Item "C:\gnuboard\extend\project_ui.extend.php" -Force
```

## 4. 핵심 체크포인트
- **BOM 체크**: 수정된 파일들이 `BOM 없는 UTF-8`인지 반드시 확인하십시오. (BOM이 있으면 AJAX/JSON 응답이 깨질 수 있음)
- **접두사(Prefix)**: 메뉴는 `tm_`, 메인은 `mi_` 접두사가 필드명과 일치하는지 확인하십시오.
