# HOW_TO_RECOVER_LAYOUT_FIX.md

이 문서는 상단 메뉴 및 컨텐츠 정렬(텍스트 왼쪽 붙음 현상) 수정 작업 중 문제가 발생했을 때 1초 만에 복구하기 위한 긴급 지침서입니다.

## 1. 개요
- **마일스톤**: 2026-03-18 텍스트 정렬 및 반응형 여백 최적화
- **핵심 목표**: PC 선 중앙 정렬 및 모바일 여백(Fluid Padding) 확보
- **백업 위치**: `C:\gnuboard\_backups\20260318_0939_text_alignment_fix\`

## 2. 긴급 복구 절차 (Emergency)

레이아웃이 깨지거나 정렬이 틀어졌을 경우 아래 PowerShell 명령어로 즉시 원복하십시오.

### 테마 스타일시트 원복
```powershell
chcp 65001
$backupDir = "C:\gnuboard\_backups\20260318_0939_text_alignment_fix"
$target = "C:\gnuboard\theme\kukdong_panel\css\style.css"
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
$content = [System.IO.File]::ReadAllText("$backupDir\style.css")
[System.IO.File]::WriteAllText($target, $content, $utf8NoBom)
```

## 3. 체크리스트 (Issue Resolution)
- **BOM 오염**: 수정 후 상단에 원인 불명의 공백이 생기면 반드시 **BOM 없는 UTF-8** 형식을 확인하십시오.
- **왼쪽 짤림**: 화면이 작아질 때 왼쪽이 잘리면 `style.css`의 `#container`에 `min-width: 0 !important`가 있는지 확인하십시오.
- **여백 소멸**: `--container-padding` 변수가 `:root`에 정상적으로 정의되어 있는지 확인하십시오.
