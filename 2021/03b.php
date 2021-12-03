<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("03.txt")));
$lines = explode("\n",$input);

$gamma = "";
$epsilon = "";
$oxygen = array_merge($lines);
$cotwo = array_merge($lines);
for($i=0;$i<strlen(trim($lines[0]));$i++) {
	$ones  = 0;
	$zeros = 0;
	foreach($lines as $line) {
		if($line[$i] == "0") $zeros++;
		else if($line[$i] == "1") $ones++;
	}
	if($zeros>$ones) {
		$gamma   .= "0";
		$epsilon .= "1";
	}
	else if($ones>$zeros) {
		$gamma   .= "1";
		$epsilon .= "0";
	}
	else { //should never hit
		$gamma   .= "X";
		$epsilon .= "X";
	}
	//echo "{$i} 0:{$zeros} 1:{$ones} gamma:{$gamma} espilon:{$epsilon}\n";
	if(sizeof($oxygen) > 1) {
		$temp_oxygen = [];
		$ones  = 0;
		$zeros = 0;
		foreach($oxygen as $line) {
			if($line[$i] == "0") $zeros++;
			else if($line[$i] == "1") $ones++;
		}
		foreach($oxygen as $line) {
			if($zeros>$ones) {
				if($line[$i] == "0") $temp_oxygen[] = $line;
			}
			else {
				if($line[$i] == "1") $temp_oxygen[] = $line;
			}
		}
		$oxygen = array_merge($temp_oxygen);
	}
	if(sizeof($cotwo) > 1) {
		$temp_cotwo = [];
		$ones  = 0;
		$zeros = 0;
		foreach($cotwo as $line) {
			if($line[$i] == "0") $zeros++;
			else if($line[$i] == "1") $ones++;
		}		
		foreach($cotwo as $line) {
			if($zeros<=$ones) {
				if($line[$i] == "0") $temp_cotwo[] = $line;
			}
			else {
				if($line[$i] == "1") $temp_cotwo[] = $line;
			}
		}
		$cotwo = array_merge($temp_cotwo);
	}
}
echo "gamma:{$gamma} " . bindec($gamma) . " epsilon:{$epsilon} " . bindec($epsilon) . " power:" . bindec($gamma) * bindec($epsilon) . "\n";
echo "oxygen:{$oxygen[0]} " . bindec($oxygen[0]) . " co2:{$cotwo[0]} " . bindec($cotwo[0]) . " life:" . bindec($oxygen[0]) * bindec($cotwo[0]) . "\n";



$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
