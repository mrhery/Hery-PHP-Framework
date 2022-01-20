<?php
// header("Content-Type: text/plain");

Route::set("|home|index")->to("Home::index");
Route::set("about")->to(function(){
	return "hello";
});

Route::set("/contact-us")->to("User/ContactUs::index");
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



