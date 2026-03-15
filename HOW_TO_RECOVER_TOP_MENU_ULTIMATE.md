# 상단 메뉴 설정 관리 회복 지침서 (Ultimate Fix)

본 문서는 상단 메뉴 설정 관리 프로그램의 DB 보강 및 로직 개편 후, 문제 발생 시 즉시 복구하기 위한 가이드입니다.

## 1. 시스템 정보
- **플러그인 위치**: `plugin/top_menu_manager/`
- **주요 파일**: 
    - `write.php`: 설정 추가/수정 UI (수정 모드 데이터 복원 로직 포함)
    - `update.php`: DB 저장 및 파일 관리 (ID 고정 및 세부 필드 저장)
- **DB 테이블**: `g5_plugin_top_menu_config`
    - 추가된 컬럼: `tm_theme`, `tm_lang`, `tm_custom`

## 2. 발생 가능한 문제 및 해결책

### Q1. 수정 페이지에 들어갔는데 테마/언어가 선택되어 있지 않아요.
- **원인**: DB의 `tm_theme`, `tm_lang` 컬럼이 비어있음.
- **해결**: 아래 SQL을 실행하여 강제로 데이터를 매칭시키거나, `write.php`의 하위 호환성 파싱 로직이 제대로 작동하는지 확인하세요.
```sql
UPDATE g5_plugin_top_menu_config SET tm_theme='kukdong_panel', tm_lang='kr' WHERE tm_id='kukdong_panel';
```

### Q2. 식별코드(ID)가 중복 생성되거나 이상해요. (예: kukdong_panel_panel)
- **원인**: `write.php`의 `generate_tm_id` JS 함수 로직 충실도 문제.
- **해결**: 최신 버전의 `write.php`로 교체하세요. (중복 단어 체크 로직 포함됨)

### Q3. 한글이 깨져 보이거나 레이아웃이 밀려요.
- **원인**: 파일 저장 시 BOM(Byte Order Mark)이 포함됨.
- **해결**: Rule 7 수칙에 따라 PowerShell로 다시 저장하세요.
```powershell
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText('파일경로', '소스코드', $utf8NoBom)
```

## 3. 백업 데이터 위치
- 작업 전 원본 백업: `_backups/[날짜_시간]_TopMenu_Ultimate_Fix/`