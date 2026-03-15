# HOW TO RECOVER: Overlay Intensity Fix

This guide provides instructions to revert the fix applied to "Dark Overlay Intensity".

## 1. Backup Location
Original files are backed up at:
`C:\gnuboard\_backups\20260315_1152_Overlay_Intensity_Fix/`

## 2. Recovery Script (PowerShell)

```powershell
$backupDir = "C:\gnuboard\_backups\20260315_1152_Overlay_Intensity_Fix"

# Define mappings (Prefix_Filename to Actual Path)
$mappings = @{
    "ultimate_hero_main.skin.php" = "C:\gnuboard\plugin\main_image_manager\skins\ultimate_hero\main.skin.php"
    "ultimate_hero_style.css" = "C:\gnuboard\plugin\main_image_manager\skins\ultimate_hero\style.css"
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
