<?php
require_once(dirname(__DIR__) . "/Misc/document_access.php");

class Input{
	public function __construct(){}
	
	public static function get($name, $type = "post"){
		switch($type){
			case "post":
				if(isset($_POST[$name])){
					return ($_POST[$name]);
				}else{
					return "";
				}
			break;
			
			case "get":
				if(isset($_GET[$name])){
					return htmlspecialchars($_GET[$name]);
				}else{
					return "";
				}
			break;
			
			case "session":
				if(isset($_SESSION[$name])){
					return htmlspecialchars($_SESSION[$name]);
				}else{
					return "";
				}
			break;
			
			default:
				return "";
			break;
		}
		
		return "";
	}
}

?>