<?php
require_once "../../include/switchroot.php";

function remove_user_from_group($id,$groupname){
	global $switchroot;
	$groupdir = $switchroot.'conf/directory/group/';
	$groupfile = $groupdir.$groupname;
	if(!is_file($groupfile)){
		$groupfile .=".xml";
	}
	if(!is_file($groupfile) || !is_readable($groupfile) || !is_writable($groupdir)){
        	echo "invalid groupfile ".$groupfile;
		return -2;
	}
	$edited = 0;

	$xml = new DOMDocument();
	$xml->preserveWhiteSpace= false;
	$xml->load($groupfile);

	$group = $xml->getElementsByTagName("group")->item(0);
	
	$users = $group->getElementsByTagName("users")->item(0);

	$userArray = $users->getElementsByTagName("user");
	foreach($userArray as $user){
		$pointerId = $user->getAttribute("id");
		if(strcmp($pointerId,$id) == 0){
			//$user->parentNode->removeChild($user);
			$users->removeChild($user);
			$edited++;
		}
	}
	if($edited > 0){
		unlink($groupfile);

		if($users->hasChildNodes()){
			 $xml->formatOutput = true;
                        //echo "\n\n".$xml->saveXML();
                        $xml->save($groupfile);
			//echo "xml save\n";
		}
	}
}
?>
