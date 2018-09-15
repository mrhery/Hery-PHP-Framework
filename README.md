# Hery PHP Framework (HPF) version 3
HPF is a small PHP Framework to develop a web with routing page, modelling class from database (etc.) easier. 70% of this version are taken from version 2.

# Where to Start?

## Knowing the Basic - Do's & Dont's!
By default, as you can see in the `index.php` file, the instance of `App` has been called, that's mean your web application are up to work and ready to develop. All the application file are placed in `Systems/App`, all `Models`, `Controller`, `View` and custom `Classes` will be placed into each folder.

Please caution, do not edit the files in `Systems/Core` directory and also do not edit the `Systems/init.php` file. These files are the core of this HPF, and updates on this HPF will be updated and added in these folders/files.

The `Systems/configure.php` file is where your database information, initial `constant`, `session`, `globals` definition or any of initial required file included called in this file. As you can see, the `Systems/Misc` directory contains the file which is work as an add-on files, and you can edit it, and called in `Systems/configure.php`.

## Setup your 1st Web Application
Start gathering your database information and update the `Systems/configure.php` file. Now your application has been connected to the database. You may test the connection on the next section.

Before starting the development, the HPF required the ***root web URL** (e.g. https://www.mrhery.my/, https://google.com/ etc.), **without file's name**. Put the website address in the `Systems/configure.php` file, on `PORTAL` constant. 

## Read The Routing
In HPF, the routing of the website has been sent automatically as `$route` variable which is available in `Systems/App/App.php`. All the URL format will be like this: `https://mrhery.my/Main/Sub/View/Sub-Page/Sub-Page` and the `$route` will have this value: `Main/Sub/View/Sub-Page/Sub-Page`. The first route of this URL is `Main`, all the first route have to be declared in `Systems/App/App.php` or otherwise the HPF will return `404 Page Not Found`.

To declare the the first route (in other words naming pages on URL), it required to create the `case` in the `switch` code block available in `Systems/App/App.php`. As an example, for three pages as listed below:

- https://www.web-url.com/Home
- https://www.web-url.com/About
- https://www.web-url.com/Contact

There must be 3 `case` added in `switch` code block in file `System/App/App.php`. Example:
```
switch($main) //->This one is form default, do not change any of this!
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

To call the specific children page, here it come the `Router` class. Use `Router::get()` method to get any of the route available in the URL route. The **1st route** called **main**, **2nd route** called **sub** and the **3rd route** called **view**. Example Usage on URL: https://www.web-url.com/Page/Sub/Children

```
//Router::get(@param1, @param2, [@param3])
//@param1:string -> enum(main, sub, view, picker)
//@param2:string -> $route
//@param3:int -> index, if only if @param1 = picker, then must put index

echo Router::get("main", $route); // Result: Page
echo Router::get("sub", $route);  // Result: Sub
echo Router::get("view", $route); // Result: Children

//The picker can pick any of those by route index start from 0
echo Router::get("picker", $route, 0);  // Result: Page
echo Router::get("picker", $route, 1);  // Result: Sub
echo Router::get("picker", $route, 2);  // Result: Children
```

If the URL route are very long, then picker can be applied. If the route not availble, which is in above example, pick the `Router::get("picker", $route, 4)` and the index of 4 is not in the URL, then `Router` will return empty string `""`.

## Start Creating a Page
The best way to create a page in HPF is using the `Page` class. Developer will have 2 option either routing the page directly without creating the `case` in `Systems/App/App.php` or use the above method.

To enable routing directly (which is not recommended), change `false` to `true` in `index.php` on `App` instance start. The all the frst route will be read as a PHP page file in `Systems/App/View/pages`. As example:

web-url.com/Home will be read the file on `Systems/App/View/pages/Home.php`. **This method are not recommended as it has not been updated for while and no proof on security and 100% functionality**.

Likewise, here is the recommended way to create page using `Page` class. This page class can only start it's instance in `Systems/App/App.php` where the only first route can applied this. Here's some of the method available in class `Page`:

```
//Page::title [var:string] #Non-Static
//To set the page title on the top af browser tab.
//
//Page::setMetaTag(@param) #Non-Static
//@param:string -> meta tag string: <meta charset="UTF-8" /><meta ....
//Set the meta tag of the current loaded page
//
//Page::loadPage(@param1, [@param2])
//@param1:string -> file name in Systems/App/View/pages. Can be "admin/index", "private/home" without .php extension
//@param2:string -> $route, if only if you want to use the route in the loaded page. Trust me, YOU NEED THIS
//Set the page design from Systems/App/View/pages
//
//Page::Render() #Non-Static
//Redering the page A.K.A. viewing the page.
```
The above methods is the basic method that oftenly use in development. Write these code in `System/App/App.php` file in the `case` code block. Example:

```
switch($main) //default
{
  case "Home":
    $page = new Page();
    $page->title = "Home - MyWebsite";
    $page->setMetaTag('
      <meta charset="UTF-8" />
    ');
    $page->loadPage("public/home"); //be sure you have a dir named public in Systems/App/View/pages/public and home.php in it.
    $page->Render();
  break;
  
  //...
  //dont change anything on below code
}
```
To make development easier, the `$page` can be instantiate outside the `switch` code block as below:
```
$page = new Page();
$page->setMetaTop('
      <meta charset="UTF-8" />
    ');
switch($main) //default
{
  case "Home":
    $page->title = "Home - MyWebsite";
    $page->loadPage("public/home"); 
    $page->Render();
  break;
  
  case "About":
    $page->title = "About - MyWebsite";
    $page->loadPage("public/about"); 
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

## Form Controller - Same as in HPFv2
The `Controller` class work as a *file loader* and *token handler*. Every time form request send, the form itself have to send 2 parameters, `submit` and `route`. The submit parameter has value of current `token`, and this token can retrieve from `$_SESSION["IR"]`. This session has name `IR` that's mean *Internal Request*, it's a key automatic generate everytime a form send a request. The `route` parameter contains value of string of a route to controller file to execute which is placed in `Systems/App/Controller` directory. 

To make the controller works, `Controller` class must be instantiate first before the form. The instace of `Controller` class can only once per page. Here's an example:
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
  
  <!-- These 2 parameter are required to submit a form -->
  <input type="hidden" name="submit" value="<?= $_SESSION["IR"] ?>" />
  <input type="hidden" name="route" value="test/submit" />
  
  <!--
    The parameter route has value of "test/submit", the controller will execute the
    path of "Systems/App/Controller/test/submit.php", make sure the directory and 
    filename exists in "Systems/App/Controller/test"
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
//Input Class
//
//Input::get(@param1, [@param2]) #Static
//@param1:string  -> Request name
//@param2:string  -> enum(post, get) if only if the request in GET method.
//By default, Input::get("name") will provide data from POST method - $_POST["name"]
//If GET method, the Input class required the second parameter Input::get("name", "get") - $_GET["name"]
//Input::get() will return string.
```

The `Input` class are recommended to use in fetching request data as it can avoid the *Cross Site Scripting (XSS)* attack.

## End Of Documents
This document are not well-ly finnished as it's not describe the whole structure. But this can be the basic start to using this framework. The next documents will be the `Page` class on detail, `F` class on detail, `Curl` class, `Alert`, `Packer`, `Loader` and other new upcoming features like PHP socket, AES-256 CBC Encryption and so on.









