<?php
//A journey start with a step
/*
header("Content-Type: text/plain");

echo url::get(1) . "\n\n"; //hpfv3.2
// echo route::get(1); //hpfv3

echo Input::get("nama") . " dan  " . Input::get("uid") . "\n\n";

//Input::get(); //hpfv3.2
//Input::get("", "get"); //hpfv3

echo Input::post("nama"); //hpfv3.2
//Input::get(); //hpfv3
*/

$page = new Page();

$page->addTopTag('
<script>
	console.log("from head tag");
</script>
');

$page->addBottomTag('
<script>
console.log("from bottom");
</script>
');

switch(url::get(0)){
	case "index":
	case "home":
		$page->loadPage("home");
		$page->render();
	break;
	
	case "about":
		$page->loadPage("about");
		$page->render();
	break;
}


