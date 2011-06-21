<?php
session_start();
require_once "../../include/switchroot.php";
require_once "com.php";
//echo $switchroot;
function remove_user($id){
/*	if(!isset($_SESSION['users'])){
        	return -1;
	}

	$users = $_SESSION['users'];
	if(!isset($users[$id])){
        	return -1;
	}

	$oneuser = $users[$id];
	$groupString = "";
	if(isset($oneuser["groups"])){
       		$groupString .= $oneuser["groups"];
	}
*/
	global $switchroot;	
	$userdir = $switchroot.'conf/directory/default/';
	$userfile = $userdir.$id.".xml";
	if(!is_file($userfile)){
		echo "invalid file".$userfile."\n";
                return -2;
	}
	if(!is_writable($userdir)){
		echo "can't open ".$userdir."\n";
        	return -2;
	}
	unlink($userfile);

	$groupdir = $switchroot.'conf/directory/group/';
	if(!is_dir($groupdir)){
                echo "invalid dir".$groupdir."\n";
                return -2;
        }
        if(!is_readable($groupdir)){
                echo "can't open ".$groupdir."\n";
                return -2;
        }
	 if($dh = opendir($groupdir)){
	        require_once "remove_user_from_group.php";
                while(($file = readdir($dh)) !== false){
			 if(is_file($groupdir.$file) && is_readable($groupdir.$file)){
 				remove_user_from_group($id,$file);                  
			}     
		}
		closedir($dh);

	}
	com();
	/*if(strlen($groupString)>0){
        	require_once "remove_user_from_group.php";
        	$groups = explode(",",$groupString);
        	foreach($groups as $group){
                	remove_user_from_group($id,$group);
        	}
	}*/

}

?>
