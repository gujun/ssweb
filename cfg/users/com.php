<?php
function com(){
	$fp = fsockopen("192.168.1.177", 33333);
	if (!$fp) {
   	  	return "err,server no response\n";
	}
	
    //$first = stream_get_line($fp,128,"\n\n");
	//echo "hello:".strlen($first).$first."\n";
    $cmd = "content-type:cfg\n\n";
    //fwrite($fp, $cmd);
    //test
    fwrite($fp, "999");
    fwrite($fp, "0");
    fwrite($fp, "11");
    fwrite($fp, "root");
    fwrite($fp, "2010-1-21");
    fwrite($fp, "1");
    fwrite($fp, "1");
    fwrite($fp, "100");
    fwrite($fp, "tt");
    fwrite($fp, "userid = ddddd");    
	//echo "send:".strlen($cmd).$cmd;
    stream_set_timeout($fp, 10);
    $res = stream_get_line($fp,128,"\n\n");
    	//echo "response:".strlen($res).$res."\n";
    $info = stream_get_meta_data($fp);
    fclose($fp);

    if ($info['timed_out']) {
        return  'err,Connection timed out!';
    } 
    return 'ok';
}
//	$r=com();
//	echo $r;
?> 
