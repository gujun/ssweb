<?php
set_include_path(get_include_path().PATH_SEPARATOR.'../libs/');
set_include_path(get_include_path().PATH_SEPARATOR.'../include/');
require_once "../include/switchroot.php";
$dir = $switchroot."recordings/";
$records = array();
$rowIdx = 1;
$time_start = date('Y-m-d H:i:s',mktime(13,0,0,11,1,2008));
if(isset($_REQUEST['start'])){
	$time_start = $_REQUEST['start'];
}
$time_end = date('Y-m-d H:i:s',mktime(14,0,0,12,31,2010));
if(isset($_REQUEST['end'])){
	$time_end = $_REQUEST['end'];
}
//echo "$time_start--$time_end <br>";
if(is_dir($dir)){
	if($dh = opendir($dir)){
		while(($file = readdir($dh)) !== false){
			if(is_file($dir.$file) && is_readable($dir.$file)){
					list($who,$name,$starttype) = explode('_',$file,3);
					list($callerflag,$callee) = explode('-',$name,2);
					list($caller,$flag) = explode('[',$callerflag,2);
					list($start,$type)= explode('.',$starttype,2);
					list($y,$m,$d,$h,$i,$s)= explode('-',$start,6);
					$start = $y.'-'.$m.'-'.$d.' '.$h.':'.$i.':'.$s;
					if(strcmp($start,$time_start) < 0 || 
                                                   strcmp($start,$time_end) > 0){
                                                        continue;
                                        }
					$fsize = filesize($dir.$file);
					$fsizeK = round($fsize/1024);
					$fsizeM = (int)($fsizeK/1024);
					$fsizeK = $fsizeK-($fsizeM*1024);
					if($fsizeM > 0){
						$fsize=$fsizeM.'M,'.$fsizeK.'K';
					}
					else{
						$fsize=$fsizeK.'K';
					}
					if(isset($flag)){
						if(strstr($flag,"dispatcall")){
							$caller = $caller+"(调度呼叫)";
						}
						else if(strstr($flag,"dispatgroup")){
							$caller = $caller+"(调度组呼)";
						}
					}
					if(strcmp("group",$who) == 0){
						$who = "联合录音";
					}
					$records[] = array($who,$caller,$callee,$start,$type,$fsize,$file);
					
				
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
usort($records,"cmp");
//array_unshift($records,array('用户','号码','被叫','开始','格式','长度','文件名'));
session_start();
if(isset($_SESSION['recording'])){
	unset($_SESSION['recording']);
	//session_distory();
}
$_SESSION['recording']=$records;
session_write_close();

echo "<div align='center'>\n";
echo "<table bordercolor='#000000' border=0 width=\"80%\" align='center'>\n";
echo "<tr><td>用户</td><td>主叫</td><td>被叫</td><td>录音开始时间</td><td>格式</td><td>长度</td><td>试听</td><td>下载</td><td>删除</td></tr>\n";
foreach($records as $row=>$cols){
                                                if(($rowIdx%2) == 0){
                                                        echo "<tr bgcolor='#FFFFFF' align='right'>\n";
                                                }
                                                else{
                                                        echo "<tr bgcolor='#EDF3F4' align='right'>\n";
                                                }
						$colIdx = 'A';
                                                /*foreach($cols as $i => $value){
                                                        echo "<td>\n";
                                                        echo "$value";
                                                        echo "</td>\n";
                                                }*/
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
                                                 echo "<td>\n";
                                                        echo "$cols[5]";
                                                        echo "</td>\n";
                                                 echo "<td align=\"center\">";
                                                        echo "<img src=\"../images/hear.gif\" border=0 alt=\"试听\" style=\"cursor:hand\" onclick=\"window.open('hear.php?file=".urlencode($cols[6])."','hearRecording','fullscreen=no,titlebar=no,menubar=no,toolbar=no,location=no,scrollbars=yes,resizable=yes,status=no,width=240,height=66,directories=no');\">";
                                                        echo "</td>\n";
						echo "<td align=\"center\"><a href=\"down.php?file=".urlencode($cols[6])."\">";
                                                        echo "<img src=\"../images/down.gif\" border=0 alt=\"下载\">";
                                                        echo "</a></td>\n";
						 echo "<td align=\"center\"><a href=\"index.php?start=".
							urlencode($time_start)."&end=".urlencode($time_end).
							"&trash=".urlencode($cols[6])."\">";
                                                        echo "<img src=\"../images/trash.gif\" border=0 alt=\"删除\">";
                                                        echo "</a></td>\n";
						$rowIdx++;
                                                echo "</tr>\n";
}
echo "</table>\n";
echo "</div>\n";
echo "<div align='right'>";
echo "<a href=\"xls.php\">xls导出</a>";
echo "</div>";


?>
