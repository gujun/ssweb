<?php
if(isset($_REQUEST['trash'])){
	

$file =urldecode($_REQUEST['trash']);
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
	unlink($fpath);
	include_once '../include/ok.php';
}
else{
	include_once '../include/nofile.php';
}
}
?>
