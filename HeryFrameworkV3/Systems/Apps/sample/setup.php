<?php
if(!Session::exist("Routes")){
	Session::create("Routes", [], ["writeToFile" => true]);
}
