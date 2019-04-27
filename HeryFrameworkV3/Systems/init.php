<?php
require_once(__DIR__ . "/Misc/document_access.php");
require_once(__DIR__ . "/Misc/autoload.php");
session_start();

###################################################
###################DO NOT EDIT BELOW###############
###################################################
/*#*/ define("SYSTEM", __DIR__ . "/");	   		  #
/*#*/ define("APPS", SYSTEM . "Apps/");	   		  #
/*#*/ define("VIEW", SYSTEM . "Apps/View/");		  #
/*#*/ define("PAGES", VIEW . "pages/");    		  #
/*#*/ define("ASSET", SYSTEM . "Assets/"); 		  #
/*#*/ define("UPLOAD", ASSET . "medias/"); 		  #
/*#*/ define("CLASSES", SYSTEM . "Apps/Classes/"); #
/*#*/ define("DEF_NAME", "Developed with HPF");	  #
###################################################

define("ROUTE", Input::get("route"));

require_once(__DIR__ . "/setup.php");

#Web Application
require_once(__DIR__ . "/Apps/Apps.php");
?>