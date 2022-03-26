
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
As the HPFv3.2 support multi application, so inside the framework folder will have `Apps` directory which is contains all available application directory.

Now open the `Apps` directory (inside the framework folder), you can see the `Apps.php` file. This file will contains all of your available application. After declaring or start your application instance, a directory will be automatically created (named of your application code) for your application which will contain the `Classes`, `View`, `Controller` and `Assets` directory. And also it contain `App.php` file (the main routing file) and `configure.json` file (contain database information and shared information).

## Setup your 1st Web Application
Go to `Apps` directory and start create your first application. Edit the `Apps.php` file and write below codes:
1) For multi applications:
```
$list_app = array(
	"app_code_1"	=> function(){
		return (new App("Application One Title", "app_code_1"))->run();
	},
	"app_code_2"	=> function() {
		return (new App("Application Two Title", "app_code_2"))->run();
	}
);

App::Execute($list_app["app_code_2"]);
```

2) For single application
```
(new App("MyApp Title", "myapp_code"))->run();
```

For succeed executed application, a directory named on the application code will be created in the `Apps` folder automatically.

Start gathering your database information and update the `Apps/your_app_code/configure.json` file. Now your application has been connected to the database. You may test the connection on the next section.

Before starting the development, the HPF required the **root web URL** (e.g. https://www.mrhery.my/, https://google.com/ etc.), **without file's name**. Put the website address in the `Apps/your_app_code/configure.json` file, on `PORTAL` constant. 

## Read The URL Routing
To manage URL route in HPF, you have to configure in `Apps/your_app_code/App.php` file. The URL scheme will start read after your `PORTAL` constant (that we set in `configure.json`). Example: (if your `PORTAL` value in `https://mrhery.my/v1/`)

**Navigation: ** https://mrhery.my/v1/home/category
```
//Read the URL route:
url::get(0) // will return home (if emtpy will return string 'index')
url::get(1) // will return category
url::get(2) // if 3rd / is empty, then it will return empty.
```

The requested URI `/home/category/` will be convert into array value seperated by `/`.

To declare the the first route (in other words naming pages on URL), it required to create the `case` in the `switch` code block available in `Apps/your_app_code/App.php`. As an example, for three pages as listed below:

- https://www.web-url.com/Home
- https://www.web-url.com/About
- https://www.web-url.com/Contact

There must be 3 `case` added in `switch` code block in file `Apps/your_app_code/App.php`. Example:
```
switch(url::get(0)) 
{
  case "index": //add this line tho make the page is the default page if no Main route
  case "Home":
    echo "Hello From Home";
  break;
  
  case "About":
    echo "Hello From About";
  break;
  
  case "Contact":
    echo "Hello From Contact";
  break;
  
  //... 
  //the othe code on below, do not change anything!
}
```

As defined `index` into `Home` case, then if the URL is root: https://www.web-url.com, HPF will read the `Home` page. The routing can be sub-ed, that's mean, in `Home` case you may have another children page as route will be like `Home/Sub/Sub`.

To call the specific children page, here it come the `Url` class. Use `url::get()` method to get any of the route available in the URL route. The **1st route** called **main**, **2nd route** called **sub** and the **3rd route** called **view** (or else can use index number `0,1,2,...`). Example Usage on URL: https://www.web-url.com/Page/Sub/Children

```
//url::get(@param1)
//@param1:string -> enum(main, sub, view, picker)

echo url::get("main"); // Result: Page
echo url::get("sub");  // Result: Sub
echo url::get("view"); // Result: Children

//The picker can pick any of those by route index start from 0
echo url::get(0);  // Result: Page
echo url::get(1);  // Result: Sub
echo url::get(2);  // Result: Children
```

If the URL route are too long, then used the index number instead of enumeration name. If the route not available, which is in above example, pick the `url::get(4)` and the index of 4 is not in the URL, then `Router` will return empty string `""`.

## Start Creating a Page
The best way to create a page in HPF is using the `Page` class. Here is the way to create page using `Page` class. This page class can only start it's instance in `Apps/your_app_code/App.php` where the only first route can applied this. Here's some of the method available in class `Page`:

```
Page::title [var:string] #Non-Static
//To set the page title on the top af browser tab.
//
Page::addTopTag(@param) #Non-Static
//@param:string -> meta tag string: <meta charset="UTF-8" /><meta ....
//Set the meta tag of the current loaded page
//
Page::loadPage(@param1, [@param2])
//@param1:string -> file name in Apps/your_app_code/View. Can be "admin/index", "private/home" without .php extension
//@param2:string -> $route, if only if you want to use the route in the loaded page. Trust me, YOU NEED THIS
//Set the page design from Systems/App/View/pages
//
Page::Render() #Non-Static
//Redering the page A.K.A. view
//
Page::Load(@param1, [@param2]) #Static
//@param1:string -> File path
//@param2:array["var_name" => (mixed)"value"]
//Use Page::Load("", []) to include a 'Page' file from 'View' folder.
//File path excluded '.php' extension.
//You can parse variables to icluded page on second parameter.
//Example:

#index.php
Page::Load("pages/main", ["varX" => "hello", "varY" => "world"]);

#pages/main.php

echo $varX . " " . $varY;


```
The above methods is the basic method that oftenly use in development. Write these code in `Apps/your_app_code/App.php` file in the `case` code block. Example:

```
switch(url::get(0)) //default
{
  case "Home":
    $page = new Page();
    $page->title = "Home - MyWebsite";
    $page->addTopTag('
      <meta charset="UTF-8" />
    ');
    $page->loadPage("home"); //be sure you have a dir named public in Apps/your_app_code/View/ and home.php in it.
    $page->Render();
  break;
  
  //...
  //dont change anything on below code
}
```
To make development easier, the `$page` can be instantiate outside the `switch` code block as below:
```
$page = new Page();
$page->addTopTag('
      <meta charset="UTF-8" />
    ');
switch(url::get(0)) //default
{
  case "Home":
    $page->title = "Home - MyWebsite";
    $page->loadPage("home"); 
    $page->Render();
  break;
  
  case "About":
    $page->title = "About - MyWebsite";
    $page->loadPage("about"); 
    $page->Render();
  break;
  
  //...
  //dont change anything on below code
}
```
The details about `Page` class will be stated in other document.

## Start using Database
In HPF, developer has many way to connect with your data in database and even HPF allow a developer to create their own database connection manually - procedural and object-oriented. HPF recommended using it's own database class to maintain flexibility, usability and security. 

In HPF, there are 3 ways to fetch data from database (in version 2, there only 2 ways).

### 1st Automatic Table Class Modelling (Recommended) - Modelv2 Class
In HPF v3, it support calling table name as a `class`. This method is recommended as it can make development easier rather than creatin class on every table in database. But make sure the table name not the same as `class` name available in all Core, Model & Classes directory. It is recommended to put the prefix on the table name like `a_users`, `a_items` etc.

The `Modelv2` is a **trait**, it's a class trait which is use in the auto-generated class on table name. The `Modelv2` trait has some method can be use. (Notice: all trait are **static**, no instance required.)

```
//Modelv2 Trait
//
//example table name: Users (from database)
//
//Users::list([@param]) #Static
//@param:array -> setting array to list. This setting is not recommended for user input setiing as it's not SQLi Proof.
//$setting:array 
//  where => "column = '$var'",
//  order => "column DESC",
//  limit => "$start:int, $limit:int",
//  group => "column"
//The list() method will return an array of objects.
//
//User::getBy(@param) #Static
//@param:array  -> array of column name and value
//$setting:array
//  column_one  => "$var",
//  colmn_two   => "$var"
//getBy() method will return an array of objects.
//
//User::insertInto(@param) #Static
//@param:array -> a set of data.
//$data:array
//  "column_one"  => "$data",
//  "column_tow"  => "$data"
//insertInto() method will return boolean.
//
//User::updateBy(@param1, @param2) #Static
//@param1:array -> Set of where clause in array
//@param2:array -> Set of new data
//$where:array
//  "column_one"  => "$id",
//$data:array
//  "column_thow" => "$new_data"
//updateBy() method will return boolean.
//
//User::deleteBy(@param) #Static
//@param:array -> Set of setting
//$setting:array
//  "column_one"  => "$id"
//deleteBy() method will return boolean.
```

All the above method available in `Modelv2` trait class which is auto-generated and can be use with any of table name available in database. These method are SQLi Proof unless the `list()` method still has lack of security matter, it can only use internally but not recommended for user-input varible for it's setting.

### 2nd Classic Class Modeling (still use in HPFv2) - Model Class
This way is a classic way in creating table database model. It need an instance to make it usable. All the method in this class are the same availbale in `Modelv2` trait. Here's an example:
```
//Model Class
//
//example table name: Users (from database)
//
//Model::__construct(@param) #Non-Static
//@param:string -> Table name in database.

$users = new Model("Users");
$users->list($setting:array)
$users->insertInto($data:array);
$users->updateBy($where:array, $data:array);
$users->deleteBy($where:array);
$users->getBy($where:array);
```
In classic `Model` class, all method and security measurement are equal. Developer may choose either one is suitable for them.

### 3rd Manual SQL Command (available in HPFv2) - DB Class
The `DB` class are the core SQL engine in HPF. All class modelling are depending on this class. Failing to maintain this class security can be breach the whole application. In this `DB` class, there are to way to run up the SQL command, first is data-bidned SQL Command, second no data-binded SQL Command. Here's an example:
```
//DB Class
//
//example table name: Users (from database)
//
//DB::conn()->query(@param1, @param2) #Non-Static + Static - Can user directly this way DB::conn()->query();
//@param1:string  -> String SQL Command
//@param2:array   -> Set of binded data
//eg: DB::conn()->query("SELECT * FROM Users WHERE id = ?", array("id" =>  "1"));
//Bindable SQL Command
//DB::conn()->query()->results() method will return an array of objects.
//DB::conn()->query()->error() method will return boolean.
//
//DB::conn()->q(@param) #Non-Static + Static - Can user directly this way DB::conn()->query();
//@param:string -> SQL Command
//eg: DB::conn()->q("SELECT * FROM Users WHERE id = '1'");
//Non-bindable SQL Command
//DB::conn()->q()->results() method will return an array of objects
//DB::conn()->q()->error() method will return boolean.
```

These 3 ways to fetch your database. For security advice, Bindable SQL Command are more secured and all `Model` class and `Modelv2` trait implements Bindable SQL Command (unless the `list()` method).

## Form Controller 
The `Controller` class work as a *file loader* and *token handler*. Every time form request send, the form itself will automatically send 2 parameters, `__SUBMIT__` and `__ROUTE__`. The submit parameter has value of current `token`, and this token can retrieve from `$_SESSION["IR"]`. This session has name `IR` that's mean *Internal Request*, it's an automatic generated key every time a form send a request. The `__ROUTE__` parameter contains value of string of a route to controller file to execute which is placed in `Apps/your_app_code/Controller` directory. 

To make the controller works, `Controller` class must be instantiate first before the form. The instance of `Controller` class can only once per page. Here's an example:
```
<!-- Form Sample  -->
<?php
//Instantiate controller
new Controller($_POST)
?>
<form acion="" method="POST">
  <input type="text" name="name" /><br />
  <button>
    Submit
  </button>
  
  <?= Controller::form("test/submit") ?>
  <!--
    The parameter Controller::form() method has value of "test/submit", the controller will execute the
    path of "Apps/your_app_code/Controller/test/submit.php", make sure the directory and filename exists in "Apps/your_app_code/Controller/test"
  -->
</form>


<?php
//Consider this in submit.php
//Now you may use Input Class
//
echo "Inserted data: " . Input::get("name");
?>
```

The `Input` class used to grab the requested data either `$_POST` or `$_GET` method. The `Input` class will read the requested data as a `htmlspecialchars` return value. `Input` class:
```
//Read POST data:
Input::post("param_name"); // for html special chars value
Input::post("param_name", false); // for disable html special chars

Read GET data:
Input::get("param_name"); // for html special chars value
Input::get("param_name", false); // for disable html special chars
```

The `Input` class are recommended to use in fetching request data as it can avoid the *Cross Site Scripting (XSS)* attack.

## End Of Documents
This document are not well-ly finnished as it's not describe the whole structure. But this can be the basic start to using this framework. The next documents will be the `Page` class on detail, `F` class on detail, `Curl` class, `Alert`, `Packer`, `Loader` and other new upcoming features like PHP socket, AES-256 CBC Encryption and so on.









