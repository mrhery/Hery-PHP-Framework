<?php
require_once(dirname(__DIR__) . "/Misc/document_access.php");

class App{
	public function __construct($route = "", $autoload = false){
		$main = Router::get("main", $route);
		$path = __DIR__ . "/View/pages/" . $main . ".php";
		
		/*
			If you are creating page directly and not using Page Class, you may enable $autoload = true in new App() at index.php
		*/
		if($autoload){
			if(is_file(__DIR__ . "/View/pages/" . $main . ".php")){
				Loader::Include("header");
				include_once($path);
				Loader::Include("footer");
			}else{
				die("Requested file " . $main . ".php not found in current application directory.");
			}
		}else{
			$page = new Page();
			
			switch($main){
				case "index":
				case "Home":
				case "home":
					$page->title = "Hery PHP Framework V2 - Master Hery";
					$page->loadPage("index");
					$page->Render();
				break;
				
				
				
				
				
				#################################################################
				#################################################################
				
				/*
				* Please left below cases and do not remove these line
				*/
				case "assets":
					$filename = Router::get("path", $route);
					
					if(!empty($filename)){
						Loader::Asset($filename);
					}else{
						$page->title = "Page Not Found";
						$page->loadPage("404");
						$page->Render();
					}
				break;
				
				case "medias":
					Loader::Image($route);
				break;
				
				default:
					$page->title = "Page Not Found";
					$page->loadPage("404");
					$page->Render();
				break;
			}
		}
	}
}

?>