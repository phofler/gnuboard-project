# HOW_TO_RECOVER_FONT_SIZE_ADJUSTMENT.md

## 1. 개요
전역 폰트 크기 변수(`--fs-desc`) 도입 및 `product_intro` 스킨 적용 작업을 복구하기 위한 가이드입니다.

## 2. 장애 유형 및 복구 방법

### 상황 1: 레이아웃 깨짐 또는 디자인 불만족
- **현상**: 폰트 크기가 너무 커서 레이아웃이 어긋나거나 모바일에서 텍스트가 넘침.
- **복구**: 
  1. `theme/kukdong_panel/style.css`에서 `--fs-desc` 값을 조정(예: `1.25rem` -> `1.15rem`)합니다.
  2. 수정이 실패한 경우 아래 백업 복구 스크립트를 실행합니다.

### 상황 2: 고스트 세이브 또는 BOM 이슈 (화면 빈칸/AJAX 에러)
- **현상**: 파일 수정 후 화면에 보이지 않는 공백이 생기거나 PHP 에러 발생.
- **복구**: 
  1. 백업된 원본 파일을 PowerShell 스크립트를 통해 복원합니다. (BOM 없는 UTF-8 보장)

## 3. 원본 복구 스크립트
아래 스크립트의 `$dt` 값을 백업 폴더명에 맞춰 수정 후 실행하십시오.

```powershell
$dt = "20260315_2032"; # 실제 백업 폴더 날짜/시간으로 수정 필요
$backupDir = "C:\gnuboard\_backups\${dt}_FontSizeAdjustment";
$utf8NoBom = New-Object System.Text.UTF8Encoding $false

# 1. 테마 style.css 복구
$c1 = [System.IO.File]::ReadAllText("$backupDir\style.css.bak")
[System.IO.File]::WriteAllText("C:\gnuboard\theme\kukdong_panel\style.css", $c1, $utf8NoBom)

# 2. 스킨 style.css 복구
$c2 = [System.IO.File]::ReadAllText("$backupDir\product_intro_style.css.bak")
[System.IO.File]::WriteAllText("C:\gnuboard\plugin\main_content_manager\skins\product_intro\style.css", $c2, $utf8NoBom)
```

## 4. 핵심 체크포인트
- `--fs-desc` 변수가 정의되지 않았을 때를 대비해 스킨 CSS에서 `var(--fs-desc, 1.25rem)`과 같이 fallback 값을 사용하는지 확인하십시오.
- 모바일 스타일(`@media`)에서 해당 변수를 재정의하여 크기를 줄이는 것이 필요한지 검토하십시오.
