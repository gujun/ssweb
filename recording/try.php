<?php
//set_include_path(get_include_path().PATH_SEPARATOR.'../libs/');
if(!isset($_REQUEST['file'])){
	include_once '../include/nofile.php';
	die();
}
$file =urldecode($_REQUEST['file']);
$ftype = substr(strrchr($file,'.'),1);
require_once "../include/switchroot.php";
$dir = $switchroot."recordings/";
$fpath = "";
$fname = "";
$pass = 0;

if(is_file($file) && is_readable($file)){
        $fpath = $file ;
        $fname = substr(strrchr($file,'/'),1);
        $pass++;
} else if(is_file($switchroot.$file) && is_readable($switchroot.$file)){
        $fpath = $switchroot.$file;
        $fname = $file;
        $pass++;
} else if(is_file($dir.$file) && is_readable($dir.$file)){
        $fpath = $dir.$file;
        $fname = $file;
        $pass++;
}
if($pass > 0){
?>
<html>
<head>
<title>
<?php
echo "$fname";
?>
</title>
</head>
<body onload="window.open('hear.php?file=<?php echo urlencode($fpath);?>','hearRecording','fullscreen=no,titlebar=no,menubar=no,toolbar=no,location=no,scrollbars=yes,resizable=yes,status=no,width=240,height=66,directories=no,screenX=400,screenY=200');">

</body>
</html>
<?php
}
else{
	include_once '../include/nofile.php';
}
?>
