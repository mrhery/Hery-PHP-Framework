<?php

class HPHPUI {
	public static function build(...$content){
		foreach($content as $c){
			echo $c . "\n";
		}
	}
}

interface IHTMLElement {
	public static function create($build = "");
}

class HHTMLElement {
	public function __construct(){
		
	}
	
	static function build($build = "", $tag = "", $closing = true){
		if(is_string($build)){
			if($closing){
				return "<". $tag .">" . $build . "</". $tag .">";
			}else{
				return "<". $tag ." />" . $build . "";
			}
			
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
							if(is_array($v)){
								foreach($v as $b){
									if(is_object($b)){
										if(is_array($b())){
											foreach($b() as $c){
												$content .= $c . "\n";
											}
										}else{
											$content .= $b() . "\n";
										}
									}else{
										$content .= $b . "\n";
									}
								}
							}else{
								if(is_object($v)){
									if(is_array($v())){
										foreach($v() as $w){
											$content = $w . "\n";
										}
									}else{
										$content = $v() . "\n";
									}
								}else{
									$content = $v . "\n";
								}
							}
						break;
					}
				}
				
				if($closing){
					return	"<". $tag ." " . $attr .">" . "\n" . 
						$content . "\n" .
						"</". $tag .">"
					;
				}else{
					return	"<". $tag ." " . $attr ." />" . 
						$content .
						""
					;
				}
			}
		}
	}
}

class HDiv extends HHTMLElement implements IHTMLElement{
	private static $tag = "div";
	private static $closing = true;
	
	public static function create($build = ""){
		return self::build($build, self::$tag, self::$closing);
	}
}

class HButton extends HHTMLElement implements IHTMLElement {
	private static $tag = "button";
	private static $closing = true;
	
	public static function create($build = ""){
		return self::build($build, self::$tag, self::$closing);
	}
}

class HTextarea extends HHTMLElement implements IHTMLElement {
	private static $tag = "textarea";
	private static $closing = true;
	
	public static function create($build = ""){
		return self::build($build, self::$tag, self::$closing);
	}
}

class HImage extends HHTMLElement implements IHTMLElement {
	private static $tag = "img";
	private static $closing = false;
	
	public static function create($build = ""){
		return self::build($build, self::$tag, self::$closing);
	}
}

class HInput extends HHTMLElement implements IHTMLElement {
	private static $tag = "input";
	private static $closing = false;
	
	public static function create($build = "", $type = "text"){
		if(is_string($build)){
			$build = [
				"type"		=> $type,
				"content"	=> $build
			];
		}else{
			$build["type"] = $type;
		}
		
		return self::build($build, self::$tag, self::$closing);
	}
}

class HRadio extends HHTMLElement implements IHTMLElement {
	private static $tag = "input";
	private static $closing = false;
	
	public static function create($build = ""){
		return HInput::create($build, "radio");
	}
}

class HCheckbox extends HHTMLElement implements IHTMLElement {
	private static $tag = "input";
	private static $closing = false;
	
	public static function create($build = ""){
		return HInput::create($build, "checkbox");
	}
}

class HForm extends HHTMLElement implements IHTMLElement {
	private static $tag = "form";
	private static $closing = true;
	
	public static function create($build = ""){
		return self::build($build, self::$tag, self::$closing);
	}
}

class HTable extends HHTMLElement implements IHTMLElement {
	private static $tag = "table";
	private static $closing = true;
	
	public static function create($build = ""){
		return self::build($build, self::$tag, self::$closing);
	}
}

class Hthead extends HHTMLElement implements IHTMLElement {
	private static $tag = "thead";
	private static $closing = true;
	
	public static function create($build = ""){
		return self::build($build, self::$tag, self::$closing);
	}
}

class Htbody extends HHTMLElement implements IHTMLElement {
	private static $tag = "tbody";
	private static $closing = true;
	
	public static function create($build = ""){
		return self::build($build, self::$tag, self::$closing);
	}
}

