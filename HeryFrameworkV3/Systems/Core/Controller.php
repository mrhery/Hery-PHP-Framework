<?php
require_once(dirname(__DIR__) . "/Misc/document_access.php");

class Controller{
	public function __construct($action, $route = ""){
		if(isset($_POST["submit"])){
			if(Input::get("submit") == $_SESSION["IR"]){
				$this->Execute(Input::get("route"), $route);
				F::NewReqKey();
			}else{
				new Alert("error", "Request token has expired, please try again.");
			}
		}
	}
	
	public function Execute($path, $route = ""){
		$path = dirname(__DIR__) . "/App/Controller/" . $path . ".php";
		
		if(file_exists($path)){
			include_once($path);
		}else{
			echo "Form cannot be submit. There's an error at your form input or controller file cannot be read.";
		}
	}
	
}
?>