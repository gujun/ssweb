<?php
function contextcheck($content){
	if(!isset($content)){
		throw new Exception('内容为空');
	}
	$xml = new DOMDocument();
	$xml->preserveWhiteSpace= false;
	try{
		$xml->loadXML($content);
	}
	catch(Exception $e){
		throw new Exception('xml格式有误');
	}
	$commentTagName = '#comment';
	$context = $xml->documentElement;
	/*try{
		$context = $xml->getElementsByTagName("context")->item(0);
	}
	catch(Exception $e){
		throw new Exception('xml格式有误');
	}
	*/
	/*$contexts=$xml->childNodes;
	if($contexts->length < 1){
		throw new Exception('xml 格式有误'.$contexts.length);
	}
	foreach($contexts as $cont){
		$contTagName = $cont->nodeName;
		if(strcmp($commentTagName,$contTagName) == 0){
                        continue;
                }
		if(strcmp('context',$contTagName) != 0){
			throw new Exception('非法标记'.$contTagName);
		}
		else if(!isset($context)){
			$context = $cont;
		}
	}*/
	if(!isset($context)){
		throw new Exception('context标记有误');
	}
	$extensions = $context->childNodes;
	//$extensionArray = $context->getElementsByTagName('extension');
	if($extensions->length < 1){
		throw new Exception('没有extension标记');
	}
	foreach($extensions as $extension){
		$extenTagName = $extension->nodeName;
		if(!($extension instanceOf DOMElement)){
			continue;
		}
		/*if(strcmp($commentTagName,$extenTagName) == 0){
			continue;
		}*/
		if(strcmp('X-PRE-PROCESS',$extenTagName) == 0){
			continue;
		}
		if(strcmp('extension',$extenTagName) != 0){
			throw new Exception('context非法子标记'.$extenTagName);
		}
		$extenName = $extension->getAttribute('name');
		if(!isset($extenName) || strlen($extenName)==0){
			throw new Exception('extension标记没有name属性');
		}
		$conditions = $extension->childNodes;
		//$conditionArray = $extension->getElementsByTagName('condition');
		if($conditions->length < 1){
			throw new Exception('extension('.$extenName.')没有condition子标记');
		}
		foreach($conditions as $condition){
			$conditionTagName = $condition->nodeName;
			 if(!($condition instanceOf DOMElement)){
                        	continue;
                	 }
			/*if(strcmp($commentTagName,$conditionTagName) == 0){
                       		continue;
                	}*/
			if(strcmp('condition',$conditionTagName) != 0){
				throw new Exception('extension('.$extenName.')非法子标记'.$conditionTagName);
			}
			$actions = $condition->childNodes;
			foreach($actions as $action){
				$actionTagName = $action->nodeName;
			        if(!($action instanceOf DOMElement)){
                        	     continue;
                		}
				/*if(strcmp($commentTagName,$actionTagName) == 0){
                        		continue;
                		}*/
				if(strcmp('action',$actionTagName) == 0 ||
					strcmp('anti-action',$actionTagName) == 0){
					$actionapp = $action->getAttribute('application');
					if(!isset($actionapp) || strlen($actionapp)==0){
						throw new Exception('extension('.$extenName.')[anti-]action标记需有application属性');
					}
					/*$actiondata = $action->getAttribute('data');
					if(!isset($actiondata) || strlen($actiondata)==0){
						throw new Exception('extension('.$extenName.')[anti-]action标记需有data属性');
					}*/
				}
				else if(strcmp('expression',$actionTagName) == 0){
				}
				else {
					throw new Exception('extension('.$extenName.')condition非法子标记'.$actionTagName);
				}
			
                        
			}//foreach action
		}//foreach condition
	}//foreach extension
}
?>
