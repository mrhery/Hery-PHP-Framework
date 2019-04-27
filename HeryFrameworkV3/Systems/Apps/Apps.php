<?php
require_once(dirname(__DIR__) . "/Misc/document_access.php");

$apps = [
	"app_one"	=> function(){
		$app1 = new App("This is App 1", "app_one");
		return $app1->run();
	}
];

App::execute($apps["app_one"]);
?>