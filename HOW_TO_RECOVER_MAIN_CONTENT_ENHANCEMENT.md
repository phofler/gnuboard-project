# HOW TO RECOVER: Main Content Item Enhancement

If any error occurs during the enhancement of the Main Content Manager (e.g., UI breakage, DB errors, encoding issues), follow these steps to restore the system to its previous stable state.

## 1. File Restoration

### Backup Location
`C:/gnuboard/_backups/20260315_1532_Main_Content_Enhancement/`

### Restoration Command (PowerShell)
```powershell
$backupDir = "C:/gnuboard/_backups/20260315_1532_Main_Content_Enhancement"
$targetBase = "C:/gnuboard"

# Restore all files recursively
Get-ChildItem -Path $backupDir -File -Recurse | ForEach-Object {
    $relative = $_.FullName.Substring($backupDir.Length + 1)
    $dest = Join-Path $targetBase $relative
    Copy-Item $_.FullName -Destination $dest -Force
}
```

## 2. Database Restoration

If the column additions cause SQL errors, you can remove them using:

```sql
ALTER TABLE g5_plugin_main_content 
DROP COLUMN mc_tag,
DROP COLUMN mc_subtitle,
DROP COLUMN mc_link_text;
```

## 3. Encoding Check
Ensure all PHP files are **UTF-8 No-BOM**. If you see garbage characters (BOM), use the provided PowerShell save script:

```powershell
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText($file, $content, $utf8NoBom)
```

## 4. Known Issues
- **AJAX Failure**: Usually caused by BOM in `ajax.add_item.php`. Check encoding immediately.
- **Parsing Error**: Check for missing semicolons in `write.php` after editor integration.
