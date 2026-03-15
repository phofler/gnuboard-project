# HOW TO RECOVER: Premium Hero Platforming

This guide provides instructions to revert the Premium Hero expansion and platforming changes.

## 1. Backup Location
Original files are backed up at:
`C:\gnuboard\_backups\20260314_0008_Premium_Hero_Platforming/`

## 2. Recovery Script (PowerShell)

```powershell
$backupDir = "C:\gnuboard\_backups\20260314_0008_Premium_Hero_Platforming"

# Define mappings (Prefix_Filename to Actual Path)
$mappings = @{
    "adm_write.php"            = "C:\gnuboard\plugin\main_image_manager\adm\write.php"
    "adm_update.php"           = "C:\gnuboard\plugin\main_image_manager\adm\update.php"
    "extend_project_ui.extend.php" = "C:\gnuboard\extend\project_ui.extend.php"
    "basic_main.skin.php"      = "C:\gnuboard\plugin\main_image_manager\skins\basic\main.skin.php"
    "basic_style.css"          = "C:\gnuboard\plugin\main_image_manager\skins\basic\style.css"
    "corporate_hero_main.skin.php" = "C:\gnuboard\plugin\main_image_manager\skins\corporate_hero\main.skin.php"
    "corporate_hero_style.css"     = "C:\gnuboard\plugin\main_image_manager\skins\corporate_hero\style.css"
    "fade_main.skin.php"       = "C:\gnuboard\plugin\main_image_manager\skins\fade\main.skin.php"
    "fade_style.css"           = "C:\gnuboard\plugin\main_image_manager\skins\fade\style.css"
    "full_main.skin.php"       = "C:\gnuboard\plugin\main_image_manager\skins\full\main.skin.php"
    "full_style.css"           = "C:\gnuboard\plugin\main_image_manager\skins\full\style.css"
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
If you need to remove the new columns:
```sql
ALTER TABLE g5_plugin_main_image_config DROP COLUMN mi_effect;
ALTER TABLE g5_plugin_main_image_config DROP COLUMN mi_overlay;
```

## 4. Troubleshooting
- If the admin page shows an error, check for BOM in PHP files.
- If effects don't appear, clear the browser cache.
