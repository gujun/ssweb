<?php
session_start();
if(!isset($_REQUEST['id'])){
	die();
}
if(!isset($_SESSION['users'])){  
	die();
}

$id = $_REQUEST['id'];
/*require_once "../../include/switchroot.php";
$pathd = $switchroot.'conf/directory/default/';
$file = $pathd.$id.".xml";
if(!is_file($file) || !is_writable($file)){
	die();
}

$xml = new DOMDocument();
$xml->preserveWhiteSpace= false;
$xml->load($file);

$userArray = $xml->getElementsByTagName("user");
$uservalue = each($userArray);
$user = $uservalue[1];
*/

$users = $_SESSION['users'];
if(!isset($users[$id])){
	die();
}

$oneuser = $users[$id];

if(is_array($oneuser)){
                echo "\nid:".$userid."\n";
                if(isset($oneuser["groups"])){
                        echo "\tgroups:".$oneuser["groups"]."\n";
                }
                if(isset($oneuser["password"])){
                        echo "\tpasswd:".$oneuser["password"]."\n";
                }
                if(isset($oneuser["variables"])){
                        echo "\tvariables:\n";
                        foreach($oneuser["variables"] as $name=>$value){
                                echo "\t\t".$name.":".$value."\n";
                        }
                }
                
}
?>
