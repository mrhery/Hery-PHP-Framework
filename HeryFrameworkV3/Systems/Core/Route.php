<?php

class Route {
	private static $_instance = null;
	public $routes = [];
	
	private $parentUrl = "";
	private $currentUrl = "";
	
	public static function all(){
		return Session::get("Routes")->data;
	}
	
	public static function controller(){
		$data = self::all();
		
		$urls = url::get("array");
		$surl = url::get("path");
		$key = "";
		$kf = "";
		$found = false;
		
		foreach($urls as $url){			
			if(!empty($key)){
				$key .= "/";
			}
			
			$key .= $url;
			
			// echo $key . "\n";
			
			if(isset($data[$key])){
				$found = true;
				$kf = $key;
			}
		}
		
		if(!$found){
			
			return false;
		}else{
			if($surl != $kf){
				echo "";
				if(self::all()[$kf]->param){
					return [$kf => self::all()[$kf]];
				}else{
					return false;
				}
			}else{
				
				return [$kf => self::all()[$kf]];
			}
		}
	}
	
	public static function set($url = ""){
		if(self::$_instance == null){
			self::$_instance = new Route();
		}
		
		self::$_instance->currentUrl = $url;
		
		return self::$_instance;
	}
	
	public static function make($url = ""){
		if(self::$_instance == null){
			self::$_instance = new Route();
		}

		self::$_instance->parentUrl .= $url . "/";
		self::$_instance->currentUrl = $url;
		
		return self::$_instance;
	}
	
	public function to($action){
		$type = gettype($action);
		
		switch($type){
			case "string": case "int":
				$gkey = "";
				$key = "";
				
				if(!empty($this->parentUrl)){
					$key .= trim($this->parentUrl, "/") . "/";
				}
				
				$curl = trim($this->currentUrl, "/");
				
				if(strpos($curl, "|") > -1){
					$x = explode("|", $curl);
					
					foreach($x as $y){
						$xkey = trim($key . $y, "/");
						
						if(strpos($xkey, ":param") > -1){
							$xkey = str_replace(":param", "", $xkey);
							
							$data[$xkey] = (object)[
								"action"	=> $action,
								"param"		=> true
							];
						}else{
							$data[$xkey] = (object)[
								"action"	=> $action,
								"param"		=> false
							];
						}
						
						$gkey = $xkey;
					}
				}else{
					$key .= trim($this->currentUrl, "/");
					
					if(strpos($key, ":param") > -1){
						$key = str_replace(":param", "", $key);
						
						$data[$key] = (object)[
							"action"	=> $action,
							"param"		=> true
						];
					}else{
						$data[$key] = (object)[
							"action"	=> $action,
							"param"		=> false
						];
					}

					$gkey = $key;					
				}
				
				if(strpos($action, "::") < 1){
					$data[$gkey]->text = true;
				}
				
				Session::get("Routes")->append($data);
			break;
			
			case "object":				
				$a = $action();
				
				if(gettype($a) != "object"){
					$this->to($a);
				}
			break;
		}
	}
}