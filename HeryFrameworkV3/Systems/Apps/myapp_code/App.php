<?php
//A journey start with a step

// echo Url::get(0);

// Route::set("/")->to(function(){
	// return "A";
// });
header("Content-Type: text/plain");

Route::fix("users")->to(function(){
	Route::set("|list|all")->to("Users::list");
	Route::set("add")->to("Users::add");
	Route::set("edit")->to("Users::edit");
	Route::set("delete")->to("Users::delete");
});

Route::fix("items")->to(function(){
	Route::set("/|list|all")->to("Items::list");
	Route::set("add")->to("Items::add");
	Route::set("edit")->to("Items::edit");
	Route::set("delete")->to("Items::delete");
});

print_r(Session::get("routes"));

echo hash("sha256", serialize($_SESSION["routes"]));


// $page = function(){
	// echo  "a";
// };

// echo gettype($page);

// $page();


