<?php
require_once(dirname(__DIR__) . "/Misc/document_access.php");

class Controller{
	public function __construct($action, $route = ""){
		if(isset($_POST["__SUBMIT__"])){
			if(Input::post("__SUBMIT__") == $_SESSION["IR"]){
				$this->Execute(Input::post("__ROUTE__"), $route);
				$_SESSION["IR"] = F::UniqKey();
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
	
	public static function Form($route = '', $setting = []){
	    echo 
	        "<input type='hidden' name='__SUBMIT__' value='" . $_SESSION["IR"] . "' />",
	        "<input type='hidden' name='__ROUTE__' value='" . $route . "' />"
	    ;
	    
	    foreach($setting as $key => $value){
	        echo "<input type='hidden' name='". $key ."' value='" . $value . "' />";
	    }
	}
	
	public static function FormAjax($route = "", $setting = []){
	    $_token = F::Encrypt(F::UniqKey("SUBMIT_FORM"));
	    $token = Token::create($_token, "form");
	    echo 
	        "<input type='hidden' id='api_route' value='" . $route . "' />",
	        "<input type='hidden' name='_token' value='" . $_token . "' />",
	        "<input type='hidden' name='token' value='" . $token . "' />"
	    ;
	    
	    foreach($setting as $key => $value){
	        echo "<input type='hidden' name='". $key ."' value='" . F::Encrypt($_token . $value) . "' />";
	    }
	}
}
?>