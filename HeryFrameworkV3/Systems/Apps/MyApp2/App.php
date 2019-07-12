<?php
//A journey start with a step

try{
	print_r(Turbo::app("MyApp1")::Constants("PORTAL"));
	echo PORTAL;
	
}catch(Exception $e){
	echo $e->getMessage();
}
