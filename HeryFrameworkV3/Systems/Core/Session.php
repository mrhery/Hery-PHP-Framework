<?php

class Session {
	private static $_instance = null;
	public $data = null;
	public $name = "";
	public $version = "";
	public $setting = [];
	
	public function __construct($name){
		// echo $name;
		if(isset($_SESSION[$name])){
			$this->data = $_SESSION[$name]->data;
			$this->name = $name;
			$this->version = $_SESSION[$name]->version;
			$this->setting = $_SESSION[$name]->setting;
			
			return $this;
		}else{
			$this->name = $name;
			return $this;
		}
	}
	
	public static function get($name = "", $getObject = false){
		if(!isset($_SESSION[$name])){
			return false;
		}
		
		self::$_instance = new Session($name);
		
		if(self::$_instance !== false){
			return self::$_instance;
		}else{
			return false;
		}
	}
	
	public static function update($name = null, $data = null){
		if(!is_null($data)){
			$session = self::get($name);
		
			if($session !== false){
				$session->data = $data;
				$session->save();
				
				return true;
			}else{
				return false;
			}
		}else{
			$data = $name;
			self::$_instance->data = $data;
			self::$_instance->save();
			
			return self::$_instance;
		}
	}
	
	public static function append($name = null, $data = null){
		if(!is_null($data)){
			$session = self::get($name);
		
			if($session !== false){
				if(is_array($session->data)){
					$session->data[] = $data;
					$session->save();
				
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			$data = $name;
			
			if(is_array(self::$_instance->data)){
				
				if(is_array($data)){
					foreach($data as $k => $v){
						self::$_instance->data[$k] = $v;
					}
				}else{
					self::$_instance->data[] = $data;
				}
				
				self::$_instance->save();
				
				return self::$_instance;
			}else{
				self::$_instance->data .= $data;
				self::$_instance->save();
				return self::$_instance;
			}
		}
	}
	
	public static function destroy($name = null){
		if(!is_null($name)){
			if(isset($_SESSION[$name])){
				unset($_SESSION[$name]);
				
				return true;
			}else{
				return false;
			}
		}else{
			if(isset($_SESSION[self::$_instance->name])){
				unset($_SESSION[self::$_instance->name]);
				
				return true;
			}else{
				return false;
			}
		}
	}
	
	public static function setting($name = null, $data = null){
		if(!is_null($data)){
			$session = self::get($name);
		
			if($session !== false){
				$session->setting = $data;
				$session->save();
			}else{
				return false;
			}
		}else{
			$data = $name;
			self::$_instance->setting = $data;
			self::$_instance->save();
			
			return self::$_instance;
		}
	}
	
	private function save(){
		$_SESSION[$this->name] = (object)[
			"name"		=> $this->name,
			"data"		=> $this->data,
			"version"	=> F::version($this->data),
			"setting"	=> $this->setting
		];
		
		if(isset($this->setting["writeToFile"]) && (bool)$this->setting["writeToFile"]){
			// echo APP;
		}
	}
	
	//KIV
	private function writeSession($overwrite = ""){
		$path = APP . "Sessions";
		
		if(!is_dir($path)){
			mkdir($path, 0777, true);
		}
		
		$file = $path . "/" . $this->version;
		
		$o = fopen($file, "wb");
		fwrite($o, serialize($this->data));
		fclose($o);
	}
	
	public static function create($name, $data, $set = []){
		if(isset($_SESSION[$name])){
			return false;
		}else{
			$_SESSION[$name] = (object)[
				"name"		=> $name,
				"data"		=> $data,
				"version"	=> F::version($data),
				"setting"	=> $set
			];
			
			if(isset($set["writeToFile"]) && (bool)$set["writeToFile"]){
				// echo APP;
			}
			
			return self::get($name);
		}
	}
	
	public static function exist($name){
		if(isset($_SESSION[$name])){
			return true;
		}else{
			return false;
		}
	}
	
	public static function destroyAll(){
		session_destroy();
	}
}