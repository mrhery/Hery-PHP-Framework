<?php
/**

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

*/

class HomeController extends Controller {
	public function __construct() {}
	
	public function index(){
		$this->page->title = "Home " . APP_NAME;	// Set the page title (at the tab)
		$this->page->loadPage("home");				// Set the path to your view file, will be auto created in your View directory
		$this->page->render();						// To render everything and put your page in between header and footer
	}
}
