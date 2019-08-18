<?php
//A journey start with a step

header("Content-Type: text/plain");
print_r(transactions::count());

print_r(
	transactions::select("*")
	->where()
	->limit(10)
	->fetch()
);