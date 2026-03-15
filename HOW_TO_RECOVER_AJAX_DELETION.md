# HOW TO RECOVER: AJAX Real-time Image Deletion

이 문서는 AJAX 기반 실시간 이미지 삭제 기능 작업 중 오류 발생 시 즉시 복구하기 위한 지침입니다.

## 1. 파일 복구 (File Restoration)

### 백업 위치
`C:/gnuboard/_backups/20260315_1628_AJAX_Image_Deletion`

### 복구 명령 (PowerShell)
```powershell
$backupDir = "C:/gnuboard/_backups/20260315_1628_AJAX_Image_Deletion"
Copy-Item "$backupDir/write.php" -Destination "C:/gnuboard/plugin/main_content_manager/adm/write.php" -Force
Copy-Item "$backupDir/ajax.add_item.php" -Destination "C:/gnuboard/plugin/main_content_manager/adm/ajax.add_item.php" -Force
# 신규 파일 삭제
Remove-Item "C:/gnuboard/plugin/main_content_manager/adm/ajax.delete_image.php" -ErrorAction SilentlyContinue
```

## 2. 로직 설면
- `ajax.delete_image.php`: DB에서 특정 아이템의 `mc_image` 값을즉시 비우는 기능.
- `write.php`: 삭제 버튼 클릭 시 AJAX 요청을 보내고 성공 시 UI를 갱신함.

## 3. 인코딩 및 보안
- 모든 파일은 **UTF-8 No-BOM** 형식입니다.
- AJAX 응답이 JSON이므로 파일 상단에 출력(echo, BOM 등)이 섞이지 않도록 주의하십시오.
- `SyntaxError` 발생 시 파일 맨 앞의 BOM 존재 여부를 확인하십시오.
