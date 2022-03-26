<?php
require_once(dirname(__DIR__) . "/Misc/document_access.php");

class Controller/*  implements IController */{
	public function __construct($routes = [], $set = []){
		
	}
	
	public $page;
	
	public function setPage($page){
		$this->page = $page;
	}
	
	public function redirect($path){
		header("Location: " . $path);
		exit();
	}
	
	public static function url($class){
		$path = F::Encode64(Encrypter::AESEncrypt($class, PASS, F::Decode64(IV)));
		
		return PORTAL . "" . $path;
	}
	
	public static function form($setting = []){
		 echo 
	        "<input type='hidden' name='OWASP_CSRFTOKEN' value='" . $_SESSION["IR"] . "' />",
	        "<input type='hidden' name='__HPF_POST_REQUEST__' value='" . F::UniqKey("POST_") . "' />"
			
	    ;
	    
	    foreach($setting as $key => $value){
	        echo "<input type='hidden' name='". $key ."' value='" . $value . "' />";
	    }
	}
}
?>