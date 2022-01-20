<?php

class Items extends Controller {
	public function __construct() {}
	
	public function list2 (){
		echo "from list 2";
		
		$this->page->loadPage("home");
		$this->page->title = "Test Home";
		$this->page->render();
	}
}
