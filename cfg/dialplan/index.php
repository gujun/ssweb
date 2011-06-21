<?php
session_start();
require_once "../../include/switchroot.php";
$pathf = $switchroot.'conf/dialplan/default.xml';
$xml = new DOMDocument();
$xml->preserveWhiteSpace= false;
$xml->formatOutput = true;
//$xml->load($pathf);
$output;
$alert = NULL;
if(isset($_POST["content"])){
	$content = $_POST["content"];
	require_once "contextcheck.php";
	try {
		contextcheck($content);
		$xml->loadXML($content);
		//$xsd = "schema.xsd";
		//$handle = fopen($xsd, "r");
		//$schema = fread($handle, filesize ($xsd));
		//fclose($handle);
		//if($xml->schemaValidateSource($schema)){
		
		$output = $xml->saveXML();
		$alert="保存成功!";
	} catch(Exception $e) {
		$output = $content;	
		$alert="错误:".$e->getMessage()."!";
	}	
}
else{
	try {
		$xml->load($pathf);
		$includetag = $xml->getElementsByTagName("include")->item(0);
		$contexttag = $includetag->getElementsByTagName("context")->item(0);
		$contexttag->removeAttribute("name");
		$output=$xml->saveXML($contexttag);
	} catch(Exception $e) {
		$output="";
		$alert="文件打开失败";
	}
}
?>

<html>
<head>
<title>
号码路由
</title>
</head>

<body
<?php
if(isset($alert)){
	echo " onload=\"alert('".$alert."');\"";
}
?>
>

<div align="center">
<form action="index.php" method="POST">
<table>
<tr>
<td>
<textarea name="content" cols="120" rows="30" wrap="VIRTUAL">
<?php
	echo $output;
?>
</textarea>
</td>
</tr>

<tr>
<td align="right">
<input type="submit" value="保存">
</td>
</tr>
</table>
</form>
</div>	
</body>
</html>
