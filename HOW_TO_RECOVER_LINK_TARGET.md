# HOW TO RECOVER: Link Target (New Window) Option

This guide provides instructions to revert the addition of the "New Window" (`_blank`) target option to the Main Image Manager.

## 1. Backup Location
Original files are backed up at:
`C:\gnuboard\_backups\20260315_1113_Link_Target_Option/`

## 2. Recovery Script (PowerShell)

```powershell
$backupDir = "C:\gnuboard\_backups\20260315_1113_Link_Target_Option"

# Define mappings (Prefix_Filename to Actual Path)
$mappings = @{
    "write.php"            = "C:\gnuboard\plugin\main_image_manager\adm\write.php"
    "ajax.add_item.php"    = "C:\gnuboard\plugin\main_image_manager\adm\ajax.add_item.php"
    "update.php"           = "C:\gnuboard\plugin\main_image_manager\adm\update.php"
    "ultimate_hero_main.skin.php" = "C:\gnuboard\plugin\main_image_manager\skins\ultimate_hero\main.skin.php"
    "corporate_hero_main.skin.php" = "C:\gnuboard\plugin\main_image_manager\skins\corporate_hero\main.skin.php"
    "fade_main.skin.php"       = "C:\gnuboard\plugin\main_image_manager\skins\fade\main.skin.php"
    "basic_main.skin.php"      = "C:\gnuboard\plugin\main_image_manager\skins\basic\main.skin.php"
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
No database schema changes were made for this feature, as the `mi_target` column already existed.

## 4. Troubleshooting
- If the admin page or skins show an error after rollback, use the provided PowerShell script which preserves UTF-8 without BOM encoding to prevent Ghost Saves.
