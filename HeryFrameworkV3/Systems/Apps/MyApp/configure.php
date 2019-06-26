<?php
#Misc Files
include_once(MISC . "asset_loader.php");

#Database Configuration
class Config{
	public static $host 	= "127.0.0.1";
	public static $database	= "";
	public static $username	= "";
	public static $password	= "";
}

#Define your web application URL
define("PORTAL", "http://localhost/");