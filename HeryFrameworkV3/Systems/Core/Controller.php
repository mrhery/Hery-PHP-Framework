<?php
require_once(dirname(__DIR__) . "/Misc/document_access.php");

class Controller{
	public function __construct($routes = [], $cross = false){
		if(isset($_POST["OWASP_CSRFTOKEN"])){
			if(Input::post("OWASP_CSRFTOKEN") == $_SESSION["IR"]){
				
				if(!$cross){
					if(in_array(Input::post("__ROUTE__"), $routes)){
						$this->Execute(Input::post("__ROUTE__"));
					}else{
						new Alert("error", "Requested route is not available in this context.");
					}
				}else{
					$this->Execute(Input::post("__ROUTE__"));
				}
				
				$_SESSION["IR"] = F::UniqKey();
			}else{
				new Alert("error", "Request token has expired, please try again.");
			}
		}
	}
	
	public function Execute($path){
		$path = dirname(__DIR__) . "/Apps/". APP_CODE ."/Controller/" . $path . ".php";
		
		if(!file_exists($path)){
			if(!is_dir(dirname($path))){
				mkdir(dirname($path), 0777, true);
			}
			
			file_put_contents($path, "This controller is empty");
		}
		
		include_once($path);
	}
	
	public static function Form($route = '', $setting = []){
	    echo 
	        "<input type='hidden' name='OWASP_CSRFTOKEN' value='" . $_SESSION["IR"] . "' />",
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