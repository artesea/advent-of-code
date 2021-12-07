<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("07.txt")));

$crabs = explode(",",$input);
sort($crabs);
$min_fuel = PHP_INT_MAX;
$horizontal = -1;
for($d=$crabs[0];$d<=$crabs[sizeof($crabs)-1];$d++) {
	$fuel = 0;
	foreach($crabs as $crab) {
		$fuel += abs($d - $crab);
	}
	if($fuel < $min_fuel) {
		$min_fuel = $fuel;
		$horizontal = $d;
	}
	//echo "Fuel: {$fuel} Pos: {$d}\n";
}
echo "\nMin Fuel: {$min_fuel} Pos: {$horizontal}";

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
