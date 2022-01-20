<?php

class Session {
	private static $_instance = null;
	public $data = null;
	public $name = "";
	public $version = "";
	public $setting = [];
	
	public function __construct($name){
		if(isset($_SESSION[$name])){
			$this->data = $_SESSION[$name]->data;
			$this->name = $name;
			$this->version = $_SESSION[$name]->version;
			$this->setting = $_SESSION[$name]->setting;
			
			return $this;
		}else{
			return false;
		}
	}
	
	public static function get($name = "", $getObject = false){
		if(is_null(self::$_instance)){
			self::$_instance = new Session($name);
		}
		
		if(self::$_instance !== false){
			return self::$_instance;
		}else{
			return false;
		}
	}
	
	public static function update($name, $data){
		$session = self::get($name);
		
		if($session !== false){
			$session->data = $data;
			$session->save();
		}else{
			return false;
		}
	}
	
	public static function setting($name, $data){
		$session = self::get($name);
		
		if($session !== false){
			$session->setting = $data;
			$session->save();
		}else{
			return false;
		}
	}
	
	private function save(){
		$_SESSION[$name] = (object)[
			"name"		=> $this->name,
			"data"		=> $this->data,
			"version"	=> F::version($this->data),
			"setting"	=> $this->setting
		];
	}
	
	public static function create($name, $data, $set = []){
		if(isset($_SESSION[$name])){
			return false;
		}else{
			echo "asdsaddsa";
			$_SESSION[$name] = (object)[
				"name"		=> $name,
				"data"		=> $data,
				"version"	=> F::version($data),
				"setting"	=> $set
			];
			
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
}