# HOW_TO_RECOVER_HEADER_CENTERING.md

이 문서는 헤더 로고 중앙 정렬 작업 중 문제가 발생했을 때 복구하기 위한 지침입니다.

## 1. 개요
- **마일스톤**: 2026-03-17 헤더 로고 모바일 중앙 정렬 표준화
- **백업 위치**: C:\gnuboard\_backups/20260317_193015_header_logo_centering/

## 2. 복구 방법
레이아웃이 깨지거나 로고가 사라진 경우 다음 명령어를 실행하십시오.
`powershell
Copy-Item "_backups/20260317_193015_header_logo_centering/style.css" "plugin/top_menu_manager/skins/transparent/style.css" -Force
`

## 3. 주요 이슈 해결
- **겹침 현상**: 우측 버튼이 너무 많아 로고를 가리는 경우, ightBtn의 gap을 줄이거나 일부 버튼을 숨기십시오.
- **클릭 불가**: 로고 영역이 메뉴 버튼을 덮어 클릭이 안 되면 로고의 z-index를 낮추고 버튼의 z-index를 높이십시오.