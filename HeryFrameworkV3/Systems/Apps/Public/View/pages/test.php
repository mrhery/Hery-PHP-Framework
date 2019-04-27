<?php
$router = new Routerv2(new Request);
$router->get("/test", function() {
	return <<<HTML
	
	<h1>Hello world</h1>
	
HTML;
});