<?php
session_start();
if(!isset($_REQUEST['id'])){
        die();
}
if(!isset($_SESSION['users'])){
        die();
}
$id = $_REQUEST['id'];

$users = $_SESSION['users'];
if(!isset($users[$id])){
        die();
}

$oneuser = $users[$id];
$groupString = "";
if(isset($oneuser["groups"])){
       $groupString .= $oneuser["groups"];
}
equire_once "../../include/switchroot.php";
$userdir = $switchroot.'conf/directory/default/';
$userfile = $userdir.$id.".xml";
if(!is_file($userfile) || !is_writable($userdir)){
        die();
}
unlink($userfile);

if(strlen($groupString)>0){
	require_once "remove_user_from_group.php";
	$groups = explode(",",$groupString);
	foreach($groups as $group){
		remove_user_from_group($id,$group);
	}
}

?>
