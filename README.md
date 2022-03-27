
# Hery PHP Framework (HPF) version 4
HPF is a small PHP Framework to develop a web with routing page, modelling class from database (etc.) easier. 

HPF version 4 support multi application in one Framework directory. And it support "Turbo" to travel file from another app to another app (include run PHP file from another app).

## Update from HPFv3.2
- Controller is not just form control
- Route class to routing url to controller
- Design your database table using PHP #nomoresqlfile
- Temporary session for message box

# Where to Start?
## Installation Process
HPF is very small and easy to install. Download and extract the HPFv3.2, copy **HeryFrameworkV3** folder and paste into your `public_html` directory.  Make sure your apache setting enable `.htaccess` file. That's it, you are ready to go!

## Knowing the Basic - Do's & Dont's!
As the HPFv4 support multi application, so inside the framework folder will have `Apps` directory which is contains all available application directory.

Now open the `Apps` directory (inside the framework folder), you can see the `Apps.php` file. This file will contains all of your available application. After declaring or start your application instance, a directory will be automatically created (named of your application code) for your application which will contain the `Classes`, `View`, `Controller` and `Assets` directory. And also it contain `App.php` file (the main routing file) and `configure.json` file (contain database information and shared information).

# Understandig the Structure
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

## HPFv4 Database
In previous HPF version you need to always drop all the table and re-import the `.sql` file. So in this HPFv4 has a new feature which allows you to edit your database table structure without drop and re-import the `.sql` file. 

This is the example how you can create you table sturucture:
```
DB::prep()->table("users", function(Table $table){
	$table->varchar("name")->length(100);
	$table->email("email")->rename("emails");
	$table->phone("phone")->length(5);
	$table->integer("age")->length(5);
	$table->password("password")->drop();
	$table->time("upadateTime");
});
```

To drop a table, you can do this:
```
DB::prep()->table("users", function(Table $table){
	$table->drop();
});
```

To run this code, you need to put `true` to `reload` setting in you App Instanciation. By default this instacition is inside you `index.php` file.

Example:
```
$a = new App("App Name", "app_code");
$a->run(["reload" => true]);
``` 

Or for inline:
```
(new App("App Name", "app_code"))->run(["reload" => true])
```


Remember to set you database connection setting first in `confirgure.json` file.

For current HPFv4 version is not support auto joining table yet. Will be updated in future.

## HPFv4 Route:
Route used to routing url to specific Controller/View.

1. To route url `/home` to `HomeController` on `index()` method, you can do this:
```
Route::set("/home")->to("HomeController::index");
```

2. To set multiple url `/home` & `/index` to the same controller `HomeController` on method `index()`, you can seperate the url using character `|` like this:
```
Route::set("/home|index")->to("HomeController::index");
```

3. You can use nested route setting for sub url like these urls:
- https://domain.com/user
- https://domain.com/user/add
- https://domain.com/user/edit

You can do this:
```
Route::make("/user")->to(function(){
	Route::set("/")->to("UserController::index"); 		// For first URL
	Route::set("/add")->to("UserController::add"); 		// For second URL
	Route::set("/edit")->to("UserController::edit"); 		// For third URL
});
```

4. To pass parameter, you can use `:param` setting at the url. Example:

`https://domain.com/user/edit/1` -> Number one at the end od the url is a parameter/input, you can read it using:

```
Route::set("/user/edit:param")->to(function(){
	echo url::get(2); // followed by index number of `/user/edit/:param` (seperated by slashes) start from 0
});
```

## HPFv4 Controller:
Every controller must extends from `Controller` class.

1. Rendering a Page
To Render a view or a page, you can run this code in your method:
```
$this->page->title = "Home " . APP_NAME;	// Set the page title (at the tab)
$this->page->loadPage("home");				// Set the path to your view file, will be auto created in your View directory
$this->page->render();						// To render everything and put your page in between header and footer
```

2. Redirecting page
To resirect from one page/view to another page or url, you can use this:
```
$this->redirect("https://gooel.com");	//To redirect to external URL
$this->redirect(PORTAL . "user/edit");	//To redirect to internal URL
```

3. JSON Response
To response a json you can use this:
```
$data = ["a" => 1, "b" => 1];

$this->json($data);
```

