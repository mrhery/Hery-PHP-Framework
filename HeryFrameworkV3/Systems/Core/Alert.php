<?php
require_once(dirname(__DIR__) . "/Misc/document_access.php");

class Alert{
	public function __construct($type, $message, $style = "", $class = ""){
		switch($type){
			case "success":
			?>
				<div class="alert alert-success alert-dismissable <?= $class ?>" style="<?= $style ?>">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Success!</strong> <?= ($message) ?>
				</div>
			<?php
			break;
			
			case "error":
			?>
				<div class="alert alert-danger alert-dismissable <?= $class ?>" style="<?= $style ?>">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Error!</strong> <?= ($message) ?>
				</div>
			<?php
			break;
			
			case "warning":
			?>
				<div class="alert alert-warning alert-dismissable <?= $class ?>" style="<?= $style ?>">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<strong>Warning!</strong> <?= ($message) ?>
				</div>
			<?php
			break;
			
			case "info":
			?>
				<div class="alert alert-info alert-dismissable <?= $class ?>" style="<?= $style ?>">
					<strong>Notice!</strong> <?= ($message) ?>
				</div>
			<?php
			break;
		}
	}
	
	public static function set($type = "", $message = ""){
		if(!Session::get("HPF_ALERT")){
			Session::create("HPF_ALERT", [
				(object)[
					"type"		=> $type,
					"message"	=> $message
				]
			]);
		}else{
			Session::append("HPF_ALERT", (object)[
				"type"		=> $type,
				"message"	=> $message
			]);
		}
	}
	
	public static function get($a = ""){
		if(!Session::get("HPF_ALERT")){
			return [];
		}else{
			return Session::get("HPF_ALERT")->data;
		}
	}
	
	public static function show($a = ""){
		if(isset(Session::get("HPF_ALERT")->data) && !is_null(Session::get("HPF_ALERT")->data)){
			foreach(Session::get("HPF_ALERT")->data as $alert){
				new Alert($alert->type, $alert->message);
			}
		}
		
		Session::destroy("HPF_ALERT");
	}
}

?>