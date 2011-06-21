<?php
//set_include_path(get_include_path().PATH_SEPARATOR.'../libs/'.PATH_SEPARATOR.'../include/');
require_once "../include/switchroot.php";
$dir = $switchroot."log/cdr-csv/";
$trim = '"';
$doc = array();
$rowIdx = 1;
//$doc;// array('用户','号码','被叫','开始','时长'); 
$time_start = date('Y-m-d H:i:s');//,mktime(13,0,0,11,1,2009));
if(isset($_POST['start'])){
	$time_start = $_POST['start'];
}
$time_end = date('Y-m-d H:i:s');//,mktime(14,0,0,12,31,2009));
if(isset($_POST['end'])){
	$time_end = $_POST['end'];
}
//echo "$time_start--$time_end <br>";
if(is_dir($dir)){
//	echo "is dir\n";
	if($dh = opendir($dir)){
		//echo "open".$dir."\n";
		while(($file = readdir($dh)) !== false){
			//echo $dir.$file."\n";
			if(is_file($dir.$file) && is_readable($dir.$file)){
				//echo $dir.$file."readable\n";
				$fh = fopen($dir.$file,"r");
				if($fh){
					//echo $dir.$file."open\n";
					while(!feof($fh)){
						$buffer = stream_get_line($fh,1024,"\n");
						//echo $buffer."\n";
/*<template name="example">"${caller_id_name}","${caller_id_number}","${destination_number}","${context}","${start_stamp}","${answ
er_stamp}","${end_stamp}","${duration}","${billsec}","${hangup_cause}","${uuid}","${bleg_uuid}","${accountcode}","${read_codec}","${
write_codec}"</template>*/
						list($name,$caller_id,$callee_id,$context,$start,$answer,$end,$dura,$billsec,$cause,$uuid,$bleg_uuid,$account,$read_codec,$write_codec) = explode(",",$buffer,15);
						$name = trim($name,$trim);
						if(is_null($caller_id) || strlen($caller_id) == 0 || strstr($caller_id,'00000000') !== false){
							continue;
						}
						$start = trim($start,$trim);
						if(strcmp($start,$time_start) < 0 || 
						   strcmp($start,$time_end) > 0){
							continue;
						}
						$caller_id = trim($caller_id,$trim);
						$callee_id = trim($callee_id,$trim);
						$answer = trim($answer,$trim);
						$billsec = trim($billsec,$trim);
						$billhour = (int)($billsec/3600);
						$billsec = (int)($billsec - ($billhour*3600));
						$billmin = (int)($billsec/60);
						$billsec = (int)($billsec - ($billmin*60));
						
						$bill = "";
						if($billhour > 0){
							$bill .= $billhour."时".$billmin."分".$billsec."秒";
						}
						else if($billmin > 0){
							$bill .= $billmin."分".$billsec."秒";
						}
						else if($billsec > 0){
							$bill .= $billsec."秒";
						}
						else{
							$bill .="0";
						}
						if(($apos = strpos($callee_id,'@')) !== false){
							$callee_id = substr($callee_id,0,$apos);
          						$callee_id = substr(strrchr($callee_id,': '),1);
						}
						$doc[] = array($name,$caller_id,$callee_id,$start,$bill);
						
					}
					fclose($fh);
				}
			}
		}
		closedir($dh);
	}
	
}
function cmp($a,$b){
	$r = 0;
	$r = strcmp($a[0],$b[0]);
	if($r == 0){
		$r = strcmp($a[3],$b[3]);
	}
	return $r;
}
usort($doc,"cmp");
array_unshift($doc,array('用户','号码','被叫','开始','时长'));
session_start();
if(isset($_SESSION['cdr'])){
	unset($_SESSION['cdr']);
	//session_distory();
}
$_SESSION['cdr']=$doc;
session_write_close();

echo "<div align='center'>\n";
echo "<table bordercolor='#000000' border=0 width=600 align='center'>\n";
//echo "<tr><td>用户</td><td>号码</td><td>被叫</td><td>开始</td><td>时长</td></tr>\n";
foreach($doc as $row=>$cols){
                                                if(($rowIdx%2) == 0){
                                                        echo "<tr bgcolor='#FFFFFF' align='right'>\n";
                                                }
                                                else{
                                                        echo "<tr bgcolor='#EDF3F4' align='right'>\n";
                                                }
						$colIdx = 'A';
						  	echo "<td>\n";
                                                        echo "$cols[0]";
                                                        echo "</td>\n";
                                                        
							 echo "<td>\n";
                                                        echo "$cols[1]";
                                                        echo "</td>\n";
					 echo "<td>\n";
                                                        echo "$cols[2]";
                                                        echo "</td>\n";

						 echo "<td>\n";
                                                        echo "$cols[3]";
                                                        echo "</td>\n";
						 echo "<td>\n";
                                                        echo "$cols[4]";
                                                        echo "</td>\n";

						$rowIdx++;
                                                echo "</tr>\n";
}
echo "</table>\n";
echo "</div>\n";
echo "<div align='right'>";
echo "<a href=\"xls.php\">xls导出</a>";
echo "</div>";


?>
