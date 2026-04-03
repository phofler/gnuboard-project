# HOW TO RECOVER: Breadcrumb Standardization

If the Breadcrumb standardization causes issues (UI broken, AJAX errors, or encoding corruption), use this guide to restore the system within 1 second.

## 1. Backup Location
- **Path**: `c:\gnuboard\_backups\20260316_1955_Breadcrumb_Standardization`
- **Date**: 2026-03-16 19:55

## 2. Recovery Commands (PowerShell)

Restore all files:
```powershell
$backupPath = "c:\gnuboard\_backups\20260316_1955_Breadcrumb_Standardization"
cp "$backupPath\list.php" "c:\gnuboard\plugin\sub_design\adm\list.php" -Force
cp "$backupPath\write.php" "c:\gnuboard\plugin\sub_design\adm\write.php" -Force
cp "$backupPath\update.php" "c:\gnuboard\plugin\sub_design\adm\update.php" -Force
cp "$backupPath\project_ui.extend.php" "c:\gnuboard\extend\project_ui.extend.php" -Force
cp "$backupPath\design.lib.php" "c:\gnuboard\plugin\sub_design\lib\design.lib.php" -Force
```

## 3. Database Recovery
If the new columns `sd_breadcrumb` or `sd_breadcrumb_skin` cause SQL issues, remove them:
```sql
ALTER TABLE g5_plugin_sub_design_groups DROP COLUMN sd_breadcrumb;
ALTER TABLE g5_plugin_sub_design_groups DROP COLUMN sd_breadcrumb_skin;
```

## 4. Troubleshooting
- **Ajax Errors**: Check if `project_ui.extend.php` has a BOM. Re-save it with `New-Object System.Text.UTF8Encoding $false`.
- **Layout Broken**: Ensure `design.lib.php` correctly handles the new breadcrumb display logic.
