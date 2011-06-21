<?php
require_once "../../include/switchroot.php";

function add_user_to_group($id,$groupnamestr){
	global $switchroot;
	$groupdir = $switchroot.'conf/directory/group/';
	$groupfile = $groupdir.$groupnamestr.".xml";
        $xml = new DOMDocument();
        $xml->preserveWhiteSpace= false;

	if(!is_file($groupfile)){
		$include = $xml->createElement('include');
		$group = $xml->createElement('group');
		$groupname = $xml->createAttribute('name');
		$groupnamevalue = $xml->createTextNode($groupnamestr);
		
		$users = $xml->createElement('users');

		$user = $xml->createElement('user');
                $userid = $xml->createAttribute('id');
		$useridvalue = $xml->createTextNode($id);
		$usertype = $xml->createAttribute('type');
		$usertypevalue = $xml->createTextNode('pointer');
		
		$usertype->appendChild($usertypevalue);
		$userid->appendChild($useridvalue);
		$user->appendChild($userid);
		$user->appendChild($usertype);
		
		$users->appendChild($user);

		$groupname->appendChild($groupnamevalue);
		$group->appendChild($groupname);
		$group->appendChild($users);
		
		$include->appendChild($group);

		$xml->appendChild($include);

		$xml->formatOutput = true;
		$xml->save($groupfile);
		return 0;
	}
	if(!is_readable($groupfile) || !is_writable($groupdir)){
        //	echo "invalid groupfile ".$groupfile;
		return -2;
	}
	$alreadyhere = 0;

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
			//$users->removeChild($user);
			$alreadyhere++;
			break;
		}
	}
	if($alreadyhere == 0){
		$new = $xml->createElement('user');
		$newid = $xml->createAttribute('id');
		$newidvalue = $xml->createTextNode($id);
		$newtype = $xml->createAttribute('type');
		$newtypevalue = $xml->createTextNode('pointer');
		$newtype->appendChild($newtypevalue);
		$newid->appendChild($newidvalue);
		$new->appendChild($newid);
		$new->appendChild($newtype);
		
		$users->appendChild($new);
		$xml->formatOutput = true;
                        //echo "\n\n".$xml->saveXML();
		unlink($groupfile);
                $xml->save($groupfile);
	}
}
?>
