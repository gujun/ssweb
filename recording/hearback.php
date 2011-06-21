<?php
set_include_path(get_include_path().PATH_SEPARATOR.'../libs/');
if(!isset($_REQUEST['file'])){
	include_once 'nofile.php';
	die();
}
$file =urldecode($_REQUEST['file']);
$ftype = substr(strrchr($file,'.'),1);
$dir = "/home/jun/local/fs104/recordings/";
if(is_file($dir.$file) && is_readable($dir.$file)){
?>
<html>
<head>
<title>
<?php
echo "$file";
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
//	echo "<embed src=\"down.php?file=".urlencode($file)."\" autostart=\"true\" loop=\"false\" align=\"left\" controls=\"smallconsole\"/>";
?>
<object id="OnlinePlayerActiveX" class="player" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="100%" height="100%" align="middle">
<param name="allowScriptAccess" value="always">
<param name="allowFullScreen" value="false">
<param name="menu" value="false">
<?php
echo "<param name=\"movie\" value=\"http://192.168.1.7/switch/recording/down.php?file=".urlencode($file)."\">\n";
?>
<param name="FlashVars" value="-1">
<param name="quality" value="high">
<param name="bgcolor" value="#ffffff">
<param name="play" value="true">
<param name="scale" value="noscale">
<param name="wmode" value="window">
<param name="salign" value="lt">
<param name="loop" value="true">
<param name="name" value="OnlinePlayer">
<param name="pluginspage" value="http://www.macromedia.com/go/getflashplayer">
<embed class="player" id="OnlinePlayerPlugin"
<?php  
    echo " src=\"http://192.168.1.7/switch/recording/down.php?file=".urlencode($file)."\" ";
?>
       width="100%" height="100%" bgcolor="#ffffff" name="OnlinePlayer" 
       type="application/x-shockwave-flash"
       pluginspage="http://www.macromedia.com/go/getflashplayer"
       allowScriptAccess="always" allowFullScreen="false" menu="false"
<?php
	 echo " movie=\"http://192.168.1.7/switch/recording/down.php?file=".urlencode($file)."\" ";
?>
	 quality="high" play="true"
       FlashVars="-1"
       scale="noscale" wmode="window" salign="lt" loop="true"/>
</object>
	</center>
</body>
</html>
<?php
}
else{
	include_once 'onfile.php';
}
?>
