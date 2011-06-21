#!/usr/local/bin/php
<?php
$dir = "/home/jun/local/fs104/recordings/";
echo "do somehting\n";
if(is_dir($dir) && is_writable($dir)){
	 if($dh = opendir($dir)){
                while(($file = readdir($dh)) !== false){
			if(is_file($dir.$file) && is_readable($dir.$file)){
				$size = filesize($dir.$file);
				if($size > 10001000){
					unlink($dir.$file);
				}
                        }
		}
		closedir($dh);	
	}
}
else{
	echo "not writable\n";
}
?>
