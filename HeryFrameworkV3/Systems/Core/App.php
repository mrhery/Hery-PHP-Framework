<?php
class App{
	public $name, $config = [], $route, $body, $code;
	
	public function __construct($name = DEF_NAME, $code = "DEFAULT"){
		$this->name = $name;
		$this->code = $code;
		$this->route = Input::get("route");
		
		define("APP_CODE", $this->code);
		define("APP", APPS . APP_CODE . "/");
		define("VIEW", APP . "View/");
		define("CLASSES", APP . "Classes/");
		define("ASSET", APP . "Assets/");
		
		if(!is_dir(APPS . $code)){
			@mkdir(APPS . $code . "/Classes", 0777, true);
			@mkdir(APPS . $code . "/Controller", 0777, true);
			@mkdir(APPS . $code . "/View/", 0777, true);
			@mkdir(APPS . $code . "/Assets/", 0777, true);
			$o = fopen(APPS . $code . "/configure.php", "w+");
			fwrite($o, <<<'T'
<?php
#Misc Files
include_once(MISC . "asset_loader.php");

#Database Configuration
class Config{
	public static $host 	= "127.0.0.1";
	public static $database	= "";
	public static $username	= "";
	public static $password	= "";
}

#Define your web application URL
define("PORTAL", "http://localhost/");
T
);
			fclose($o);
			
			$o = fopen(APPS . $code . "/App.php", "w+");
			fwrite($o, <<<'T'
<?php
//A journey start with a step

T
);
			fclose($o);
		}
	}
	
	public function name($name = ""){
		$this->name = $name;
	}
	
	public function config($config = []){
		$this->config = $config;
	}
	
	public function route($route = ""){
		$this->route = $route;
	}
	
	public function body($body){
		$this->body = $body;
	}
	
	public function run(){
		//define("ROUTE", $this->route);
		include_once(APPS . $this->code . "/configure.php");
		include_once(APPS . $this->code . "/App.php");
		
		is_callable($this->body) ? call_user_func($this->body) : "";
	}
	
	public static function execute($app){
		call_user_func($app);
	}
}