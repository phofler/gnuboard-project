# HOW_TO_RECOVER_RESPONSIVENESS.md

이 문서는 반응형(Responsiveness) 및 제품 이미지 중앙 축소(Center-focused Scaling) 수정 작업 중 문제가 발생했을 때 1초 만에 복구하기 위한 지침입니다.

## 1. 개요
- **최종 수정일**: 2026-03-17
- **대상 기능**: 
  - 메인 이미지(Hero) 및 메인 컨텐츠 반응형 개선
  - 메인 이미지 폭 축소 시 중앙 정렬 유지 (Center-focused Scaling)
- **수정 파일**:
  - head.sub.php (뷰포트 태그)
  - plugin/main_image_manager/skins/fade/style.css (Hero 스킨)
  - plugin/main_image_manager/skins/ultimate_hero/style.css (Ultimate Hero 스킨)
  - plugin/main_content_manager/skins/product_intro/style.css (메인 컨텐츠 스킨)

## 2. 비상 복구 방법 (Emergency Recovery)

문제가 발생하면 Rule 0에 따라 생성된 백업 폴더에서 파일을 원복하십시오.

### 백업 위치 확인
- **1차 (반응형)**: C:\gnuboard\_backups/20260317_184744_responsive_fix/
- **2차 (중앙 축소 - Fade)**: C:\gnuboard\_backups/20260317_190448_center_scaling_fix/
- **3차 (중앙 축소 - Ultimate)**: C:\gnuboard\_backups/20260317_190935_ultimate_hero_fix/

### 복구 명령어 (PowerShell)
`powershell
# Ultimate Hero 복구
$backupDir = "_backups/20260317_190935_ultimate_hero_fix"
Copy-Item "$backupDir/style.css" "plugin/main_image_manager/skins/ultimate_hero/style.css" -Force

# Fade 스킨 복구
# $backupDir = "_backups/20260317_190448_center_scaling_fix"
# Copy-Item "$backupDir/fade_style.css" "plugin/main_image_manager/skins/fade/style.css" -Force
`

## 3. 주요 체크리스트
- **BOM 오염 확인**: 수정 후 AJAX나 메인 페이지 상단에 원치 않는 공백이 생기면 BOM 없는 UTF-8로 재저장하십시오.
- **뷰포트 확인**: 브라우저 F12 개발자 도구의 Device Mode(Ctrl+Shift+M)에서 모든 기기 사이즈를 테스트하십시오.
- **이미지 중앙 정렬**: 폭이 좁은 모바일(320px~480px)에서 메인 이미지의 핵심 피사체가 중앙에 위치하는지 확인하십시오.