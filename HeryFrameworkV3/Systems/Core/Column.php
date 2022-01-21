<?php

class Column {
	public $type, 
		$default = "", 
		$increment = false, 
		$primary = false,
		$length = 255,
		$name = "",
		$nulled = false,
		$rename = "",
		$drop = false;
		
	private $table, $conn;
	
	public function __construct($name, $table){
		$this->name = $name;
		$this->table = $table;
	}
	
	public function exists(){
		if(!empty($this->rename)){
			$q = DB::conn()->query("SELECT column_name FROM information_schema.columns WHERE table_schema = ? AND table_name = ? AND column_name = ?", [
				$this->table->db->dbname,
				$this->table->name,
				$this->rename
			]);
			
			if($q->count() > 0){
				$this->name = $this->rename;
				return true;
			}else{
				return false;
			}
		}else{
			$q = DB::conn()->query("SELECT column_name FROM information_schema.columns WHERE table_schema = ? AND table_name = ? AND column_name = ?", [
				$this->table->db->dbname,
				$this->table->name,
				$this->name
			]);
			
			if($q->count() > 0){
				return true;
			}else{
				return false;
			}
		}
	}
	
	public function type($type){
		$this->type = $type;
		
		return $this;
	}
	
	public function default($default){
		$this->default = $default;
		
		return $this;
	}
	
	public function increment(){
		$this->increment = true;
		
		return $this;
	}
	
	public function primary(){
		$this->increment = true;
		
		return $this;
	}
	
	public function length($value){
		$this->length = $value;
		
		return $this;
	}
	
	public function nulled(){
		$this->nulled = true;
		
		return $this;
	}
	
	public function rename($name){
		$this->rename = $name;
	}
	
	public function drop(){
		$this->drop = true;
	}
	
	public function build(){
		$sql = "";
		
		$name = $this->name;
		
		if(!empty($this->rename)){
			$name = $this->rename;
		}
		
		switch($this->type){
			case "varchar":
				$sql .= $name . " VARCHAR(". $this->length .") ";
			break;
			
			case "text":
				$sql .= $name . " TEXT ";
			break;
			
			case "integer":
				$sql .= $name . " INT(". $this->length .") ";
				
				if($this->increment){
					$sql .= "AUTO_INCREMENT ";
				}
			break;
			
			case "double":
				$sql .= $name . " INT(". $this->length .") ";
			break;
			
			case "date":
				$sql .= $name . " DATE ";
			break;
			
			case "timestamp":
				$sql .= $name . " timestamp ";
				
				if(!empty($this->default)){
					$sql .= $this->default . " ";
				}else{
					$sql .= "DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ";
				}
				
			break;
		}
		
		if($this->primary){
			$sql .= "PRIMARY KEY ";
		}
		
		if(!$this->nulled){
			$sql .= "NOT NULL ";
		}
		
		return $sql;
	}
}

