<?php
require_once(dirname(__DIR__) . "/Misc/document_access.php");

class Loader{
	public static function Include($type = "header"){
		if(empty($type)){
			die("Loader Error: Fail including file.");
		}
		
		$path = dirname(__DIR__) . "/App/View/inc/" . $type . ".php";
		if(file_exists($path)){
			$c = fopen($path, "r");
			fclose($c);
			
			include_once($path);
		}else{
			die("File not found.");
		}
	}
	
	public static function Asset($path = ""){
		$path = dirname(__DIR__) . "/Assets/" . $path;
		
		if(!is_dir($path)){
			if(file_exists($path)){
				$pt = pathinfo($path);
				
				switch($pt["extension"]){
					case "css":
						header("Content-Type: text/css");
					break;
					
					case "js":
						header("Content-Type: application/javascript");
					break;
				}
				
				$o = fopen($path, "r");
				echo stream_get_contents($o);
				fclose($o);
			}else{
				die("File not found.");
			}
		}else{
			die("You re not allowed to access this page.");
		}
	}
	
	public static function Image($path){
		$path = dirname(__DIR__) . "/Assets/" . $path;
		
		if(!is_dir($path)){
			if(file_exists($path)){
				$o = fopen($path, "r");
				header('Content-Type: ' . mime_content_type($path));
				header('Content-disposition: filename="logo.png"');
				echo stream_get_contents($o);
			}else{
				echo $path;
				die("File not found");
			}
		}else{
			die("You re not allowed to access this page.");
		}
	}
	
	public static function Class($path){
		if(file_exists(CLASSES . $path . ".php")){
			include_once(CLASSES . $path . ".php");
		}
	}
}

?>