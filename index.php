<?php
if(!isset($_GET['v']))
{
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
			<p>Stream videos to every browser.</p>
			<form enctype="multipart/form-data" action="up.php" method="POST">
				<div class="fileupload fileupload-new" data-provides="fileupload">
					<div class="input-append">
						<div class="uneditable-input span3">
							<i class="icon-file fileupload-exists"></i>
							<span class="fileupload-preview"></span>
						</div>
						<span class="btn btn-file">
							<span class="fileupload-new">Select file</span>
							<span class="fileupload-exists">Change</span>
							<input type="file" name="uploaded"/>
						</span>
						<a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
					</div>
				</div>
				<input type="submit" value="Upload" class="btn btn-primary">
			</form> 
		</div>
	</div>
</body>
</html>

<?php
} // end of the index page
else
{
    $VideoName = str_replace ( ".mp4" , "" ,$_GET['v'] );
    // We need to test if the video is really there.
    $Prams = BrowserType($_SERVER['HTTP_USER_AGENT']);
    
    if(substr($_GET['v'], strlen($_GET['v']) - 4) != ".mp4" && $Prams['mime'] == "video/mp4")    
    {  
        header("location: http://flm.me.uk/v/".$_GET['v'].".mp4");
        die();
    }
    
    header("Content-Type: " . $Prams['mime']);
    if(DoesVideoExist($VideoName))
    {
        readfile("./v/" . $VideoName . $Prams['ext']);
    }
    else
    {
        readfile("./v/OTgzY" . $Prams['ext']);
    }
    die();
}



function DoesVideoExist($name)
{
    $file_handle = fopen("boop.txt", "r");
    while (!feof($file_handle)) {
        $line = fgets($file_handle);
        if($name == str_replace(array("\r", "\n"), '', $line))
        {
            fclose($file_handle);
            return true;
        }
    }
    fclose($file_handle);
    return false;
}

function BrowserType($UA)
{
    $Return = array();
    $Return['mime'] = "video/mp4";
    $Return['ext'] = ".mp4";
    // IE Detection.
    preg_match('/MSIE (.*?);/', $UA, $matches);
    if (count($matches)>1){

        //Then we're using IE
        $version = $matches[1];

        if ($version<=8) {
            return $Return;
        } else if ($version>=9) {
            $Return['ext'] = ".no";
            return $Return;
        }

    }
    // So it is not IE.
    if (strpos($UA, 'Chrome') !== false)
    {
        $Return['mime'] = "Content-Type: video/webm";
        $Return['ext'] = ".webm";
        return $Return;
    }
    else if (preg_match("/safari/",strtolower($UA)))
    {
        return $Return; // We want MP4 anyway.
    }
    
    
    if(preg_match("/opera/",strtolower($_SERVER['HTTP_USER_AGENT'])))
    {
        $Return['mime'] = "Content-Type: video/webm";
        $Return['ext'] = ".webm";
        return $Return;
    }
    if(preg_match("/firefox/",strtolower($_SERVER['HTTP_USER_AGENT']))) 
    {
        $Return['mime'] = "Content-Type: video/webm";
        $Return['ext'] = ".webm";
        return $Return;
    }
    die("Unsupported. TODO GIF FALLBACK");
}