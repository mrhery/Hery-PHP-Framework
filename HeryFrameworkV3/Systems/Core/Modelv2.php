<?php

trait Modelv2{
	private static $table = __CLASS__;
	public static function list($setting = array()){
		$sql = "SELECT ";
		
		if(isset($setting["column"])){
			$sql .= $setting["column"] . " FROM ";
		}else{
			$sql .= "* FROM ";
		}
		
		if(empty(self::$table)){
			if(isset($setting["table"]) AND !empty($setting["table"])){
				$sql .= $setting["table"];
			}else{
				return false;
			}
		}else{
			$sql .= self::$table;
		}
		
		if(isset($setting["where"]) AND !empty($setting["where"])){
			$sql .= " WHERE " . $setting["where"];
		}
		
		if(isset($setting["group"]) AND !empty($setting["group"])){
			$sql .= " GROUP BY " . $setting["group"];
		}
		
		if(isset($setting["order"]) AND !empty($setting["order"])){
			$sql .= " ORDER BY " . $setting["order"];
		}
		
		if(isset($setting["limit"]) AND !empty($setting["limit"])){
			$sql .= " LIMIT " . $setting["limit"];
		}
		
		$x = DB::conn()->q($sql);
		
		return $x->results();
	}
	
	public static function getBy($column){
		$sql = "SELECT * FROM " . self::$table . " WHERE";
	
		$i = 0;
		foreach($column as $key => $value){
			if($i == 0){
				$sql .= " " . $key . " = ?";
			}else{
				$sql .= " AND " . $key . " = ?";
			}
			
			$i++;
		}
		
		$x = DB::conn()->query($sql, $column);
		
		return $x->results();
	}
	
	public static function insertInto($data){
		$x = DB::conn()->insert(self::$table, $data);
		
		return ($x->error() ? false : true);
	}
	
	public function deleteBy($data){
		$sql = "DELETE FROM " . self::$table . " WHERE";
		
		$i = 0;
		foreach($data as $key => $value){
			if($i == 0){
				$sql .= " " . $key . " = ? ";
			}else{
				$sql .= " AND " . $key . " = ?";
			}
			
			$i++;
		}
		
		$x = DB::conn()->query($sql, $data);
		
		return ($x->error() ? false : true);
	}
	
	public static function updateBy($where, $data){
		$sql = "UPDATE " . self::$table . " SET ";
		
		$i = 1;
		foreach($data as $key => $value){
			$sql .= " " . $key . " = ?";
			if($i < count($data)){
				$sql .= ", ";
			}
			
			$i++;
		}
		
		$sql .= " WHERE ";
		
		$i = 0;
		foreach($where as $key => $value){
			if($i == 0){
				$sql .= " " . $key . " = ?";
			}else{
				$sql .= " AND " . $key . " = ?";
			}
			
			$data[$key] = $value;
			$i++;
		}
		
		$x = DB::conn()->query($sql, $data);
		
		return ($x->error() ? false : true);
	}
}



















