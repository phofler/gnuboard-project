# Pro Menu Manager 로직 복구 가이드 (HOW_TO_RECOVER_PRO_MENU_LOGIC)

## 1. 개요
Pro Menu Manager에서 하위 메뉴를 10개 이상 추가할 경우, 메뉴 코드(`ma_code`)가 5자리(예: `20100`)로 생성되어 계층 구조가 파괴되고 정렬이 최하단(부자재 이후)으로 밀리는 버그가 발생했습니다. 이를 수정하기 위해 코드 생성 로직을 1단위 증가로 변경하고 알파벳 확장을 지원하도록 조치했습니다.

## 2. 복구 방법 (파일)
문제가 발생할 경우 `_backups/20260317_1145_ProMenu_Logic_Fix/` 폴더에서 다음 파일들을 원래 위치로 복사하십시오.
- `plugin/pro_menu_manager/update.php`: 메뉴 저장 및 코드 생성 로직
- `plugin/pro_menu_manager/lib.php`: 메뉴 목록 조회 로직

## 3. 복구 방법 (DB)
잘못 생성된 5자리 코드를 정상적인 4자리 코드로 강제 수정하는 쿼리입니다.
```sql
-- '지붕' 메뉴가 20100으로 생성된 경우 2091로 수정
UPDATE g5_write_menu_pdc SET ma_code = '2091' WHERE ma_code = '20100';
-- 다른 언어 테이블도 동일하게 적용
UPDATE g5_write_menu_pdc_en SET ma_code = '2091' WHERE ma_code = '20100';
UPDATE g5_write_menu_pdc_jp SET ma_code = '2091' WHERE ma_code = '20100';
UPDATE g5_write_menu_pdc_cn SET ma_code = '2091' WHERE ma_code = '20100';
```

## 4. 로직 설명 (수정된 사항)
- **이전**: `$next_val = intval($last_two) + 10;` (90 다음 100이 되어 자릿수 오버플로 발생)
- **변경**: `$next_val = intval($last_two) + 1;` (10, 11, 12... 99까지 안전하게 지원)
- **확장**: 99를 초과할 경우 `a0, a1...`와 같은 알바벳 코드를 생성하여 2자리 단위를 영구적으로 유지합니다.

## 5. 주의 사항
- 메뉴를 새로 저장하면 `update.php`가 전체 데이터를 삭제 후 재삽입(`DELETE -> INSERT`)하므로, 코드가 꼬였을 때는 관리자 페이지에서 다시 한번 '저장' 버튼을 누르면 새로운 로직으로 코드가 재생성됩니다.
