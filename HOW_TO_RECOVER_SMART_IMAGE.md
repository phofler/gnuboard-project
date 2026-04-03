# HOW_TO_RECOVER_SMART_IMAGE.md

작성일: 2026-03-17

## 1. 목적
본 문서는 'Smart Image 라이브러리 고도화 및 공통화' 작업 중 문제가 발생했을 때, 1초 만에 최적의 상태로 복구하기 위한 기술 지침서입니다.

## 2. 복구 포인트 (Backup Point)
- **위치**: C:\gnuboard\_backups\20260317_1324_Smart_Image_Standardization
- **원본 파일 매핑**:
  - image_manager.php -> plugin\company_intro\adm\image_manager.php
  - ci_write.php -> plugin\company_intro\adm\write.php
  - mc_write.php -> plugin\main_content_manager\adm\write.php

## 3. 긴급 복구 명령 (Restore Command)
문제가 발생하면 다음 PowerShell 명령을 실행하십시오.
`powershell
copy C:\gnuboard\_backups\20260317_1324_Smart_Image_Standardization\image_manager.php C:\gnuboard\plugin\company_intro\adm\image_manager.php
copy C:\gnuboard\_backups\20260317_1324_Smart_Image_Standardization\ci_write.php C:\gnuboard\plugin\company_intro\adm\write.php
copy C:\gnuboard\_backups\20260317_1324_Smart_Image_Standardization\mc_write.php C:\gnuboard\plugin\main_content_manager\adm\write.php
`

## 4. 주요 체크리스트 (Verification)
- [ ] Unsplash 팝업이 정상적으로 뜨는가?
- [ ] 이미지 비율 감지(Smart Crop)가 에디터 내부 이미지에 작동하는가?
- [ ] 이미지 선택 후 에디터 본문에 정상적으로 삽입/교체되는가?
- [ ] AJAX 응답 파손(BOM 이슈)이 없는가?
