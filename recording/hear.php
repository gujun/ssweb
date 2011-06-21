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
<style>
	body{
		overflow:hidden;
		margin:0px;
		padding:0px;
	}
</style>

</head>
<body>
	<br>
	<center>
	
<?php
//echo "<embed src=\"down.php?file=".urlencode($fpath)."\" autostart=\"true\" loop=\"false\" align=\"left\" controls=\"smallconsole\"/>";
?>
    <object id="player" width="100%" height="64px" classid="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6"
codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112"
align="baseline" border="0" standby="Loading Microsoft Windows Media Player components..."
type="application/x-oleobject">
<?php
	echo "<param name=\"URL\" value=\"down.php?file=".urlencode($fpath)."\" ";
	//	echo "<param name=\"URL\" value=\"http://192.168.1.7/switch/recording/down.php?file=".urlencode($fpath)."\" ";
	//    <param name="URL" value="http://10.100.208.117:80/PCMPlayer/PCMService.jsp?file=/var/rt-vasp/userrec/20090619090037020000.pcm">
?>
    <param name="autoStart" value="true">
   <param name="invokeURLs" value="false">
    <param name="defaultFrame" value="datawindow">
   <embed
<?php 
	echo " src=\"down.php?file=".urlencode($fpath)."\" ";
	//echo " src=\"http://192.168.1.7/switch/recording/down.php?file=".urlencode($fpath)."\" ";
	//src="http://10.100.208.117:80/PCMPlayer/PCMService.jsp?file=/var/rt-vasp/userrec/20090619090037020000.pcm" 
?>
align="baseline" border="0" width="100%" height="68px"
type="application/x-mplayer2"
pluginspage=""
name="MediaPlayer1" showcontrols="1" showpositioncontrols="0"
showaudiocontrols="1" showtracker="0" showdisplay="0"
showstatusbar="1"
autosize="0"
showgotobar="0" showcaptioning="0" autostart="1" autorewind="0"
animationatstart="0" transparentatstart="0" allowscan="1"
enablecontextmenu="1" clicktoplay="0"
defaultframe="datawindow" invokeurls="0">
</embed>
</object>
	</center>
</body>
</html>
<?php
}
else{
	include_once '../include/nofile.php';
}
?>
