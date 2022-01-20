<?php


class Session {
	public static function get($name = "", $getObject = false){
		if(isset($_SESSION[$name])){
			if($getObject){
				return $_SESSION[$name];
			}else{
				if(isset($_SESSION[$name]->data)){
					$data = $_SESSION[$name]->data;
				
					if($_SESSION[$name]->temp){
						unset($_SESSION[$name]);
					}
					
					return $data;
				}else{
					return false;
				}
			}
		}else{
			return false;
		}
	}
	
	public static function set($name, $data, $temp = false){
		$_SESSION[$name] = (object)[
			"name"	=> $name,
			"data"	=> $data,
			"temp"	=> $temp
		];
	}
}