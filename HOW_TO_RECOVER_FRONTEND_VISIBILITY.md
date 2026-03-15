# HOW TO RECOVER: Frontend Visibility Integration

이 문서는 메인 페이지 프론트엔드 동적 연동 작업 중 오류 발생 시 즉시 복구하기 위한 지침입니다.

## 1. 파일 복구 (File Restoration)

### 백업 위치
`C:/gnuboard/_backups/20260315_1610_Frontend_Visibility_Integration`

### 복구 명령 (PowerShell)
```powershell
Copy-Item "C:/gnuboard/_backups/20260315_1610_Frontend_Visibility_Integration/index.php" -Destination "C:/gnuboard/theme/kukdong_panel/index.php" -Force
```

## 2. 인코딩 및 BOM 확인
수정 후 메인 페이지가 하얗게 나오거나 깨지는 경우, 파일이 **UTF-8 No-BOM**으로 저장되었는지 확인하십시오.

### BOM 제거 확인용 스크립트
```powershell
$file = "C:/gnuboard/theme/kukdong_panel/index.php"
$content = [System.IO.File]::ReadAllText($file)
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText($file, $content, $utf8NoBom)
```

## 3. 주요 점검 사항
- **함수 미정의 에러**: `display_main_content` 함수가 없다는 에러 발생 시 `plugin/main_content_manager/lib/main_content.lib.php` 파일이 제대로 `include_once` 되었는지 확인하십시오.
- **레이아웃 깨짐**: 기존 하드코딩된 `<section class="product-intro">`를 삭제하면서 태그 쌍(`<div>` 등)이 잘못 삭제되지 않았는지 확인하십시오.
