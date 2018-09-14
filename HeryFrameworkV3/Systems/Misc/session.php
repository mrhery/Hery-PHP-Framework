<?php
require_once(dirname(__DIR__) . "/Misc/document_access.php");

session_start();

if(!isset($_SESSION["IR"])){
	F::NewReqKey();
}
?>