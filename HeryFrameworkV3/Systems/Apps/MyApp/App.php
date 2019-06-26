<?php
//A journey start with a step

$page = new Page();
$page->addTopTag(
	'<script src="'. PORTAL .'assets/app.js"></script>'
);
$page->title = "Test";
$page->loadPage("Test");
$page->Render();