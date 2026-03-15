# HOW TO RECOVER: Premium Web Editor Unification

이 문서는 프리미엄 웹 에디터 공통함수화 작업 중 오류 발생 시 시스템을 즉시 복구하기 위한 지침입니다.

## 1. 파일 복구 (File Restoration)

### 백업 위치
`C:/gnuboard/_backups/20260315_1540_Premium_Editor_Unification`

### 복구 명령 (PowerShell)
```powershell
$backupDir = "C:/gnuboard/_backups/20260315_1540_Premium_Editor_Unification"
$targetBase = "C:/gnuboard"

Get-ChildItem -Path $backupDir -File -Recurse | ForEach-Object {
    $relative = $_.FullName.Substring($backupDir.Length + 1)
    $dest = Join-Path $targetBase $relative
    Copy-Item $_.FullName -Destination $dest -Force
}
```

## 2. 인코딩 및 BOM 확인
수정 후 한글이 깨지거나 AJAX 통신 오류(SyntaxError)가 발생하면, 파일이 **UTF-8 No-BOM**으로 저장되었는지 확인하십시오.

### BOM 제거 확인용 스크립트
```powershell
$file = "대상파일경로"
$content = [System.IO.File]::ReadAllText($file)
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText($file, $content, $utf8NoBom)
```

## 3. 주요 점검 사항
- **JS 에러**: `addItem` 시 에디터가 초기화되지 않는 경우 `project_ui.extend.php`의 JS 초기화 로직을 점검하십시오.
- **레이아웃 깨짐**: PHP 출력문 내에 에디터 관련 HTML 태그가 잘못 닫혔는지 확인하십시오.
