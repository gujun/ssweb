<?php
session_start();
require_once "../../include/switchroot.php";
function add_user($idString,$passwdString,$variablesArray,$groupString){
	global $switchroot;	
	$userdir = $switchroot.'conf/directory/default/';
	$userfile = $userdir.$idString.".xml";
	if(is_file($userfile)){
		echo "invalid file".$userfile."\n";
                return "err,userid already exists";
	}
	if(!is_writable($userdir)){
		echo "can't open ".$userdir."\n";
        	return "err,can't open ".$userdir;
	}
	//create user xml
	 $xml = new DOMDocument();
	 $xml->preserveWhiteSpace= false;

	 $includetag = $xml->createElement('include');

	 $usertag = $xml->createElement('user');
	 $usertagid = $xml->createAttribute('id');
	 $usertagidvalue = $xml->createTextNode($idString);
	 $usertagid->appendChild($usertagidvalue);
	$usertag->appendChild($usertagid);


	 $paramstag = $xml->createElement('params');

	 $parampwd = $xml->createElement('param');
	 $parampwdname = $xml->createAttribute('name');
	 $parampwdnamevalue = $xml->createTextNode('password');
	 $parampwdname->appendChild($parampwdnamevalue );

	 $parampwdvalue = $xml->createAttribute('value');
	 $parampwdvaluevalue = $xml->createTextNode($passwdString);
	 $parampwdvalue->appendChild($parampwdvaluevalue );
	$parampwd->appendChild($parampwdname );
	$parampwd->appendChild($parampwdvalue);

	  $paramstag->appendChild($parampwd);

	 $paramvmpwd = $xml->createElement('param');
	 $paramvmpwdname = $xml->createAttribute('name');
	 $paramvmpwdnamevalue = $xml->createTextNode('vm-password');
	$paramvmpwdname->appendChild($paramvmpwdnamevalue );

	 $paramvmpwdvalue = $xml->createAttribute('value');
	 $paramvmpwdvaluevalue = $xml->createTextNode($idString);
	$paramvmpwdvalue->appendChild($paramvmpwdvaluevalue);
	$paramvmpwd->appendChild($paramvmpwdname );
	$paramvmpwd->appendChild($paramvmpwdvalue);

	   $paramstag->appendChild($paramvmpwd);

	$usertag->appendChild($paramstag);

	 $variablestag = $xml->createElement('variables');
	if(isset($variablesArray) && is_array($variablesArray)){

	foreach($variablesArray as $variname=>$varivalue){
		$variabletag = $xml->createElement('variable');
		$variablename = $xml->createAttribute('name');
		$variablenamevalue = $xml->createTextNode($variname);
		$variablename->appendChild($variablenamevalue);
		$variablevalue = $xml->createAttribute('value');
		$variablevaluevalue = $xml->createTextNode($varivalue);
		$variablevalue->appendChild($variablevaluevalue);
		$variabletag->appendChild($variablename);
		$variabletag->appendChild($variablevalue);
		$variablestag->appendChild($variabletag);
		
		
	}
	}

 	$usertag->appendChild($variablestag);
 	$includetag->appendChild($usertag);

 	$xml->appendChild($includetag);
 	$xml->formatOutput = true;
	
	$xml->save($userfile);
	
	if(isset($groupString)){
		require_once "add_user_to_group.php";
		$groupnameArray = explode(',',$groupString);
		foreach($groupnameArray as $groupname){
			add_user_to_group($idString,$groupname);
		}
	}


	require_once "com.php";
	com();

}

?>
