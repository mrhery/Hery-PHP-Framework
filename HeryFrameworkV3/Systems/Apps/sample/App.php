 <?php
//A journey start with a step

/*
## HPFv4 App:
File `App.php` in `Systems/Apps/app_code/App.php` is the first file that will be call everytime request made on the current app. In this file is where we set our Route for our web application.

Before routing any url route to specific Controller/View, we need to set a few things to make sure our view is correctly rendered.

1. Set the `page` for current app. In HPFv4 all pages (view) must be rendered by `Page` class. From this `page` instance is where we set the header, footer, mainmenu and other widgets as needed. You can access the app `page` instance from the `$this` variable like so:
```
$this->page->addTopTag('
	<!-- codes will be placed in between <head></head> HTML tag on every page. -->
');

$this->page->addBottomTag('
	<!-- codes will be placed before </body> HTML tag on every page. -->
');
```

You can always reset the `Page` instance if you want to set the header/footer different from the other page.
```
$this->page = new Page();
```

The `Page` inplmentation will be explain in `Controller`.

## HPFv4 Route:
Route used to routing url to specific Controller/View.

1. To route url `/home` to `HomeController` on `index()` method, you can do this:
```
Route::set("/home")->to("HomeController::index()");
```

2. To set multiple url `/home` & `/index` to the same controller `HomeController` on method `index()`, you can seperate the url using character `|` like this:
```
Route::set("/home|index")->to("HomeController::index()");
```

3. You can use nested route setting for sub url like these urls:
- https://domain.com/user
- https://domain.com/user/add
- https://domain.com/user/edit

You can do this:
```
Route::make("/user")->to(function(){
	Route::set("/")->to("UserController::index()"); 		// For first URL
	Route::set("/add")->to("UserController::add()"); 		// For second URL
	Route::set("/edit")->to("UserController::edit()"); 		// For third URL
});
```

4. To pass parameter, you can use `:param` setting at the url. Example:

`https://domain.com/user/edit/1` -> Number one at the end od the url is a parameter/input, you can read it using:

```
Route::set("/user/edit:param")->to(function(){
	echo url::get(2); // followed by index number of `/user/edit/:param` (seperated by slashes) start from 0
});
```
*/
$this->page->addTopTag('
	<!-- This is from top tag -->
');


$this->page->addBottomTag('
	<!-- This is bottom top tag -->
');

Route::set("/phpui")->to("PHPUiController::index");

Route::make("/test")->to(function(){
	Route::set("/a")->to(function(){
		return "test/a";
	});
	
	Route::set("/b:param")->to(function(){
		return "test/b";
	});
});

Route::set("/")->to("HomeController::index");

