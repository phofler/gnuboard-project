# HOW_TO_LIB_CATALOG_LINK.md

이 문서는 헤더의 '카다로그 다운로드' 링크 구현 사양서입니다.

## 1. 개요
브랜드 신뢰도를 높이고 사용자가 제품 상세 정보를 쉽게 얻을 수 있도록, 헤더 우측의 'CONTACT' 링크를 '카다로그 다운로드'로 변경했습니다.

## 2. 구현 상세 (`plugin/top_menu_manager/skins/*/menu.skin.php`)

### 1) 대상 엘리먼트
```html
<a href="<?php echo G5_DATA_URL ?>/about/catalog.pdf" class="btn-lang desktop-only" target="_blank">카다로그 다운로드</a>
```
- `G5_DATA_URL`: `C:\gnuboard\data` 경로의 URL 상수를 사용하여 경로 이식성을 확보했습니다.
- `desktop-only`: PC 화면에서만 텍스트 버튼으로 노출됩니다.
- `target="_blank"`: PDF 파일 특성상 현재 페이지 이탈을 막기 위해 새 탭에서 열리도록 설정했습니다.

### 2) 적용 스킨
- `centered`: 로고가 중앙에 있는 타입
- `basic`: 기본 타입
- `transparent`: 투명 헤더 타입

## 3. 유의 사항
- 카다로그 파일(`data/about/catalog.pdf`)이 삭제되거나 이름이 변경될 경우 링크가 깨질 수 있으므로 관리가 필요합니다.
- 파일 업데이트 시 같은 이름으로 덮어쓰기하면 링크 수정 없이 즉시 반영됩니다.
