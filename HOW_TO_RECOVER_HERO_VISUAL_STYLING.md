# HOW TO RECOVER: Hero Visual Styling

This guide provides instructions to revert the Hero Visual Styling and Common UI Refinement changes.

## 1. Backup Location
Original files are backed up at:
`C:\gnuboard\_backups\20260313_2329_Hero_Visual_Styling/`

## 2. Recovery Script (PowerShell)

```powershell
$backupDir = "C:\gnuboard\_backups\20260313_2329_Hero_Visual_Styling"

# Define mappings
$mappings = @{
    "project_ui.extend.php"           = "C:\gnuboard\extend\project_ui.extend.php"
    "skin_ultimate_hero_main.skin.php" = "C:\gnuboard\plugin\main_image_manager\skins\ultimate_hero\main.skin.php"
    "skin_ultimate_hero_style.css"     = "C:\gnuboard\plugin\main_image_manager\skins\ultimate_hero\style.css"
    "theme_kukdong_panel_index.php"   = "C:\gnuboard\theme\kukdong_panel\index.php"
    "theme_kukdong_panel_style.css"   = "C:\gnuboard\theme\kukdong_panel\style.css"
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

## 3. Reverting Logic Changes
- **index.php**: Change `display_hero_visual(...)` back to `display_main_visual(...)`.
- **project_ui.extend.php**: Remove the `display_hero_visual` function definition.

## 4. Troubleshooting
- If the layout is broken after restoration, clear the browser cache.
- Ensure no BOM characters were introduced during manual restoration (always use UTF8 without BOM).
