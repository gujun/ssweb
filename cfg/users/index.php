<html>
<head>
<title>用户概要信息</title>
</head>
<body>

<?php
if(isset($_REQUEST["oldid"])){
	require_once "remove_user.php";
	$id = urldecode($_REQUEST["oldid"]);
	remove_user($id);
}
?>
<div>
<a href="useradd.php">新增用户</a>
<a href="../dialplan/">号码路由</a>
<a href="../../cdr/">呼叫记录</a>
<a href="../../recording/">录音记录</a>

</div>
<div>
<?php
include_once "usersSum.php";
?>
</div>
</body>
</html>
