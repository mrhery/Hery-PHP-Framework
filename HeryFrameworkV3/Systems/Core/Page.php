<?php

class Page{
	public $title = "";
	private $meta_top = array();
	private $top_tag = [], $bottom_tag = [];
	private $page = array(), $footer = "", $main_menu = "", $breadcumb = "", $route = "";
	private $body = "", $contentType = "text/html";
	
	public function __construct($setting = array()){		
		if(isset($setting["Content-Type"])){
			$this->contentType = $setting["Content-Type"];
		}
	}
	
	public function addTopTag($tag){
		$this->top_tag[] = $tag;
	}
	
	public function addBottomTag($tag){
		$this->bottom_tag[] = $tag;
	}
	
	public function addMetaTop($string = ""){
		array_push($this->meta_top, $string);
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
		
		$path = dirname(__DIR__) . "/Apps/". APP_CODE ."/View/" . $page . ".php";
		
		if(is_dir(dirname($path))){
			
			if(!is_file($path)){
				$o = fopen($path, "w");
				fclose($o);
			}
			
			array_push($this->page, $path);
		}		
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
		
		$top = "";
		foreach($this->top_tag as $tops){
			$top .= $tops;
		}
		$header = str_replace("{TOP_TAG}", $top, $header);
		
		$bottom = "";
		foreach($this->bottom_tag as $bottoms){
			$bottom .= $bottoms;
		}
		$footer = str_replace("{BOTTOM_TAG}", $bottom, $footer);
		
		//header("Content-Type: " . $this->contentType);
		echo $header;
		
		if(!empty($this->main_menu)){
			$path = dirname(__DIR__) . "/Apps/". APP_CODE ."/View/" . $this->main_menu;
			if(file_exists($path)){
				include_once($path);
			}
		}
		
		if(!empty($this->breadcumb)){
			
			$path = dirname(__DIR__) . "/Apps/". APP_CODE ."/View/" . $this->breadcumb;
			if(file_exists($path)){
				include_once($path);
			}
		}
		
		if(count($this->page) > 0){
			for($i = 0; $i < count($this->page); $i++){
				if(file_exists($this->page[$i])){
					include_once($this->page[$i]);
				}
			}
		}
		
		if(!empty($this->footer)){
			$path = dirname(__DIR__) . "/Apps/". APP_CODE ."/View/" . $this->footer;
			if(file_exists($path)){
				include_once($path);
			}
		}
		
		echo $footer;
	}
	
	public function Read($type = "header"){
		$path = dirname(__DIR__) . "/Apps/Public/View/skeleton/" . $type . ".php";
		$x = fopen($path, "r+");
		$string = stream_get_contents($x);
		
		return $string;
	}
	
	public static function Load($path, $route = ""){
		if(file_exists(dirname(__DIR__) . "/Apps/". APP_CODE ."/View/" . $path . ".php")){
			include_once(dirname(__DIR__) . "/Apps/". APP_CODE ."/View/" . $path . ".php");
		}else{
			die("file " . dirname(__DIR__) . "/Apps/". APP_CODE ."/View/" . $path . " not found");
		}
	}
}




































?>