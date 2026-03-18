# HOW TO RECOVER MAIN CONTENT ENCODING & DATA

본 문서는 메인 페이지의 한글 깨짐 및 동적 데이터 미출력 이슈 발생 시 1초 만에 복구하기 위한 지침서입니다.

## 1. 긴급 원복 (PowerShell)

만약 수정 후 페이지가 하얗게 나오거나 레이아웃이 깨진다면, 아래 명령어를 PowerShell(관리자 권한 권장)에서 실행하여 즉시 이전 상태로 되돌립니다.

```powershell
chcp 65001
$backupFile = "C:\gnuboard\_backups\20260318_1215_main_encoding_fix\index.php"
$target = "C:\gnuboard\theme\kukdong_panel\index.php"
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
$content = [System.IO.File]::ReadAllText($backupFile)
[System.IO.File]::WriteAllText($target, $content, $utf8NoBom)
```

## 2. 체크리스트 (Ghost Save 및 BOM 방지)

*   **BOM 확인**: PHP 파일 처음에 보이지 않는 특수문자(BOM)가 있으면 레이아웃이 상단으로 밀리거나 AJAX가 깨집니다. 반드시 `$false` 옵션으로 저장된 파일인지 확인하십시오.
*   **함수 확인**: `display_main_content` 함수가 존재하지 않으면 고정된 옛날 데이터(그라스울 패널 등)가 나옵니다. `plugin/main_content_manager/lib/main_content.lib.php` 파일이 제대로 로드되었는지 확인하십시오.
*   **언어 설정**: `$lang` 변수가 `kr`이 아니면 해당 언어에 맞는 섹션이 없어서 아무것도 나오지 않을 수 있습니다. DB의 `g5_plugin_main_content_sections` 테이블의 `ms_lang`을 확인하십시오.

## 3. 관련 파일 경로
*   메인 페이지: `C:\gnuboard\theme\kukdong_panel\index.php`
*   콘텐츠 라이브러리: `C:\gnuboard\plugin\main_content_manager\lib\main_content.lib.php`
*   콘텐츠 스킨: `C:\gnuboard\plugin\main_content_manager\skins\product_intro/main.skin.php`
*   CSS 스타일: `C:\gnuboard\plugin\main_content_manager\skins\product_intro/style.css`
