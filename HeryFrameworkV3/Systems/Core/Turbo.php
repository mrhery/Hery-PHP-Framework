<?php

class Turbo{
	private static $instance = null, $app_code = "";
	public function __construct(){
		
	}
	
	public static function App($app_code = ""){
		if(empty($app_code)){
			throw new Exception("Please insert Application Code when using Turbo::App() method.");
		}
		
		self::$app_code = $app_code;
		
		if(!isset(self::$instance)){
			self::$instance = new Turbo();
		}
		
		return self::$instance;
	}
	
	public static function Constants($key = ""){
		if(empty($key)){
			throw new Exception("Please insert constant name on Constancts() method.");
		}
	}
	
	public static function Configure(){
		if(!file_exists(APPS . self::$app_code . "/configure.json")){
			throw new Exception("Configuration file not found or " . self::$app_code . " project is not correctly created.");
		}
		
		
	}
}