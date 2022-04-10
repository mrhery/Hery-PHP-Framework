<?php
/***********************************************
;"Hery PHP Framework (HPF) v4";
;"Designed and Developed at Min September 2018";
;"Hery Intelligent Technolgy";
;"Mr Hery (hery@herytechnology.com)";
************************************************/

define("HFA", true);
require_once(__DIR__ . "/Systems/init.php");
define("ASSET", __DIR__ . "/assets/");

//
//(new App("Sample Project", "sample"))->run(["reload" => false]);
//Explanation:
(new App(
	"Sample Project",	// Project name, can be call using constant APP_NAME
	"sample"			// Project code to create  a project folder in Apps/project_code_here. Can be call using constant APP_CODE
))->run([
	"reload" => false,	// Reload database table structure everytime refresh. Make it false for production. 
]);

