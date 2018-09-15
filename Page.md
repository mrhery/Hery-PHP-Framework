# Page Class
`Page` class is a small class to create page for the first route in `Systems/App/App.php`. This class has bunch of method to set the page properties. This class will generate the additional HTML tags like `<meta>`, `<script>`, `<style>` and etc.

## Methods & Properties Directory
- `Page::title`
- `Page::loadPage()`
- `Page::addMetaTop()`
- `Page::addCssLibrary()`
- `Page::addCustomCss()`
- `Page::addTopScriptLibrary()`
- `Page::addBottomScriptLibrary()`
- `Page::setMainMenu()`
- `Page::setFooter()`
- `Page::setBreadcumb()`
- `Page::setBodyAttribute()`

### Page::title :string
Set the curent loaded page title - on top tab browser.
```
$page = new Page();
$page->title = "My First Page";
$page->Render();
```

### Page::loadPage(@param1, [@param2])
@param1:string  -> File path in `Systems/App/View/pages`<br />
@param2:string  -> `$route`, current route string.<br />
This method will return nothing. It is use to load HTML/PHP page that has been designed in `Systems/App/View/pages`.
```
$page = new Page();
$page->title = "My First Page";
$page->loadPage("home");
$page->Render();
```

### Page::addMetaTop(@param)
@param:string -> HTML meta tag coding e.g. `<meta charset="UTF-8" /> ...`<br />
This method will return nothing. The meta tag will be shown in the current loaded page.
```
$page = new Page();
$page->title = "My First Page";
$page->addMetaTop('<meta charset="UTF-8" />');
$page->loadPage("home");
$page->Render();
```

### Page::addCssLibrary(@param)
@param:string  -> Array of stylesheet library<br />
This method will return nothing. All listed `<link>` will be added on the current HTML/PHP loaded.
If the stylesheet is in local web application, use `Router` to get path to assets folder or use `PORTAL` constant.
All file CSS have to placed in `Systems/Assets` directory and call on page only use smallcase letter `assets/`. Example:
```
$page = new Page();
$page->addCssLibrary(
  '<link rel="stylesheet" href="https://style.com/style/style.css" />' .
  '<link rel="stylesheet" href="'. PORTAL .'assets/css/style.css" />' .
  '<link rel="stylesheet" href="'. Router::pathToAsset($router) .'assets/css/style.css" />'
);
$page->Render();
```
The `Router::pathToAsset($router) . "assets"` will generate the path to `Systems/Assets`.

### Page::addCustomCss(@param)
@param:string -> Style HTML tag: `<style></style>`<br />
This method will return nothing.
```
$page = new Page();
$page->addCustomCss('
  <style>
    .mb-20{
      margin-bottom: 20px;
    }
  </style>
');
$page->Render();
```
The above CSS will be wrote in the current HTML/PHP loaded page.

### Page::addTopScriptLibrary(@param)
@param:string -> Adding JavaScript library.<br />
This method will return nothing.
```
$page = new Page();
$page->addTopScriptLibrary('
  <script src="https://web-url.com/script.js"></script>
  <script src="'. Router::pathToAsset($router) .'assets/js/custom.js"></script>
  <script>
    //custom script can be here
  </script>
');
$page->Render();
```
This method will add library on the top of loaded page.

### Page::addBottomScriptLibrary(@param)
@param:string -> Adding JavaScript library.<br />
This method will return nothing.
```
$page = new Page();
$page->addBottomScriptLibrary('
  <script src="https://web-url.com/script.js"></script>
  <script src="'. Router::pathToAsset($router) .'assets/js/custom.js"></script>
  <script>
    //custom script can be here
  </script>
');
$page->Render();
```
This method will add library on the bottom of loaded page.

### Page::setMainMenu(@param1, [@param2])
@param1:string  -> Path to main menu file<br />
@param2:string  -> `$router`, string of current route, put this var if only want to pass the route in main menu file<br />
This method will return nothing.
```
$page = new Page();
$page->setMainMenu("widgets/main_menu", $route);
$page->Render();
```
The main menu file path `widgets/main_menu` must be placed in `Systems/App/View/widgets/main_menu.php`.

### Page::setFooter(@param)
@param:string -> Path to footer file<br />
This method will return nothing.
```
$page = new Page();
$page->setFooter("widgets/footer");
$page->Render();
```
The footer file path `widgets/footer` must be placed in `Systems/App/View/widgets/footer.php`.

### Page::setBreadcumb(@param1, [@param2])
@param1:string  -> Path to breadcumb file<br />
@param2:string  -> `$router`, string of current route, put this var if only want to pass the route in main menu file<br />
This method will return nothing.
```
$page = new Page();
$page->setBreadcumb("widgets/breadcumb", $route);
$page->Render();
```
The breadcumb file path `widgets/breadcumb` must be placed in `Systems/App/View/widgets/breadcumb.php`.

### Page::setBodyAttribute(@param)
@param:string -> Body attribute for current loaded page.<br />
This method will return nothing.
```
$page = new Page();
$page->setBodyAttribute('class="body-class" style="margin-top: 20px;" data-tag="body-HTML"');
$page->Render();
```
When rendering, the body will have the attribute of `class="body-class" style="margin-top: 20px;" data-tag="body-HTML"`.
















