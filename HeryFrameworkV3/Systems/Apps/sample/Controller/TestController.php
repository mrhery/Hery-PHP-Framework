<?php


class TestController extends Controller {
	public function index(){
		header("Content-Type: text/plain");
		print_r($_POST);
		
		//You can redirect to other page:
		// $this->redirect(PORTAL . "");
	}
}