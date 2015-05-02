<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>music.163.com Downloader: <?php echo $title; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$song = $_GET['song'];
if(empty($song)) {
    echo 'Error: No song specified. <a href="/">Try again</a>';
    exit;
}

if(preg_match('/(?<=music.163.com\/#\/song\?id=)(\d+)/', $song, $match)) { $id = $match[1]; }
elseif(preg_match('/\d+/', $song)) { $id = $song; }
else {
    echo 'Error: Invalid song specified. <a href="/">Try again</a>';
    exit;
}
$id = urlencode(trim($id));

$url = 'http://music.163.com/api/song/detail/?id=' . $id . '&ids=[' . $id . ']';

$detail_json = file_get_contents($url);
$detail_data = json_decode($detail_json, true);

$title = $detail_data['songs'][0]['name'];
$artists_array = array();
foreach($detail_data['songs'][0]['artists'] as $artist) { array_push($artists_array, $artist['name']); }
$artists = implode(', ', $artists_array);
$mp3_url = $detail_data['songs'][0]['mp3Url'];
?>
<h1>Download of <?php echo $title; ?></h1>
<p>
    You have requested <?php echo $title; ?> by <?php echo $artists; ?>.<br>
    Click <a href="<?php echo $mp3_url; ?>">here</a> to start the download.
</p>
<p>
    Download URL: <code><?php echo $mp3_url; ?></code>
</p>
<p>Click <a href="/">here</a> to download another song.</p>
</body>
</html>
