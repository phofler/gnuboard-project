$file = 'C:\gnuboard\plugin\main_content_manager\adm\write.php'
$content = [System.IO.File]::ReadAllText($file)

$jsHelpers = @"
    // [UNIFIED] Global Image Manager Helpers
    function openUnsplashPopup(id) {
        SmartImageManager.open({
            id: 'mc_preview_' + id,
            index: -1,
            callback: function(url) { receiveImageUrl(url, id); }
        });
    }

    function closeUnsplashModal() {
        $('#unsplash_modal').fadeOut(200);
    }

    function receiveImageUrl(url, id) {
        $('#mc_image_url_' + id).val(url);
        $('#mc_preview_' + id).html('<img src="' + url + '" style="width:100%; height:100%; object-fit:cover;">');
    }

"@

$find = 'function delete_mc_image(id) {'
if ($content.Contains($find)) {
    $content = $content.Replace($find, $jsHelpers + "`n    " + $find)
}

# Unify existing button calls
$oldCall = 'SmartImageManager.open({id:''mc_preview_<?php echo $mi_id; ?>'', index: -1, callback: function(url){ receiveImageUrl(url, ''<?php echo $mi_id; ?>''); } });'
$newCall = 'openUnsplashPopup(''<?php echo $mi_id; ?>'');'
$content = $content.Replace($oldCall, $newCall)

$utf8NoBom = New-Object System.Text.UTF8Encoding $false
[System.IO.File]::WriteAllText($file, $content, $utf8NoBom)
