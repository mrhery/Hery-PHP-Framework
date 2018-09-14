<?php

class Page{
	public $title = "";
	private $meta_top = array();
	private $css_library = array(), $custom_css = array(), $load_css = array();
	private $top_script_library = array(), $top_custom_script = array();
	private $bottom_script_library = array(), $custom_script = array();
	private $js_obfuscate = false, $htmlhex = false;
	private $page = array(), $footer = "", $main_menu = "", $breadcumb = "", $route = "";
	private $body = "", $contentType = "text/html";
	
	public function __construct($setting = array()){
		if(isset($setting["js_obfuscate"])){
			$this->js_obfuscate = $setting["js_obfuscate"];
		}
		
		if(isset($setting["htmlhex"])){
			$this->htmlhex = $setting["htmlhex"];
		}
		
		if(isset($setting["Content-Type"])){
			$this->contentType = $setting["Content-Type"];
		}
	}
	
	public function addMetaTop($string = ""){
		array_push($this->meta_top, $string);
	}
	
	public function addCssLibrary($string){
		if(!is_array($string)){
			array_push($this->css_library, $string);
		}else{
			foreach($string as $s){
				array_push($this->css_library, $s);
			}
		}
	}
	
	public function addCustomCss($string = ""){
		array_push($this->custom_css, $string);
	}
	
	public function addLoadCss($string = ""){
		array_push($this->load_css, $string);
	}
	
	public function addTopScriptLibrary($string = ""){
		array_push($this->top_script_library, $string);
	}
	
	public function addTopCustomScript($string = ""){
		array_push($this->top_custom_script, $string);
	}
	
	public function addBottomScriptLibrary($string = ""){
		array_push($this->bottom_script_library, $string);
	}
	
	public function addCustomScript($string = ""){
		array_push($this->custom_script, $string);
	}
	
	public function setFooter($path){
		$this->footer = $path;
	}
	
	public function setMainMenu($path, $route = ""){
		if(!empty($route)){
			$this->route = $route;
		}
		
		$this->main_menu = $path;
	}
	
	public function setBreadcumb($path, $route = ""){
		if(!empty($route)){
			$this->route = $route;
		}
		
		$this->breadcumb = $path;
	}
	
	public function loadPage($page = "", $route = ""){
		if(empty($page)){
			die("Fail including page. ");
		}
		
		if(!empty($route)){
			$this->route = $route;
		}
		
		$path = dirname(__DIR__) . "/App/View/pages/" . $page . ".php";
		
		if(!is_file($path)){
			$o = fopen($path, "w");
			fclose($o);
		}
		
		array_push($this->page, $path);
	}
	
	public function setBodyAttribute($attr = ""){
		$this->body = $attr;
	}
	
	public function Render(){
		$route = $this->route;
		$header = $this->Read("header");
		$footer = $this->Read("footer");
		
		$header = str_replace("{PAGE_TITLE}", $this->title, $header);
		
		$meta = "";
		foreach($this->meta_top as $r){
			$meta .= $r;
		}
		$header = str_replace("{META_TOP}", $meta, $header);
		
		$css = "";
		foreach($this->css_library as $r){
			$css .= $r;
		}
		$header = str_replace("{CSS_LIBRARY}", $css, $header);
		
		$css = "";
		foreach($this->load_css as $r){
			$filename = Router::get("path", $r);
			$path = dirname(__DIR__) . "/Assets/" . $filename;
			if(file_exists($path)){
				$css .= file_get_contents($path);
			}
		}
		$header = str_replace("{CUSTOM_CSS}", $css, $header);
		
		$css = "";
		foreach($this->custom_css as $r){
			$css .= $r;
		}
		$header = str_replace("{CUSTOM_CSS_2}", $css, $header);
		
		$js = "";
		foreach($this->top_script_library as $r){
			$js .= $r;
		}
		$header = str_replace("{TOP_SCRIPT_LIBRARY}", $js, $header);
		
		$js = "";
		foreach($this->top_custom_script as $r){
			$js .= $r;
		}
		
		if($this->js_obfuscate){
			$pack = new Packer($js, 'Normal', true, false, true);
			$js = $pack->pack();
		}
		
		$header = str_replace("{TOP_CUSTOM_SCRIPT}", $js, $header);
		
		if(!empty($this->body)){
			$header = str_replace("<body>", "<body " . $this->body . ">", $header);
		}
		
		$js = "";
		foreach($this->bottom_script_library as $r){
			$js .= $r;
		}
		$footer = str_replace("{BOTTOM_SCRIPT_LIBRARY}", $js, $footer);
		
		$js = "";
		foreach($this->custom_script as $r){
			$js .= $r;
		}
		$footer = str_replace("{BOTTOM_CUSTOM_SCRIPT}", $js, $footer);
		
		header("Content-Type: " . $this->contentType);
		
		if($this->htmlhex){
			$hex = '
				function hex(hexx) {
				    var hex = hexx.toString();//force conversion
				    var str = "";
				    for (var i = 0; (i < hex.length && hex.substr(i, 2) !== "00"); i += 2)
				        str += String.fromCharCode(parseInt(hex.substr(i, 2), 16));
				    return str;
				}
			';
			$pack = new Packer($hex, 'Normal', true, false, true);
			$js = $pack->pack();
			echo "<script>" . $js . "hex('" . Encoder::stringToHex($header) . "');</script>";
		}else{
			echo $header;
		}
		
		if(!empty($this->main_menu)){
			$path = dirname(__DIR__) . "/App/View/" . $this->main_menu;
			if(file_exists($path)){
				include_once($path);
			}
		}
		
		if(!empty($this->breadcumb)){
			
			$path = dirname(__DIR__) . "/App/View/" . $this->breadcumb;
			if(file_exists($path)){
				include_once($path);
			}
		}
		
		if(count($this->page) > 0){
			for($i = 0; $i < count($this->page); $i++){
				include_once($this->page[$i]);
			}
		}
		
		if(!empty($this->footer)){
			$path = dirname(__DIR__) . "/App/View/" . $this->footer;
			if(file_exists($path)){
				include_once($path);
			}
		}
		
		if($this->htmlhex){
			echo "<script>hex('" . Encoder::stringToHex($footer) . "');</script>";
		}else{
			echo $footer;
		}
	}
	
	public function Read($type = "header"){
		$path = dirname(__DIR__) . "/App/View/theme/" . $type . ".php";
		$x = fopen($path, "r+");
		$string = stream_get_contents($x);
		
		return $string;
	}
	
	public static function Load($path, $route = ""){
		if(file_exists(PAGES . $path . ".php")){
			include_once(PAGES . $path . ".php");
		}else{
			die("file " . PAGES . $path . " not found");
		}
	}
}




































?>