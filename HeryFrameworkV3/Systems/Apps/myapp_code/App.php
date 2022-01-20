<?php
header("Content-Type: text/plain");

Route::set("|home|index")->to("Home::index");
Route::set("about")->to(function(){
	return "hello";
});

Route::set("/contact-us")->to("User/ContactUs::index");

// Route::make("users")->to(function(){
	// Route::set("|list|all")->to("Users::list");
	// Route::set("add")->to("Users::add");
	// Route::set("edit")->to("Users::edit");
	// Route::set("delete")->to("Users::delete");
// });

// Route::make("items")->to(function(){
	// Route::set("|list|all")->to("Items::list");
	// Route::set("add")->to("Items::add");
	// Route::set("edit")->to("Items::edit");
	// Route::set("delete")->to("Items::delete");
// });

$page = new Page();
$page->addTopTag("");

Route::make("test")->to(function(){
	Route::set("|list|all")->to("Items::list");
	
	Route::make("add")->to(function(){
		Route::set("1:param")->to("Items::list1");
		Route::set("2")->to("Item/Item/Items::list2");
		
		Route::make("3")->to(function(){
			Route::set("3.1")->to("Items::list3.1");
			Route::set("3.2")->to("Items::list3.2");
		});
	});
});

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
			$x->setPage($page);
			$x->{$method}();
			
		}
	}
}

Session::destroy("Routes");