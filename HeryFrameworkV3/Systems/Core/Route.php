<?php

class Route {
	private static $_instance = null;
	public $routes = [];
	
	private $parentUrl = "";
	private $currentUrl = "";
	
	public static function set($url = ""){
		if(self::$_instance == null){
			self::$_instance = new Route();
		}
		
		if(empty(self::$_instance->parentUrl)){
			self::$_instance->parentUrl = $url;
		}
		
		self::$_instance->currentUrl = $url;
		
		return self::$_instance;
	}
	
	public static function fix($url = ""){
		if(self::$_instance == null){
			self::$_instance = new Route();
		}

		self::$_instance->parentUrl = $url;
		self::$_instance->currentUrl = $url;
		
		return self::$_instance;
	}
	
	
	public function to($action){
		$type = gettype($action);
		
		switch($type){
			case "string": case "int":
				
				$_SESSION["routes"]
					[
						$this->parentUrl . "/" . 
						trim($this->currentUrl, "/")
					] = $action;
			break;
			
			case "object":				
				$action();
			break;
		}
	}
}