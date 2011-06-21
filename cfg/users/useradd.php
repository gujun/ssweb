<?php
if(isset($_POST["newid"])){
	$newid = $_POST["newid"];
	if(strlen($newid) > 0){
		$pwd = (isset($_POST["pw"]))?$_POST["pw"]:NULL;
		$groups = (isset($_POST["groups"]))?$_POST["groups"]:NULL;
		require_once "add_user.php";
                add_user($newid,$pwd,NULL,$groups);
	
         	header("Location:index.php");
	}
}
?>
<html>
<head>
<title>
add user
</title>
</head>
<body>
	<div align="center">
	<form action="useradd.php" method="POST">
	<table>
	<tr>
	<td>id:</td><td><input type="Text" name="newid" value="1908" size="24" maxlength="24"></td>
	</tr>
	<tr>
	<td>password:</td><td><input type="Password" name="pw" value="1234" size="24" maxlength="24"></td>
	</tr>
	<tr>
	<td>group:</td><td><input type="Text" name="groups" value="newgroup5" size="24" maxlength="24"></td>
	</tr>
	<tr>
	<td></td><td><input type="submit" name="submit" value="确定"></td>
	</tr>
	</table>
	</form>
	<div>
</body>
</html>
