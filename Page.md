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
- `Page::addCustomScript()`
- `Page::setMainMenu()`
- `Page::setFooter()`
- `Page::setBreadCumb()`
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

