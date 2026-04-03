# HOW TO RECOVER PRODUCT INTRO METADATA

본 문서는 `product_intro` 섹션의 태그(Tag) 및 소제목(Subtitle) 표시 기능에 문제가 발생했을 때 1초 만에 복구하기 위한 지침서입니다.

## 1. 긴급 원복 (PowerShell)

UI가 깨지거나 데이터가 나오지 않는 경우, 아래 명령어를 PowerShell(관리자 권한)에서 실행하여 즉시 원복합니다.

```powershell
chcp 65001
$d = "20260318_1232" # 해당 작업의 백업 폴더명 확인 필요
$backupDir = "C:\gnuboard\_backups\$d`_product_intro_metadata_fix"
$utf8NoBom = New-Object System.Text.UTF8Encoding $false

# 스킨 파일 원복
$skinContent = [System.IO.File]::ReadAllText("$backupDir\main.skin.php")
[System.IO.File]::WriteAllText("C:\gnuboard\plugin\main_content_manager\skins\product_intro\main.skin.php", $skinContent, $utf8NoBom)

# CSS 파일 원복
$cssContent = [System.IO.File]::ReadAllText("$backupDir\style.css")
[System.IO.File]::WriteAllText("C:\gnuboard\plugin\main_content_manager\skins\product_intro\style.css", $cssContent, $utf8NoBom)
```

## 2. 체크리스트

*   **BOM 오염 확인**: 수정 후 화면 상단에 공백이 생기거나 레이아웃이 밀린다면 BOM(Byte Order Mark)이 포함된 것입니다. 반드시 PowerShell `$false` 옵션으로 재저장하십시오.
*   **태그 미노출**: 관리자 페이지에서 `mc_tag` 필드에 'Zinc Panel' 등이 입력되었는지 확인하십시오.
*   **소제목 미노출**: 관리자 페이지에서 `mc_subtitle` 필드에 '(그라스울판넬 / ...)' 등이 입력되었는지 확인하십시오.

## 3. 관련 파일 경로
*   스킨: `C:\gnuboard\plugin\main_content_manager\skins\product_intro\main.skin.php`
*   스타일: `C:\gnuboard\plugin\main_content_manager\skins\product_intro\style.css`
*   데이터베이스: `g5_plugin_main_content` 테이블의 `mc_tag`, `mc_subtitle` 컬럼
