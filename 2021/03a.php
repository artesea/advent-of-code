<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("03.txt")));
$lines = explode("\n",$input);

$gamma = "";
$epsilon = "";
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
}
echo "gamma:{$gamma} " . bindec($gamma) . " epsilon:{$epsilon} " . bindec($epsilon) . " power:" . bindec($gamma) * bindec($epsilon);


$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
