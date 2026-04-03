# HOW_TO_RECOVER_GLOBAL_RESPONSIVE.md

이 문서는 글로벌 반응형 표준(Global Responsive Standards) 및 토큰 체계 적용 중 문제가 발생했을 때 복구하기 위한 가이드입니다.

## 1. 개요
- **마일스톤**: 2026-03-17 시스템 전역 반응형 토큰화 작업
- **핵심 목표**: 단 한 번의 토큰 수정으로 모든 스킨의 반응형 대응이 가능하도록 구조화
- **백업 위치**: C:\gnuboard\_backups/20260317_191202_global_responsive_audit/

## 2. 복구 절차 (Emergency)

특정 스킨의 레이아웃이 깨지거나 전체 반응형이 무너졌을 경우 아래 명령어로 원복하십시오.

### 전역 스타일 복구 (Global Token Reset)
`powershell
$backupDir = "_backups/20260317_191202_global_responsive_audit/theme_kukdong_panel"
Copy-Item "$backupDir/style.css" "theme/kukdong_panel/style.css" -Force
`

### 개별 스킨 복구 (예: Fade)
`powershell
$backupDir = "_backups/20260317_191202_global_responsive_audit/skins_fade"
Copy-Item "$backupDir/style.css" "plugin/main_image_manager/skins/fade/style.css" -Force
`

## 3. 체크리스트 (Issue Resolution)
- **BOM 오염**: 수정 후 상단에 공백이 생기면 PowerShell UTF8Encoding \False 방식으로 재저장하십시오.
- **이미지 쏠림 현상**: 모바일에서 이미지가 한쪽으로 치우치면 style.css의 .img-center-focus 클래스 설정을 확인하십시오.
- **폰트 크기 불균형**: clamp() 함수의 최소/최대 인자값을 전역 토큰에서 조절하여 일괄 반영하십시오.