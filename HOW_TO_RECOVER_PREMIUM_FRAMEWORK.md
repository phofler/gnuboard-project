# 프리미엄 모듈 프레임워크 복구 및 표준 가이드 (HOW_TO_RECOVER_PREMIUM_FRAMEWORK.md)

## 🚨 1. 개요 (Overview)
본 프레임워크는 여러 플러그인에서 공통적으로 사용되는 테마별 ID 처리 및 데이터 로딩 로직을 표준화한 라이브러리입니다.

*   **핵심 파일**: `C:\gnuboard\plugin\map_api\lib\premium_module.lib.php`
*   **적용 모듈**: 지도 관리자(Map API), 카피라이트 관리자(Copyright Manager)

---

## 🛠 2. 주요 기능 및 라이브러리 (Library Functions)

### ID 생성 및 UI
- `render_premium_id_ui($id_field, $current_id, $readonly)`: 관리자 페이지에서 테마/언어/커스텀 선택을 통한 표준 ID 생성 UI를 출력합니다.
- `PremiumModule.generateId(prefix)`: (JS) 실시간 ID 조합 및 필터링 로직.

### 데이터 로딩 및 폴백 (Smart Fallback)
- `get_premium_config($table, $id_column, $requested_id)`:
    1. 요청된 ID(`$requested_id`)를 먼저 찾습니다.
    2. 없으면 현재 테마+언어 조합(`theme_en` 등)을 찾습니다.
    3. 없으면 테마 기본값(`theme`)을 찾습니다.
    4. 마지막으로 `default` 레코드를 반환합니다.

---

## 🚨 3. 긴급 복구 (1초 복구 루틴)
프레임워크 적용 후 관리자 페이지가 안 뜨거나 데이터 로딩에 실패하면 즉시 수행하십시오.

### 1단계: 프레임워크 파일 확인
`premium_module.lib.php` 파일이 삭제되었거나 인코딩이 깨졌는지 확인합니다. (반드시 BOM 없는 UTF-8이어야 함)

### 2단계: 백업본으로 복원
`C:\gnuboard\_backups/20260316_1353_Premium_Framework_Core/` 폴더의 원본 파일들을 각 플러그인 폴더에 덮어씌웁니다.

---

## 📝 4. 신규 모듈 추가 가이드
새로운 플러그인을 만들 때 다음 한 줄로 표준 ID 시스템을 탑재할 수 있습니다.

```php
include_once(G5_PLUGIN_PATH . '/map_api/lib/premium_module.lib.php');
echo render_premium_id_ui('my_field_id', $data['my_id']);
```

---
**최종 업데이트**: 2026-03-16
**보고자**: Antigravity (AI Agent)