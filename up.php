<?php
$target = "v/"; 
$target = $target . basename( $_FILES['uploaded']['name']); 
//print_r($_FILES['uploaded']);
$randomstringP1 = base64_encode(md5(print_r($_SERVER,true).time(),true));
$randomstringP2 = preg_replace("/[^A-Za-z0-9 ]/", '', $randomstringP1);
$randomstringP2 = substr($randomstringP2,0,5);
if($_FILES['uploaded']['type'] == "video/mp4")
{
    if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target))
    {
        rename($target,"v/".$randomstringP2."_t.mp4");
        shell_exec("/usr/bin/ffmpeg -i /var/www/DataStore/videohosting/v/".$randomstringP2. "_t.mp4 /var/www/DataStore/videohosting/v/".$randomstringP2.".webm");
        shell_exec("/usr/bin/ffmpeg -i /var/www/DataStore/videohosting/v/".$randomstringP2. "_t.mp4 -b 1500k -vcodec h264 -vpre baseline -g 30 /var/www/DataStore/videohosting/v/".$randomstringP2.".mp4");
        shell_exec("/usr/bin/ffmpeg -ss 00:00:00.000 -i /var/www/DataStore/videohosting/v/".$randomstringP2. ".mp4 -pix_fmt rgb24 -r 10 -s 320x240 /var/www/DataStore/videohosting/v/".$randomstringP2.".gif");
    }
}
elseif($_FILES['uploaded']['type'] == "video/webm")
{
    if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target))
    {
        rename($target,"v/".$randomstringP2.".webm");
        shell_exec("/usr/bin/ffmpeg -i /var/www/DataStore/videohosting/v/".$randomstringP2. ".webm -b 1500k -vcodec h264 -vpre baseline -g 30 /var/www/DataStore/videohosting/v/".$randomstringP2.".mp4");
        shell_exec("/usr/bin/ffmpeg -ss 00:00:00.000 -i /var/www/DataStore/videohosting/v/".$randomstringP2. ".webm -pix_fmt rgb24 -r 10 -s 320x240 /var/www/DataStore/videohosting/v/".$randomstringP2.".gif");
    }
}
else
{
    if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target))
    {
        rename($target,"v/".$randomstringP2.".dunno");
        shell_exec("/usr/bin/ffmpeg -i /var/www/DataStore/videohosting/v/".$randomstringP2. ".dunno -b 1500k -vcodec h264 -vpre baseline -g 30 /var/www/DataStore/videohosting/v/".$randomstringP2.".mp4");
        shell_exec("/usr/bin/ffmpeg -i /var/www/DataStore/videohosting/v/".$randomstringP2. ".dunno /var/www/DataStore/videohosting/v/".$randomstringP2.".webm");
        shell_exec("/usr/bin/ffmpeg -ss 00:00:00.000 -i /var/www/DataStore/videohosting/v/".$randomstringP2. ".dunno -pix_fmt rgb24 -r 10 -s 320x240 /var/www/DataStore/videohosting/v/".$randomstringP2.".gif");
        unlink("v/" . $randomstringP2.".dunno");
    }
}
file_put_contents("boop.txt", $randomstringP2 . "\n", FILE_APPEND);
?>
<html>
<head>
	<title>flm.me.uk</title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-fileupload.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-fileupload.min.js"></script>
	<script src="main.js"></script>
</head>
<body>
	<div class="container">
		<div id="uploadContainer" class="span6 offset3">
			<h2>flm.me.uk</h2>
			<p>Place the <b>both</b> of the tags in your post.<br/>Only the one that the browser supports will be shown.</p>
			<textarea>[vid]http://flm.me.uk/v/<?php echo $randomstringP2;?>[/vid]
[img]http://flm.me.uk/i/<?php echo $randomstringP2;?>[/img]</textarea>
			<a href="index.php" class="btn btn-success"><i class="icon-chevron-left" style='margin-top:3px;'></i> Upload Something Else</a>
		</div>
	</div>
</body>
</html>
<?php
die();