<?php
session_start();
require_once "../../include/switchroot.php";
$pathf = $switchroot.'log/freeswitch.xml.fsxml';
$xml = new DOMDocument();
$xml->preserveWhiteSpace= false;
$xml->load($pathf);

$sectionArray = $xml->getElementsByTagName("section");
$directory = "directory";
$default = "default";
$usersSession = array();
$usersIdx = array();
foreach($sectionArray as $section){
	if(strcmp($directory,$section->getAttribute('name')) == 0){
		$domainArray = $section->getElementsByTagName("domain");
		foreach($domainArray as $domain){

			$groupsArray = $domain->getElementsByTagName("groups");
			foreach($groupsArray as $groups){
				$groupArray = $groups->getElementsByTagName("group");
				foreach($groupArray as $group){
					$groupname = $group->getAttribute("name");
					
					if(strcmp($default,$group->getAttribute("name")) == 0){
						$usersArray = $group->getElementsByTagName("users");
						foreach($usersArray as $users){
							$userArray = $users->getElementsByTagName("user");
							foreach($userArray as $user){
								$id = $user->getAttribute("id");
								$usersSession[$id]["id"] = $id;
								$usersIdx[] = $id;
								$paramsArray = $user->getElementsByTagName("params");
								foreach($paramsArray as $params){
									$paramArray = $params->getElementsByTagName("param");
									foreach($paramArray as $param){
			
										$name = $param->getAttribute("name");
										$value = $param->getAttribute("value");
										if(strcmp($name,"password") == 0){
										  $usersSession[$id]["password"] = $value;
										}
										//$usersSession[$id]["params"][$name] = $value;
									}
								}
								
								$variablesArray = $user->getElementsByTagName("variables");
								foreach($variablesArray as $variables){
									$variableArray=$variables->getElementsByTagName("variable");
									foreach($variableArray as $variable){
										$name = $variable->getAttribute("name");
										$value=$variable->getAttribute("value");
										$usersSession[$id]["variables"][$name]=$value;
									}
								}
							}
						}					
					}
					else{
						$usersArray = $group->getElementsByTagName("users");
						foreach($usersArray as $users){
							$userArray = $users->getElementsByTagName("user");
							foreach($userArray as $user){
								$id = $user->getAttribute("id");
								if(isset($usersSession[$id])){
									if(isset($usersSession[$id]["groups"])){
										$usersSession[$id]["groups"] .= ','.$groupname;
									}
									else{
										$usersSession[$id]["groups"] = $groupname;
									}
								}
							}
						}
					}
					echo "\n\n";
				}
			}
		}
	}
}

/*function cmp($a,$b){
        $r = 0;
	if(isset($a["id"]) && isset($b["id"])){
		$r = strcmp($a["id"],$b["id"]);
	}
	else{
        	$r = strcmp($a[0],$b[0]);
	}
        return $r;
}*/
//usort($usersSession,"cmp");

//session_start();                                
if(isset($_SESSION['users'])){                            
        unset($_SESSION['users']);                
        //session_distory();                    
}                                                       
$_SESSION['users']=$usersSession;                          
session_write_close(); 


?>
<div>
<table>
<?php
$idx = 0;
$count = count($usersSession);
$cols = 5;
$rows = (int)(($count+$cols)/$cols);
/*foreach($usersSession as $userid => $oneuser){

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
}*/
for($row = 0;$row < $rows;$row++){
	echo "<tr>";
	for($col = 0;$col<$cols;$col++){
		$idx = (int)(($rows*$col) + $row);
		if($idx < $count){
			$id = $usersIdx[$idx];
			echo "<td>".$usersSession[$id]["id"]."</td>";
			if(isset($usersSession[$id]["groups"])){
				echo "<td>".$usersSession[$id]["groups"]."</td>";
			}
			else{
				echo "<td></td>";
			}
		}
		else{
			echo "<td></td><td></td>";
		}
	}
	echo "</tr>\n";
}
?>
</table>
</div>
