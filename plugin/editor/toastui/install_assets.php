<?php
$files = [
    'css/toastui-editor.min.css' => 'https://uicdn.toast.com/editor/latest/toastui-editor.min.css',
    'js/toastui-editor-all.min.js' => 'https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js'
];

foreach ($files as $local => $remote) {
    echo "Downloading $remote...\n";
    $content = file_get_contents($remote);
    if ($content) {
        file_put_contents(__DIR__ . '/' . $local, $content);
        echo "Saved to $local (" . strlen($content) . " bytes)\n";
    } else {
        echo "FAILED to download $remote\n";
    }
}
?>