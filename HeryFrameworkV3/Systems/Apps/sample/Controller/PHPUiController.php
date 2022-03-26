<?php

class PHPUiController extends Controller {
	public function __construct() {}
	
	public function index (){
		$this->page->loadPage("phpui");
		$this->page->title = "Testing PHP UI";
		$this->page->render();
	}
}
