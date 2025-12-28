# [내일 작업 계획] 메인 이미지 관리 플러그인 개발

## 1. 개요 (Overview)
- **목표**: 하드코딩된 메인 페이지 슬라이더를 관리자 페이지에서 제어 가능한 시스템으로 변경.
- **핵심 기능**:
    1.  **3가지 스타일 프리셋 (A, B, C)** 제공.
    2.  관리자가 **"현재 적용할 스타일"** 선택 가능 (Radio Button).
    3.  각 스타일별로 **최대 12개**의 이미지 슬라이드 등록 가능.

## 2. 데이터베이스 구조 (Database)
- **테이블명**: `g5_plugin_main_image`
- **컬럼 구조**:
    | 컬럼명 | 타입 | 설명 |
    | :--- | :--- | :--- |
    | `mi_id` | INT (PK) | 고유 ID |
    | `mi_style` | CHAR(1) | 스타일 구분 ('A', 'B', 'C') |
    | `mi_sort` | INT | 정렬 순서 (1 ~ 12) |
    | `mi_image` | VARCHAR | 이미지 파일 경로 |
    | `mi_title` | VARCHAR | 메인 타이틀 (예: Timeless Luxury) |
    | `mi_desc` | VARCHAR | 서브 텍스트 (예: Modern Motion) |
    | `mi_link` | VARCHAR | 이동 링크 URL |
    | `mi_target` | VARCHAR | 링크 타겟 (_blank 등) |

## 3. 구현할 파일 목록 (Files to Create)

### A. 관리자 목록 및 설정 페이지
- **파일**: `plugin/main_image_manager/adm/list.php`
- **기능**:
    - [Style A] [Style B] [Style C] 탭 메뉴 구성.
    - 상단에 **"현재 활성 스타일 선택"** 라디오 버튼 배치.
    - 각 탭 내부에 12개의 입력 폼(이미지, 텍스트, 링크) 나열.
    - `enctype="multipart/form-data"` 필수.

### B. 데이터 저장 처리 페이지
- **파일**: `plugin/main_image_manager/adm/update.php`
- **기능**:
    - 이미지 파일 업로드 처리 (`data/main_visual` 폴더).
    - DB insert/update 처리.
    - 활성 스타일 설정 저장 (`g5_config` 테이블의 여분 필드 또는 별도 설정 파일 파일 사용).

### C. 프론트엔드 출력 라이브러리
- **파일**: `plugin/main_image_manager/lib/main.lib.php`
- **함수**:
    - `get_active_main_style()`: 현재 A, B, C 중 무엇이 선택되었는지 반환.
    - `get_main_slides($style)`: 해당 스타일의 이미지 리스트 반환.
    - `display_main_visual()`: `index.php`의 HTML 코드를 대체할 PHP 함수.

## 4. 수정할 파일 (Files to Modify)

### A. 관리자 메뉴 등록
- **파일**: `adm/admin.menu800_theme.php`
- **내용**: `800180` 코드로 '메인이미지관리' 메뉴 추가.

### B. 메인 페이지 적용
- **파일**: `theme/corporate/index.php`
- **내용**:
    - 기존 하드코딩된 `<div class="hero-section">...</div>` 부분을 주석 처리.
    - `display_main_visual()` 함수 호출로 교체하여 DB 데이터 연동.

## 5. 작업 순서 (Action Items)
1.  [ ] `plugin/main_image_manager` 폴더 생성.
2.  [ ] `adm/list.php` 작성 (테이블 자동 생성 로직 포함).
3.  [ ] `adm/update.php` 작성 (업로드 및 저장 로직).
4.  [ ] `lib/main.lib.php` 작성 (출력 로직).
5.  [ ] `adm/admin.menu800_theme.php` 메뉴 연결.
6.  [ ] 관리자 페이지 접속하여 테이블 생성 확인 및 데이터(이미지) 등록 테스트.
7.  [ ] `theme/corporate/index.php` 수정하여 프론트엔드 연동.
8.  [ ] 스타일 A <-> B 전환 테스트.

---
**작성일**: 2025-12-19
**상태**: 대기 (내일 바로 시작 가능)
