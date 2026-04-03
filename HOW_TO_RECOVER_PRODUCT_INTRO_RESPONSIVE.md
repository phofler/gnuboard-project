# HOW TO RECOVER: Product Intro Responsive Refactor

이 문서는 `product_intro` 스킨의 반응형 리팩토링 중 문제가 발생했을 때 1초 만에 복구하기 위한 지침입니다.

## 1. 긴급 복구 (Rollback)
작업 중 레이아웃이 깨지거나 파일이 손상된 경우, 아래 백업 파일을 복사하여 원본 위치에 덮어씌우십시오.

**백업 위치**: `c:\gnuboard\_backups\20260317_2026_product_intro_responsive\`
- `style.css.bak` → `plugin/main_content_manager/skins/product_intro/style.css`
- `main.skin.php.bak` → `plugin/main_content_manager/skins/product_intro/main.skin.php`

## 2. 주요 체크포인트
- **BOM 오염 확인**: 수정 후 화면에 `∩╗┐` 같은 이상한 문자가 보이거나 AJAX 레이어가 안 뜨면 반드시 UTF-8 (BOM 없음)로 다시 저장하십시오.
- **클래스명 충돌**: 템플릿은 `product-row` (하이픈), CSS는 `product_row` (언더바)를 혼용하지 않도록 리팩토링 단계에서 하이픈(`-`)으로 통일했습니다.
- **모바일 오버플로**: 화면이 옆으로 밀릴 경우 `html, body { overflow-x: hidden !important; }` 설정이 테마 `style.css`에 살아있는지 확인하십시오.

## 3. 복구 명령어 (PowerShell)
```powershell
$backupDir = "c:/gnuboard/_backups/20260317_2026_product_intro_responsive"
$targetSkin = "c:/gnuboard/plugin/main_content_manager/skins/product_intro"
Copy-Item "$backupDir/style.css.bak" "$targetSkin/style.css" -Force
Copy-Item "$backupDir/main.skin.php.bak" "$targetSkin/main.skin.php" -Force
```