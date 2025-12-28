<?php
include_once('./_common.php');

if (!defined('G5_IS_ADMIN'))
    define('G5_IS_ADMIN', true);

// Unsplash API Key (Demo)
// Note: In a real environment, this should be in config or DB.
$access_key = 'CAMzPz4If3wbGIfkTqbiE_MG8yub1wW1zitlL1MOs5U';

$keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
$page = isset($_POST['page']) ? (int) $_POST['page'] : 1;

if (!$keyword)
    die('<div style="grid-column:1/-1; text-align:center; padding:20px;">검색어가 없습니다.</div>');

// API Request
$url = "https://api.unsplash.com/search/photos?page={$page}&query=" . urlencode($keyword) . "&client_id={$access_key}&per_page=20";

// Use cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Demo only
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code != 200) {
    die('<div style="grid-column:1/-1; text-align:center; padding:20px; color:red;">API 요청 실패 (' . $http_code . ')<br>Access Key를 확인해주세요.</div>');
}

$data = json_decode($response, true);

if (empty($data['results'])) {
    if ($page == 1)
        die('<div style="grid-column:1/-1; text-align:center; padding:50px;">검색 결과가 없습니다.</div>');
    else
        die(''); // No more results
}

// Render Results
foreach ($data['results'] as $photo) {
    $thumb = $photo['urls']['small'];
    $full = $photo['urls']['regular']; // For display in editor
    // Unsplash raw URL is best for applying params
    $raw = $photo['urls']['raw'];
    $id = $photo['id'];
    $user = $photo['user']['name'];
    $width = isset($photo['width']) ? $photo['width'] : 0;
    $height = isset($photo['height']) ? $photo['height'] : 0;
    ?>
    <div class="unsplash-item"
        style="border:1px solid #ddd; border-radius:5px; overflow:hidden; cursor:pointer; transition:transform 0.2s;"
        onclick="selectImage('<?php echo $full; ?>', '<?php echo $raw; ?>', <?php echo $width; ?>, <?php echo $height; ?>)"
        onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
        <div style="height:150px; overflow:hidden; background:#eee;">
            <img src="<?php echo $thumb; ?>" style="width:100%; height:100%; object-fit:cover;">
        </div>
        <div style="padding:10px; font-size:12px; color:#666;">
            Photo by <?php echo $user; ?>
        </div>
    </div>
    <?php
}
?>