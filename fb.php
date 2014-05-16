<?php
if(!isset($_GET['v']))
{
?>
<html>
<head>
<title>Browser aware video tag hosting</title>
</head>
<body>
<h2>Upload Here</h2>
 <form enctype="multipart/form-data" action="up.php" method="POST">
 Please choose a file: <input name="uploaded" type="file" /><br />
 <input type="submit" value="Upload" />
 </form> 
</body>
</html>
<?php
} // end of the index page
else
{
    $VideoName = $_GET['v'];
    // We need to test if the video is really there.
    $Prams = BrowserType($_SERVER['HTTP_USER_AGENT']);
    if($Prams['ext'] == ".gif")
    {
        if(DoesVideoExist($VideoName))
        {
            header("Content-Type: " . $Prams['mime']);
            readfile("./v/" . $VideoName . $Prams['ext']);
            die();
        }
        else
        {
            header("Content-Type: " . $Prams['mime']);
            readfile("./v/OTgzY.gif" . $Prams['ext']);
            die();
        }
    }
    else
    {
        header("Content-Type: image/gif");
        readfile("./v/t.gif");
    }
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
    $Return['mime'] = "Content-Type: video/gif";
    $Return['ext'] = ".gif";
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
        $Return['ext'] = ".no";
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
    return $Return;
}