# How to Recover: Skin Selection UI Modularization

If you encounter issues after the skin selection modularization (e.g., UI breakage or saving failure), follow these steps to restore the working state.

## 1. Files modified
- `C:\gnuboard\extend\project_ui.extend.php` (Common UI library)
- `C:\gnuboard\plugin\top_menu_manager\lib.php` (Plugin logic)
- `C:\gnuboard\plugin\top_menu_manager\write.php` (Admin UI)
- `C:\gnuboard\plugin\main_image_manager\adm\write.php` (Admin UI)

## 2. Restoration from Backup
Original files are stored in:
`C:\gnuboard\_backups\20260315_1452_Skin_Modularization\`

Run this PowerShell command to restore:
```powershell
$backupPath = "C:\gnuboard\_backups\20260315_1452_Skin_Modularization"
Copy-Item "$backupPath\project_ui.extend.php" "C:\gnuboard\extend\project_ui.extend.php" -Force
Copy-Item "$backupPath\lib.php" "C:\gnuboard\plugin\top_menu_manager\lib.php" -Force
Copy-Item "$backupPath\write.php" "C:\gnuboard\plugin\top_menu_manager\write.php" -Force
Copy-Item "$backupPath\write.php" "C:\gnuboard\plugin\main_image_manager\adm\write.php" -Force
```

## 3. Encoding Check (Rule 7)
If Korean characters are broken, verify that files are saved as **UTF-8 No BOM**.
Use PowerShell to re-save:
```powershell
$file = "Target File Path"
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText($file, [System.IO.File]::ReadAllText($file), $utf8NoBom)
```
