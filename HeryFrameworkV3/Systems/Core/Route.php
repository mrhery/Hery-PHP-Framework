<?php

class Route {
	private static $_instance = null;
	public $routes = [];
	
	private $parentUrl = "";
	private $currentUrl = "";
	private $makeUrl = "";
	
	public static function all(){
		return Session::get("Routes")->data;
	}
	
	public static function controller(){
		$data = self::all();
		
		// print_r($data);
		
		$urls = url::get("array");
		$surl = url::get("path");
		$surl = empty($surl) ? "/" : $surl;
		$key = "";
		$kf = "";
		$found = false;
		
		// print_r($urls);
		
		foreach($urls as $url){
			$url = empty($url) ? "/" : $url;
			
			if(!empty($key)){
				$key .= "/";
			}
			
			$key .= $url;
			
			// echo "key:" . $key . ".endKey\n";
			
			if(isset($data[$key])){
				$found = true;
				$kf = $key;
			}
			
			// break;
		}
		
		// header("Content-Type: text/plain");
		// print_r([
			// "found"	=> $found,
			// "kf"	=> $kf
		// ]);		
		// print_r($data);		
		// print_r($data[""]);		
		// die();
		
		if(!$found){
			if(isset($data[""])){
				if($data[""]->param){
					$found = true;
					$kf = "";
				}
			}
		}
		
		// print_r($found);
		
		if(!$found){
			if(isset($data["404-not-found"])){
				return ["404-not-found" => self::all()["404-not-found"]];
			}
		}
		
		if(!$found){
			return false;
		}else{
			if($surl != $kf){
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
		
		// self::$_instance->parentUrl = "";
		self::$_instance->currentUrl = $url;
		
		return self::$_instance;
	}
	
	public static function make($url = ""){
		// if(self::$_instance == null){
		self::$_instance = new Route();
		self::$_instance->makeUrl = $url;
		// }

		self::$_instance->parentUrl = $url;
		self::$_instance->currentUrl = $url;
		
		return self::$_instance;
	}
	
	public function to($action){
		$type = gettype($action);
		$data = [];
		switch($type){
			case "string": case "int":
				$gkey = "";
				$key = "";
				
				if(!empty($this->parentUrl)){
					// echo "Ada";
					$key .= trim($this->parentUrl, "/") . "/";
				}
				
				$curl = trim($this->currentUrl, "/");
				
				// echo $curl;
				
				if(strpos($curl, "|") > -1){
					$x = explode("|", $curl);
					
					foreach($x as $y){
						$xkey = trim($key . $y, "/");
						
						if(strpos($xkey, ":param") > -1){
							$xkey = str_replace(":param", "", $xkey);
							$xkey = empty($xkey) ? "/" : $xkey;
							
							$data[$xkey] = (object)[
								"action"	=> $action,
								"param"		=> true
							];
						}else{
							$xkey = empty($xkey) ? "/" : $xkey;
							
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
						
						$key = empty($key) ? "/" : $key;
						
						$data[$key] = (object)[
							"action"	=> $action,
							"param"		=> true
						];
					}else{
						$key = trim($key, "/");
						$key = empty($key) ? "/" : $key;
						
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
				
				// echo "========Data========\n";
				// print_r($data);
				// echo "========End Data========\n";
				
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
	
	public static function create($d){
		if(is_array($d)){
			foreach($d as $k => $v){				
				if(is_array($v)){
					foreach($v as $sk => $sv){
						$param = false;
				
						if(strpos($sk, ":param") > -1){
							$param = true;
						}
						
						if(strpos($sk, "|") > -1){
							$ks = explode("|", $sk);
							
							foreach($ks as $kx){
								$kx = $k . "/" . $kx;
								$kx = trim($kx, "/");
								$k = str_replace(":param", "", $kx);
								$kx = empty($kx) ? "/" : $kx;
								
								$data[$kx] = (object)[
									"action"	=> $sv,
									"param"		=> $param
								];
								Session::get("Routes")->append($data);
							}
						}else{
							$sk = $k . "/" . $sk;
							$sk = trim($sk, "/");
							$sk = empty($sk) ? "/" : $sk;
							$sk = str_replace(":param", "", $sk);
							
							$data[$sk] = (object)[
								"action"	=> $sv,
								"param"		=> $param
							];
							Session::get("Routes")->append($data);
						}
					}
				}else{
					$param = false;
				
					if(strpos($k, ":param") > -1){
						$param = true;
					}
					
					if(strpos($k, "|") > -1){
						$ks = explode("|", $k);
						
						foreach($ks as $kx){
							$kx = trim($kx, "/");
							$kx = str_replace(":param", "", $kx);
							$kx = empty($kx) ? "/" : $kx;
							
							$data[$kx] = (object)[
								"action"	=> $v,
								"param"		=> $param
							];
							Session::get("Routes")->append($data);
						}
					}else{
						$k = trim($k, "/");
						$k = empty($k) ? "/" : $k;
						$k = str_replace(":param", "", $k);
						
						$data[$k] = (object)[
							"action"	=> $v,
							"param"		=> $param
						];
						Session::get("Routes")->append($data);
					}	
				}				
			}
		}
	}
}