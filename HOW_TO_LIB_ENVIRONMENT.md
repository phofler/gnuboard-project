# HOW TO LIB ENVIRONMENT (서버 이전 및 환경 표준화)

본 문서는 로컬 개발 환경(`localhost`)과 실제 웹 서버(`FTP`) 간의 데이터 동기화 및 경로 표준화 지침을 담고 있습니다.

## 1. 아키텍처 원칙 (Environment Agnostic)
시스템은 어느 서버 환경에 설치되더라도 별도의 코드 수정 없이 작동해야 합니다. 이를 위해 다음과 같은 원칙을 준수합니다.

*   **동적 경로 생성**: DB에는 절대 주소(`http://...`)를 저장하지 않고, 파일명 또는 상대 경로만 저장합니다.
*   **런타임 결합**: 출력 시점에 `G5_URL` 또는 `G5_DATA_URL`을 동적으로 결합하여 최종 URL을 생성합니다.

## 2. 주요 기능 및 복구 방법

### A. 경로 자동 정규화 (get_main_content_list)
이미 `localhost` 주소가 DB에 들어있더라도, 라이브러리(`main_content.lib.php`)가 이를 실시간으로 감지하여 현재 서버 주소로 자동 변환하여 출력합니다.

### B. 일괄 정리 도구 (sync_db_paths.php)
서버 이전 직후 DB 내의 지엽적인 주소들을 한 번에 청소하고 싶을 때 사용합니다.
1. `sync_db_paths.php` 파일을 서버 루트에 업로드합니다.
2. 관리자 로그인 후 `웹주소/sync_db_paths.php`를 브라우저에서 실행합니다.
3. 작업 완료 후 반드시 해당 파일을 **삭제**하십시오.

## 3. 서버 이전(Migration) 체크리스트
1.  **파일 업로드**: `theme/`, `plugin/`, `data/common_assets/` 폴더를 전부 업로드합니다.
2.  **데이터베이스**: 로컬 DB를 백업(`mysqldump`)하여 서버에 복원합니다.
3.  **브랜딩 설정**: 관리자 페이지에서 사이트 제목 및 로고 설정을 서버 환경에 맞춰 한 번 더 확인합니다.
4.  **BOM 확인**: PHP 파일 수정 시 반드시 **BOM 없는 UTF-8** 형식을 유지하십시오.

## 4. 관련 파일
*   경로 관리 라이브러리: `plugin/main_content_manager/lib/main_content.lib.php`
*   업로드 처리기: `plugin/main_content_manager/adm/ajax.upload.php`
*   이미지 관리자 JS: `js/image_smart_manager.js`
