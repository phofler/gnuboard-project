# 회사소개 모듈 복구 가이드 (HOW_TO_RECOVER_COMPANY_INTRO.md)

## 🚨 1. 개요 (Overview)
`company_intro` 플러그인을 **Premium Module Framework** 표준으로 개편한 내역입니다. 
이 변경을 통해 테마 및 언어별 설정이 자동화되었으며, 전역 라이브러리(`lib/premium_module.lib.php`)를 공유합니다.

---

## 🛠 2. 주요 변경 사항 (Key Changes)

### [라이브러리 전역화]
- `plugin/map_api/lib/premium_module.lib.php` -> `lib/premium_module.lib.php` (이동 및 공유)

### [관리자 페이지 표준화]
- **파일**: `plugin/company_intro/adm/write.php`
- **변경**: 수동 ID 생성 로직을 제거하고 `render_premium_id_ui()` 함수로 대체.
- **효과**: 테마/언어/커스텀 조합에 따른 식별코드 자동 생성이 지도의 설정과 동일한 UI로 제공됨.

### [데이터 로드 로직 개선]
- **파일**: `plugin/company_intro/lib/company.lib.php`, `plugin/company_intro/index.php`
- **변경**: `get_premium_config()`를 통한 스마트 로딩/폴백 적용.
- **효과**: 특정 언어 설정을 찾지 못할 경우 테마 기본(Default) 설정을 자동으로 찾아 안전하게 표시함.

---

## 🚨 3. 복구 방법 (Restore Procedure)

### 파일 복구
실수 발생 시 `_backups/` 폴더의 최신 회사소개 백업본을 복사하여 원본 경로에 덮어씌우십시오.

### DB 확인
회목소개 데이터는 `{g5_prefix}plugin_company_add` 테이블에 저장되어 있습니다.
- `co_id`: `테마_언어_식별명` (예: corporate_kr_intro)

---

## 💡 4. 새로운 사용 방법
새로운 회사소개 섹션을 추가할 때:
1. 관리자에서 **테마**와 **언어**를 선택하면 ID가 자동 생성됩니다.
2. 스킨을 선택하고 내용을 작성한 후 저장합니다.
3. 프론트엔드 호출 시 `{G5_PLUGIN_URL}/company_intro/index.php?co_id=식별명`으로 접속하면 현재 테마/언어에 맞는 콘텐츠를 자동으로 찾아줍니다.

---
**최종 업데이트**: 2026-03-16
**보고자**: Antigravity (AI Agent)