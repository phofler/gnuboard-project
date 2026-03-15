# Centered Skin Recovery Guide (2026-03-15)

## 1. Context
The 'Centered' skin was modernized to align with the modularized `#mainHeader` structure and design tokens. This document provides steps to revert in case of layout breakage or unexpected behavior.

## 2. Backup Location
- **Path:** `C:\gnuboard\_backups\20260315_centered_skin_fix`
- **Contents:** Original `menu.skin.php`, `style.css`, `preview.php`.

## 3. Recovery Steps
If the layout breaks or is invisible after the update:

### A. Quick Revert (File System)
Run the following PowerShell command to restore original files:
```powershell
Copy-Item -Path 'C:\gnuboard\_backups\20260315_centered_skin_fix\*' -Destination 'C:\gnuboard\plugin\top_menu_manager\skins\centered\' -Force
```

### B. Specific Files
- `menu.skin.php`: Controls the HTML structure.
- `style.css`: Controls alignment and visibility.

## 4. Key Logic Changes
- **Header ID:** Changed from arbitrary div wrappers to `<header id="mainHeader" class="header centered">`.
- **Breakout Fix:** Added `calc` based breakout to ensure full-width background even if theme containers are narrow.
- **Icons:** Standardized FontAwesome icon usage within `dep2Wrap`.
