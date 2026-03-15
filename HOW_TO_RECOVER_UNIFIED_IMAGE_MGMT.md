# HOW TO RECOVER: Unified Image Management Library

이 문서는 통합 이미지 관리 라이브러리 및 실시간 삭제 기능 작업 중 오류 발생 시 즉시 복구하기 위한 지침입니다.

## 1. 파일 복구 (File Restoration)

### 백업 위치
`C:/gnuboard/_backups/20260315_1636_Unified_Image_Library`

### 복구 명령 (PowerShell)
```powershell
$backupDir = "C:/gnuboard/_backups/20260315_1636_Unified_Image_Library"
Copy-Item "$backupDir/write.php" -Destination "C:/gnuboard/plugin/main_image_manager/adm/write.php" -Force
Copy-Item "$backupDir/ajax.add_item.php" -Destination "C:/gnuboard/plugin/main_image_manager/adm/ajax.add_item.php" -Force
Copy-Item "$backupDir/write.php" -Destination "C:/gnuboard/plugin/main_content_manager/adm/write.php" -Force

# 신규 라이브러리 및 엔드포인트 삭제
Remove-Item "C:/gnuboard/extend/project_image.extend.php" -ErrorAction SilentlyContinue
Remove-Item "C:/gnuboard/adm/ajax.unified_image_delete.php" -ErrorAction SilentlyContinue
```

## 2. 로직 설명
- `extend/project_image.extend.php`: 여러 플러그인의 이미지를 일괄 관리하는 공통 함수 정의.
- `adm/ajax.unified_image_delete.php`: 중앙 집중식 AJAX 이미지 삭제 서버.

## 3. 주의사항
- **인코딩**: 모든 파일은 **UTF-8 No-BOM** 형식입니다.
- **BOM 오염**: AJAX 응답 파손 방지를 위해 파일 맨 앞의 BOM을 철저히 제거하십시오.