class Htfoot extends HHTMLElement implements IHTMLElement {
	private static $tag = "tfoot";
	private static $closing = true;
	
	public static function create($build = ""){
		return self::build($build, self::$tag, self::$closing);
	}
}

class Hth extends HHTMLElement implements IHTMLElement {
	private static $tag = "th";
	private static $closing = true;
	
	public static function create($build = ""){
		return self::build($build, self::$tag, self::$closing);
	}
}

class Htr extends HHTMLElement implements IHTMLElement {
	private static $tag = "tr";
	private static $closing = true;
	
	public static function create($build = ""){
		return self::build($build, self::$tag, self::$closing);
	}
}

class Htd extends HHTMLElement implements IHTMLElement {
	private static $tag = "td";
	private static $closing = true;
	
	public static function create($build = ""){
		return self::build($build, self::$tag, self::$closing);
	}
}

HPHPUI::build(
	HDiv::create([
		"style"		=> "background-color: black; color: white; padding: 5px;",
		"content"	=> function(){
			
		}
	]), 
	HDiv::create([
		"style"		=> "background-color: red; color: white; padding: 10px;",
		"content"	=> "master"
	]),
	HDiv::create([
		"style"		=> "background-color: grey; color: white; padding: 10px;",
		"content"	=> [
			"master", 
			HImage::create([
				"src"	=> PORTAL . "assets/images/x.png"
			])
		]
	]),
	HButton::create("asdasd"),
	HForm::create([
		"action"	=> Controller::url("TestController::index"),
		"method"	=> "POST",
		"enctype"	=> "multipart/form-data",
		"content"	=> [
			HInput::create([
				"name"			=> "name",
				"id"			=> "name",
				"placeholder"	=> "Your name"
			]),
			HInput::create([
				"name"			=> "Email",
				"id"			=> "email",
				"placeholder"	=> "Your Email"
			], "email"),
			HInput::create([
				"name"			=> "password",
				"id"			=> "password",
				"placeholder"	=> "Your Password"
			], "password"),
			HButton::create("submit"),
			HDiv::create(Controller::form())
		]
	]),
	HTable::create([
		"border"	=> 1,
		"width"		=> "100%",
		"content"	=> [
			HThead::create([
				"content"	=> [
					Htr::create([
						"content"	=> [
							Hth::create([
								"class"		=> "text-center",
								"content"	=> "No"
							]),
							Hth::create([
								"class"		=> "text-center",
								"content"	=> "Name"
							]),
							Hth::create([
								"class"		=> "text-center",
								"content"	=> "Email"
							]),
							Hth::create([
								"class"		=> "text-center",
								"content"	=> "Password"
							])
						]
					])
				]
			]),
			HTbody::create([
				"content"	=> function(){
					$data = [];
					
					for($i = 0; $i < 10; $i++){
						echo $i;
						
						$data[] = Htr::create([
							"content"	=> [
								Htd::create([
									"style"		=> "text-align: center;",
									"class"		=> "text-center",
									"content"	=> $i
								]),
								Htd::create([
									"class"		=> "text-center",
									"content"	=> "Mr Hery " . $i
								]),
								Htd::create([
									"class"		=> "text-center",
									"content"	=> "hery@herytechnology.com " . $i
								]),
								Htd::create([
									"class"		=> "text-center",
									"content"	=> "123123"
								])
							]
						]);
					}
					
					return $data;
					
					// return [
						// Htr::create([
							// "content"	=> [
								// Htd::create([
									// "class"		=> "text-center",
									// "content"	=> "1"
								// ]),
								// Htd::create([
									// "class"		=> "text-center",
									// "content"	=> "Mr Hery"
								// ]),
								// Htd::create([
									// "class"		=> "text-center",
									// "content"	=> "hery@herytechnology.com"
								// ]),
								// Htd::create([
									// "class"		=> "text-center",
									// "content"	=> "123123"
								// ])
							// ]
						// ])
					// ];
				}
			])
		]
	])
);