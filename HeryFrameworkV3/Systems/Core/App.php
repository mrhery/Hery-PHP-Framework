<?php
class App{
	public $name, $config = [], $route, $body, $code;
	
	public $page;
	
	public function __construct($name = DEF_NAME, $code = "DEFAULT"){
		$this->name = $name;
		$this->code = $code;
		$this->route = Input::get("route");		
		$this->page = new Page();
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
	
	public function run($set = []){		
		define("APP_CODE", $this->code);
		define("APP_NAME", $this->name);
		define("APP", APPS . APP_CODE . "/");
		define("VIEW", APP . "View/");
		define("CLASSES", APP . "Classes/");
		
		if(!defined("ASSET")){
			define("ASSET", APP . "Assets/");
		}
		
		if(!is_dir(APPS . $this->code)){
			@mkdir(APPS . $this->code . "/Classes", 0777, true);
			@mkdir(APPS . $this->code . "/Controller", 0777, true);
			@mkdir(APPS . $this->code . "/View/", 0777, true);
			@mkdir(APPS . $this->code . "/Vendor/", 0777, true);
			
			file_put_contents(APPS . $this->code . "/Classes/index.php", "<?php\n//written by hpf");
			file_put_contents(APPS . $this->code . "/Controller/index.php", "<?php\n//written by hpf");
			file_put_contents(APPS . $this->code . "/View/index.php", "<?php\n//written by hpf");
			file_put_contents(APPS . $this->code . "/Vendor/index.php", "<?php\n//written by hpf");
			
			file_put_contents(APPS . $this->code . "/database.php", <<<'CODE'
<?php
//Place you database setup here

/*
//Example:
DB::prep()->table("users", function(Table $table){
	$table->varchar("name")->length(100);
	$table->email("email")->rename("emails");
	$table->phone("phone")->length(5);
	$table->password("password")->drop();
	$table->time("upadateTime");
});

DB::prep()->table("users", function(Table $table){
	$table->drop();
});

*/
CODE
);
			
			file_put_contents(APPS . $this->code . "/setup.php", <<<'CODE'
<?php
if(!Session::exist("Routes")){
	Session::create("Routes", [], ["writeToFile" => true]);
}

CODE
);

			$iv = F::Encode64(Encrypter::CreateIv());
			$pass = hash("md5", F::UniqKey());
			
			$o = fopen(APPS . $this->code . "/configure.json", "w+");
			fwrite($o, <<<T
{
	"databases": [
		{
			"host": "127.0.0.1",
			"database": "",
			"username": "",
			"password": ""
		}
	],
	"constants": [
		{
			"PORTAL": 	"http://localhost/"
		},
		{
			"IV": "$iv"
		},
		{
			"PASS": "$pass"
		}
	],
	"miscs": [
		"asset_loader.php"
	],
	"headers": []
}
T
);
			fclose($o);
			
			$o = fopen(APPS . $this->code . "/App.php", "w+");
			fwrite($o, <<<'T'
<?php
//A journey start with a step

Route::set("")->to(function(){
	return "Hi from HPF!";
});
T
);
			fclose($o);
		}
		
		if(file_exists(APPS . $this->code . "/configure.json")){
			$json = file_get_contents(APPS . $this->code . "/configure.json");
			$obj = json_decode($json);
			
			if(isset($obj->miscs)){
				foreach($obj->miscs as $misc){
					include_once(MISC . $misc);
				}
			}
			
			if(isset($obj->constants)){
				foreach($obj->constants as $value){
					$value = (array)$value;
					if(!defined(key($value))){
						define(key($value), $value[key($value)]);
					}
				}
			}
			
			if(isset($obj->headers)){
				foreach($obj->headers as $header){
					header($header);
				}
			}
		}
		
		include_once(APPS . $this->code . "/setup.php");
		
		if(isset($set["reload"]) && $set["reload"]){
			include_once(APPS . $this->code . "/database.php");
		
			DB::prep()->reload();
		}
		
		if(isset($_POST["__HPF_POST_REQUEST__"])){
			$path = url::get("path");
			
			$classx = Encrypter::AESDecrypt(F::Decode64($path), PASS, F::Decode64(IV));
			
			$class = explode("::", $classx)[0];
			$method = explode("::", $classx)[1];
			$file = APP . "Controller/" . $class . ".php";
			
			if(!file_exists($file)){
				throw new Exception("Controller ". $class ." does not exists.");
			}else{
				include_once($file);
			
				$x = new $class;
				
				if(method_exists($class, $method)){
					$x->{$method}();
				}else{
					throw new Exception("Method ". $method ." does not exists in Controller ". $class .".");
				}
			}
			
			exit();
		}
		
		include_once(APPS . $this->code . "/App.php");
		
		$data = Route::controller();

		if(!$data){
			echo "Route not found";
		}else{
			foreach($data as $k => $value){
				if(isset($value->text) && $value->text){
					echo $value->action;
				}else{
					$class = explode("::", $value->action)[0];
					$method = explode("::", $value->action)[1];
					
					$file = APP . "Controller/" . $class . ".php";
					$folder = dirname($file);
					$class = basename($class);
					
					if(!file_exists($file)){
						if(!is_dir($folder)){
							mkdir($folder, 0777, true);
						}
						
						$o = fopen($file, "w+");
						fwrite($o, <<<CODE
<?php

class $class extends Controller {
	public function __construct() {}
	
	public function $method (){
		
	}
}

CODE
);
						fclose($o);
					}
					
					include_once($file);
					$x = new $class;
					
					if(!is_null($this->page)){
						$x->setPage($this->page);
					}
					
					if(method_exists($class, $method)){
						$x->{$method}();
					}else{
						throw new Exception("Method " . $method . " does not exists in Controller " . $class . ".");
					}
				}
			}
		}
		
		Session::destroy("Routes");
		
		is_callable($this->body) ? call_user_func($this->body) : "";
	}
	
	public static function execute($app){
		call_user_func($app);
	}
}





















