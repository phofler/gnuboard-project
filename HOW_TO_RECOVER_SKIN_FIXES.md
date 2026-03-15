# HOW TO RECOVER: Smooth Fade and Basic Skin Fixes

This guide provides instructions to revert the addition of the new slide fields to the "Smooth Fade" (full) and "Basic" (basic) skins, and the preview logic fix.

## 1. Backup Location
Original files are backed up at:
`C:\gnuboard\_backups\20260315_1127_Skin_Fixes/`

## 2. Recovery Script (PowerShell)

```powershell
$backupDir = "C:\gnuboard\_backups\20260315_1127_Skin_Fixes"

# Define mappings (Prefix_Filename to Actual Path)
$mappings = @{
    "full_main.skin.php"       = "C:\gnuboard\plugin\main_image_manager\skins\full\main.skin.php"
    "full_style.css"           = "C:\gnuboard\plugin\main_image_manager\skins\full\style.css"
    "basic_main.skin.php"      = "C:\gnuboard\plugin\main_image_manager\skins\basic\main.skin.php"
    "basic_style.css"          = "C:\gnuboard\plugin\main_image_manager\skins\basic\style.css"
    "preview_style.php"        = "C:\gnuboard\plugin\main_image_manager\adm\preview_style.php"
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

## 3. Troubleshooting
- If the admin page or skins show an error after rollback, use the provided PowerShell script which preserves UTF-8 without BOM encoding to prevent Ghost Saves.
