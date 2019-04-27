<?php
require_once(dirname(__DIR__) . "/Misc/document_access.php");

class Input{
	public function __construct(){}
	
	public static function get($name){
		if(isset($_GET[$name])){
			return htmlspecialchars($_GET[$name]);
		}else{
			return "";
		}
	}
	
	public static function post($name){
		if(isset($_POST[$name])){
			return htmlspecialchars($_POST[$name]);
		}else{
			return "";
		}
	}
}

?>