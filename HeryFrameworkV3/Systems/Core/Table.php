<?php

class Table {
	public $db = null;
	public $name;
	private $columns = [];
	public $drop = false;
	public $prefix = "";
	
	public function __construct($name, $conn){
		$this->name = $name;
		$this->db = $conn;
	}
	
	public function exists(){
		$q = $this->db->query("SELECT table_name FROM information_schema.tables WHERE table_schema = ? AND table_name = ?", [$this->db->dbname, $this->name]);
		
		if($q->count() > 0){
			return true;
		}else{
			return false;
		}
	}
	
	public function setPrefix($prefix = ""){
		$this->prefix = $prefix;
	}
	
	public function varchar($name, $value = "255"){
		$col = new Column($name, $this);
		$col->type("varchar");
		$col->length($value);
		
		$this->columns[$name] = $col;
		
		return $this->columns[$name];
	}
	
	public function integer($name, $value = 10){
		$col = new Column($name, $this);
		$col->type("integer");
		$col->length($value);
		
		$this->columns[$name] = $col;
		
		return $this->columns[$name];
	}
	
	public function double($name, $value = 10){
		$col = new Column($name, $this);
		$col->type("double");
		$col->length($value);
		
		$this->columns[$name] = $col;
		
		return $this->columns[$name];
	}
	
	public function date($name){
		$col = new Column($name, $this);
		$col->type("date");
		
		$this->columns[$name] = $col;
		
		return $this->columns[$name];
	}
	
	public function time($name, $format = "H:i:s"){
		$col = new Column($name, $this);
		$col->type("timestamp");
		
		$this->columns[$name] = $col;
		
		return $this->columns[$name];
	}
	
	public function text($name){
		$col = new Column($name, $this);
		$col->type("text");
		
		$this->columns[$name] = $col;
		
		return $this->columns[$name];
	}
	
	public function build(){
		$sql = "";
		if($this->exists()){
			if($this->drop){
				$sql = "DROP TABLE " . $this->name . "; ";
			}else{
				$sql = "ALTER TABLE " . $this->name . " ";
			
				$sc = "";
				
				foreach($this->columns as $col){
					if(!empty($sc)){
						$sc .= ", ";
					}
					
					if($col->exists()){
						if($col->drop){
							$sc .= "DROP " . $this->prefix . $col->name . " ";
						}else{
							$sc .= "CHANGE " . $this->prefix . $col->name . " " . $this->prefix . $col->build();
						}
					}else{
						$sc .= "ADD " . $this->prefix . $col->build();
					}
				}
				
				$sql .= $sc . ";";
			}
		}else{
			if(!$this->drop){
				$sql = "CREATE TABLE " . $this->name . " (". $this->prefix ."id INT NOT NULL PRIMARY KEY AUTO_INCREMENT";
			
				foreach($this->columns as $col){
					if(!empty($sql)){
						$sql .= ", ";
					}
					
					$sql .= $this->prefix . $col->build();
				}
				
				$sql .= ");";
			}
		}
		
		// echo $sql;
		
		return $sql;
	}
	
	public function columns(){
		return $this->columns;
	}
	
	public function drop(){
		$this->drop = true;
	}
	
	public function get($column){
		if(isset($this->columns[$column])){
			return $this->columns[$column];
		}else{
			return false;
		}
	}
	
	public function email($name, $value = "255"){
		return $this->varchar($name, "100");
	}
	
	public function phone($name, $value = "255"){
		return $this->varchar($name, "25");
	}
	
	public function password($name, $value = "255"){
		return $this->varchar($name, "100");
	}
}
