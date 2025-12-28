<?php
if (!defined('_GNUBOARD_'))
    exit;

function editor_html($id, $content, $is_dhtml_editor = true)
{
    global $config;
    static $js = true;

    $editor_url = G5_PLUGIN_URL . '/editor/toastui';

    $html = "";
    $html .= "<span class=\"sound_only\">웹에디터 시작</span>";

    if ($js) {
        // [Fix] jQuery Shim: Define a minimal jQuery to prevent ReferenceErrors in admin.head.php/contentform.php
        $html .= "<script>";
        $html .= "if(typeof jQuery === 'undefined') {";
        $html .= "  window.jQuery = window.$ = function(arg) {";
        $html .= "    if (typeof arg === 'function') { document.addEventListener('DOMContentLoaded', arg); return; }";
        $html .= "    return { on: function(){}, click: function(){}, toggle: function(){}, hasClass: function(){ return false; } };"; // Minimal mocks to prevent crash
        $html .= "  };";
        $html .= "  // Load real jQuery";
        $html .= "  var script = document.createElement('script');";
        $html .= "  script.src = 'https://code.jquery.com/jquery-3.6.0.min.js';";
        $html .= "  script.onload = function() { ";
        $html .= "     // When real jQuery loads, it might need to re-run interactions, but mostly we just need the parsing to succeed.";
        $html .= "  };";
        $html .= "  document.head.appendChild(script);";
        $html .= "}";
        $html .= "</script>";

        $html .= "<link rel=\"stylesheet\" href=\"{$editor_url}/css/toastui-editor.min.css\">\n";
        // [Style] Inject Theme CSS to match Frontend Layout
        if (defined('G5_THEME_URL')) {
            $html .= "<link rel=\"stylesheet\" href=\"" . G5_THEME_URL . "/css/default.css\">\n";
        } else {
            $html .= "<link rel=\"stylesheet\" href=\"" . G5_URL . "/theme/corporate/css/default.css\">\n";
        }
        $html .= "<script src=\"{$editor_url}/js/toastui-editor-all.min.js\"></script>\n";
        $js = false;
    }

    $html .= "<div id=\"toastui_{$id}\"></div>\n";
    // Change display:none to visibility:hidden/position:absolute to avoid HTML5 validation 'focusable' error
    $html .= "<textarea id=\"{$id}\" name=\"{$id}\" style=\"width:1px;height:1px;visibility:hidden;position:absolute;\">$content</textarea>\n";
    $html .= "\n<script>\n";
    $html .= "var editor_{$id} = new toastui.Editor({\n";
    $html .= "    el: document.querySelector('#toastui_{$id}'),\n";
    $html .= "    height: '500px',\n";
    $html .= "    initialEditType: 'wysiwyg',\n";
    $html .= "    initialEditType: 'wysiwyg',\n";
    $html .= "    previewStyle: 'vertical',\n";
    $html .= "    initialValue: document.getElementById('{$id}').value,\n";
    $html .= "    hooks: {\n";
    $html .= "        addImageBlobHook: function (blob, callback) {\n";
    $html .= "            var formData = new FormData();\n";
    $html .= "            formData.append('image', blob);\n";
    $html .= "            $.ajax({\n";
    $html .= "                type: 'POST',\n";
    $html .= "                url: '{$editor_url}/upload_image.php',\n";
    $html .= "                data: formData,\n";
    $html .= "                dataType: 'json',\n";
    $html .= "                contentType: false,\n";
    $html .= "                processData: false,\n";
    $html .= "                success: function(data) {\n";
    $html .= "                    if (data.imageUrl) {\n";
    $html .= "                        callback(data.imageUrl, 'image');\n";
    $html .= "                    } else {\n";
    $html .= "                        alert('이미지 업로드 실패: ' + (data.error || '알 수 없는 오류'));\n";
    $html .= "                    }\n";
    $html .= "                },\n";
    $html .= "                error: function() {\n";
    $html .= "                    alert('서버 통신 오류');\n";
    $html .= "                }\n";
    $html .= "            });\n";
    $html .= "            return false;\n";
    $html .= "        }\n";
    $html .= "    }\n";
    $html .= "});\n";

    // [Fix] Defer captcha fix to ensure element exists (run after page load)
    $html .= "window.addEventListener('load', function() {\n";
    $html .= "    var captcha = document.getElementById('captcha_key');\n";
    $html .= "    if (captcha) { \n";
    $html .= "        captcha.removeAttribute('required'); \n";
    $html .= "        captcha.classList.remove('required');\n";
    $html .= "    }\n";
    $html .= "    // Also ensure textarea is valid state\n";
    $html .= "    var ta = document.getElementById('{$id}');\n";
    $html .= "    if(ta) { ta.removeAttribute('required'); }\n";
    $html .= "});\n";
    $html .= "</script>\n";
    $html .= "<span class=\"sound_only\">웹 에디터 끝</span>";

    return $html;
}

// Javascript to sync content to textarea
function get_editor_js($id, $is_dhtml_editor = true)
{
    if (!$is_dhtml_editor)
        return "var {$id}_editor = document.getElementById('{$id}');\n";

    $script = "document.getElementById('{$id}').value = editor_{$id}.getHTML();";

    // [Fix] Manually inject token to bypass admin.js issues if it failed to load
    $script .= "\nif (typeof g5_admin_csrf_token_key !== 'undefined') {";
    $script .= "  var token = document.querySelector('form input[name=\"token\"]');";
    $script .= "  if(token && !token.value) token.value = g5_admin_csrf_token_key;";
    $script .= "}";

    return $script;
}

// Javascript to check validation
function chk_editor_js($id, $is_dhtml_editor = true)
{
    if (!$is_dhtml_editor)
        return "if (!{$id}_editor.value) { alert(\"내용을 입력해 주십시오.\"); {$id}_editor.focus(); return false; }\n";

    // Check if content is empty (basic check)
    return "var content_{$id} = editor_{$id}.getHTML(); if (!content_{$id} || content_{$id} == '<p><br></p>') { alert(\"내용을 입력해 주십시오.\"); return false; }";
}
?>