4. Access route paramater
You can access any part of the url using `Url` class. Example, your URL is `https://domain.com/user/edit/1`, to access data from this url is like so:
```
echo Url::get(0); // will return `user`
echo Url::get(1); // will return `edit`
echo Url::get(2); // will return `1`
```
Basically what `Url::get()` method done is converting the Url path to an array so it accessible using index number start from 0.

## HPFv4 Form Control
To make a request froma form to specific `Controller` you can do like this:

1. Put this code in `action=''` form attribute:
```
Controller::url("TestController::index()"); // This method will generate an encrypted string to make it unreadable by human being even thanos can't read it.
```

2. Put this code before closing the form tag:
```
Controller::form(); // This line will automatically generate a secure token to avoid CSRF attack.
```

But before that, you need to make that your `PORTAL` constant in `configure.json` has been setup correctly or the request will be redirected to wrong URL.

Full example:
```
<form action="<?= Controller::url("TestController::index") ?>" method="POST"> 
	<input type="text" name="data" />
	<button>
		Send
	</button>
	
<?php
	Controller::form();
?>
</form>
```

## Start using Database
In HPF, developer has many way to connect with your data in database and even HPF allow a developer to create their own database connection manually - procedural and object-oriented. HPF recommended using it's own database class to maintain flexibility, usability and security. 

In HPF, there are 3 ways to fetch data from database.

### 1. Automatic Table Class Modelling (Recommended) - Modelv2 Class
In HPF v3, it support calling table name as a `class`. This method is recommended as it can make development easier rather than creatin class on every table in database. But make sure the table name not the same as `class` name available in all Core, Model & Classes directory. It is recommended to put the prefix on the table name like `a_users`, `a_items` etc.

The `Modelv2` is a **trait**, it's a class trait which is use in the auto-generated class on table name. The `Modelv2` trait has some method can be use. (Notice: all trait are **static**, no instance required.)

Modelv2 Trait
Example table name: users (from database)

1. List([$setting:array]) : array
```
$u = users::list();

//order by
$u = users::list(["order" => "colum_id DESC"]);

//group by
$u = users::list(["group" => "colum_group"]);

//limit
$u = users::list(["limit" => 5]);

//Combining everything:
$u = users::list([
	"order" => "colum_id DESC",
	"group" => "colum_group",
	"limit" => 5
]);

print_r($u); //return as array
```

2. GetBy([$column:array]) : array
To select specific data with simply `equals` sign `=`, 

```
$u = users::getBy([
	"column_one"	=> "value1",
	"column_two"	=> "value2"
]);

print_r($u); //return as array
```

3. InsertInto([$column:array]) : boolean
To insert data, you can do:
```
$u = users::insertInto([
	"column_one"	=> "value1",
	"column_two"	=> "value2"
]);

print_r($u); //return as boolean
```

5. UpdateBy([$where:array], [$column:array]) : boolean
To update data, 
```
$u = users::updateBy([
	"where_column_1"		=> "value1",
	"where_column_2"	=> "value2"
],[
	"column_3"	=> "new_value_1",
	"column_4"	=> "new_value_2"
]);

print_r($u); //return as boolean
```

6. DeleteBy([$where:array]) : boolean
```
$u = users::deleteBy([
	"column_one"	=> "value1",
	"column_two"	=> "value2"
]);

print_r($u); //return as boolean
```

All the above method available in `Modelv2` trait class which is auto-generated and can be use with any of table name available in database. These method are SQLi Proof unless the `list()` method still has lack of security matter, it can only use internally but not recommended for user-input varible for it's setting.

### 2. Manual SQL Command (available in HPFv2) - DB Class
The `DB` class are the core SQL engine in HPF. All class modelling are depending on this class. Failing to maintain this class security can be breach the whole application. In this `DB` class, there are to way to run up the SQL command, first is data-bidned SQL Command, second no data-binded SQL Command. Here's an example:

```
// SQL without data binding
$sql = DB::conn()->query("SELECT * FROM users");
$sql->count(); // return number of rows

$u = $sql->results(); // return an arraw of rows.

//SQL with data binding
$sql = DB::conn()->query("SELECT * FROM users WHERE id = ?", [$id]);
$sql->count(); // return number of rows

$u = $sql->results(); // return an arraw of rows.
```

## End Of Documents
This document are not well-ly finnished as it's not describe the whole structure. But this can be the basic start to using this framework. The next documents will be the `Page` class on detail, `F` class on detail, `Curl` class, `Alert`, `Packer`, `Loader` and other new upcoming features like PHP socket, AES-256 CBC Encryption and so on.









