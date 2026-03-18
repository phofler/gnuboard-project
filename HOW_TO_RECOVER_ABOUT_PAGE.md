# HOW_TO_RECOVER_ABOUT_PAGE.md

이 문서는 CEO 인사말 페이지(`main/sub/about.html`) 작업 중 오류가 발생했을 때 즉시 복구하기 위한 가이드입니다.

## 1. 개요
- **작업 일시**: 2026-03-18
- **대상 파일**: `C:\gnuboard\main\sub\about.html`
- **백업 위치**: `C:\gnuboard\_backups\20260318_0956_about_page_creation\`

## 2. 복구 절차
새로 생성된 파일이므로, 페이지가 깨지거나 잘못 수정되었을 경우 아래 명령어로 파일을 재생성하거나 백업본으로 교체하십시오.

### 백업본으로 복전 (PowerShell)
```powershell
chcp 65001
$backupFile = "C:\gnuboard\_backups\20260318_0956_about_page_creation\about.html"
$target = "C:\gnuboard\main\sub\about.html"
if (Test-Path $backupFile) {
    Copy-Item $backupFile $target -Force
}
```

## 3. 주의 사항
- **BOM 체크**: 수정 시 반드시 BOM 없는 UTF-8 형식을 유지하십시오. BOM이 포함되면 레이아웃 상단에 불필요한 공백이 생길 수 있습니다.
- **반응형**: AOS(Animation on Scroll) 라이브러리 모사 스크립트가 포함되어 있으므로, 하단 `<script>` 영역 삭제 시 애니메이션이 작동하지 않습니다.
- **이미지**: 현재 이미지는 비주얼 박스(CSS Gradient)로 처리되어 있습니다. 실제 이미지 교체 시 `.ceo-visual-box` 클래스의 `background` 속성을 수정하십시오.
