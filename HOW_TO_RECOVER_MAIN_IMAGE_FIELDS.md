# HOW TO RECOVER: Main Image Manager Field Expansion

This guide provides instructions to revert the addition of Tag, Subtitle, and Button Text fields to the Main Image Manager.

## 1. Backup Location
Original files are backed up at:
`C:\gnuboard\_backups\20260315_1052_Main_Image_Fields/`

## 2. Recovery Script (PowerShell)

```powershell
$backupDir = "C:\gnuboard\_backups\20260315_1052_Main_Image_Fields"

# Define mappings (Prefix_Filename to Actual Path)
$mappings = @{
    "write.php"            = "C:\gnuboard\plugin\main_image_manager\adm\write.php"
    "ajax.add_item.php"    = "C:\gnuboard\plugin\main_image_manager\adm\ajax.add_item.php"
    "update.php"           = "C:\gnuboard\plugin\main_image_manager\adm\update.php"
    "ultimate_hero_main.skin.php" = "C:\gnuboard\plugin\main_image_manager\skins\ultimate_hero\main.skin.php"
    "corporate_hero_main.skin.php" = "C:\gnuboard\plugin\main_image_manager\skins\corporate_hero\main.skin.php"
    "fade_main.skin.php"       = "C:\gnuboard\plugin\main_image_manager\skins\fade\main.skin.php"
}

# Restore files
foreach ($name in $mappings.Keys) {
    $src = Join-Path $backupDir $name
    $dest = $mappings[$name]
    if (Test-Path $src) {
        Copy-Item $src $dest -Force
    }
}
```

## 3. Database Reversal
If you need to remove the newly added columns from the slide items:
```sql
ALTER TABLE g5_plugin_main_image_add DROP COLUMN mi_tag;
ALTER TABLE g5_plugin_main_image_add DROP COLUMN mi_subtitle;
ALTER TABLE g5_plugin_main_image_add DROP COLUMN mi_btn_text;
```

## 4. Troubleshooting
- If the admin page or skins show an error, check for BOM in PHP files. The PowerShell script creates UTF-8 files without BOM.
