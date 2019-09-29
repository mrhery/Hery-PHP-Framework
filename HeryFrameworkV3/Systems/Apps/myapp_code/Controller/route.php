<?php


if(
users::insertInto([
	"name"		=> Input::post("name"),
	"address"	=> Input::post("address")
])
){
	echo "Done " . url::get(1);
}