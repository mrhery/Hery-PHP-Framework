<?php
// Page::Load("loaded");

// $u = users::list();

// $u = users::getBy(["user_id" => 1]);

// $u = users::updateBy(["user_id" => 1], ["user_name" => "hery"]);
// $u = users::getBy(["user_id" => 1]);

// $u = users::insertInto([
	// "user_name" => "hakim",
	// "user_role"	=> 5
// ]);

// users::deleteBy(["user_id" => 2]);
// $u = users::list();

$u = DB::conn()->query("SELECT COUNT(*) as number FROM users")->results();

echo $u[0]->number;

print_r($u);


