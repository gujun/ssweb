<html>
<head>
<title>
CDR
</title>
</head>
<body>
<div style=" width:800px; z-index:0">
        <form action="index.php" method="POST">
	<table align="center" width="100%">
	<tr>
	<td width="40%">
	开始时刻:
	<input type="Text" name="start" value="
<?php
$time = time();
$starttime = date('Y-m-d H:i:s',$time-(7*24*60*60));
	echo $starttime;
?>
" size="24" maxlength="24">
	</td>
	<td width="40%">
	结束时刻:
	<input type="Text" name="end" value="
<?php
$endtime = date('Y-m-d H:i:s',$time);
	echo $endtime;
?>
" size="24" maxlength="24">
	</td>
	<td width="20%">
	<input type="Submit" value="查询">
	</td>
	</tr>
	</table>
</form>

</div>
<hr align="LEFT" size="1" width="800" color="#4986A2" noshade/>
<div  style=" width:800px; z-index:0">
<?php
if(isset($_POST['start']) && isset($_POST['end'])){
        require 'cdrinfo.php';
}
?>
</div>
</body>
</html>
