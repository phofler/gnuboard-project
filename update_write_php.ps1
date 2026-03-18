$file = 'C:\gnuboard\plugin\sub_design\adm\write.php'
$content = Get-Content $file -Raw -Encoding UTF8
# 1. Add sd_menu_table to initial row array
$content = $content -replace "\s*'sd_breadcrumb_skin' => 'dropdown'\);", ", 'sd_breadcrumb_skin' => 'dropdown', 'sd_menu_table' => '');"

# 2. Add Select Box Row in Table
$menuTableHtml = @'
                <tr>
                    <th scope="row">연결될 메뉴 세트 (Pro Menu)</th>
                    <td>
                        <select name="sd_menu_table" id="sd_menu_table" class="frm_input">
                            <option value="">기본 (Default)</option>
                            <option value="en" <?php echo $row['sd_menu_table']=='en'?'selected':''; ?>>영어 (English)</option>
                            <option value="jp" <?php echo $row['sd_menu_table']=='jp'?'selected':''; ?>>일본어 (Japanese)</option>
                            <option value="cn" <?php echo $row['sd_menu_table']=='cn'?'selected':''; ?>>중국어 (Chinese)</option>
                        </select>
                        <div style="margin-top:5px; color:#666; font-size:12px;">
                            Pro Menu Manager에서 관리하는 언어별 메뉴를 선택하세요. (g5_write_menu_pdc_{세트})
                        </div>
                    </td>
                </tr>
'@
$content = $content -replace '(                <tr>\s+<th scope="row">레이아웃 선택</th>)', ($menuTableHtml + "`n`$1")

# 3. Pass sd_menu_table to ajax.load_menus.php
$content = $content -replace 'lang: lang,', 'lang: lang, sd_menu_table: $("#sd_menu_table").val(),'
$content = $content -replace '("#sd_theme, #sd_lang, #sd_id_custom").on\("change keyup"', '("#sd_theme, #sd_lang, #sd_id_custom, #sd_menu_table").on("change keyup"'

# Save using UTF8 No BOM
$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText($file, $content, $utf8NoBom)
