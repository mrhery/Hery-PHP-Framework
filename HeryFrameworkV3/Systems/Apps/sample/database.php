<?php
//Place you database setup here

/*
HPFv4 Database
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

*/