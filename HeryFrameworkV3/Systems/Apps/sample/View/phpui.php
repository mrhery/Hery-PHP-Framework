<?php

class PHPUI {
	public static function build(...$content){
		foreach($content as $c){
			echo $c;
		}
	}
}

class Div{
	public static function create($build = ""){
		if(is_string($build)){
			return "<div>" . $build . "</div>";
		}else{
			$attr = "";
			$content = "";
			
			if(is_array($build)){
				foreach($build as $k => $v){
					switch($k){
						default:
							$attr .= $k . "='". $v  ."' ";
						break;
						
						case "content": case "inner": case "innerhtml":
							if(is_object($v)){
								$content = $v();
							}else{
								$content = $v;
							}
						break;
					}
				}
				
				return	"<div " . $attr .">" . 
						$content .
						"</div>"
				;
			}
		}
	}
}

class Button {
	public static class create(){
		
	}
}

// Div::create("hello word");
PHPUI::build(
	Div::create([
		"style"		=> "background-color: black; color: white; padding: 5px; ",
		"content"	=> function(){
			return "haha";
		}
	]), 
	Div::create([
		"style"		=> "background-color: red; color: white; padding: 10px;",
		"content"	=> "master"
	]),
	Div::create([
		"style"		=> "background-color: grey; color: white; padding: 10px;",
		"content"	=> "master"
	])
);