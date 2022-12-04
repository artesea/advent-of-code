<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = explode("\n",trim(str_replace("\r","",file_get_contents("03.txt"))));

$sum = 0;
foreach($input as $line) {
	$length = strlen($line);
	$left = str_split(substr($line,0,$length/2));
	$right = str_split(substr($line,$length/2));
	$intersect = array_unique(array_intersect($left,$right));
	
	print_r($intersect);
	foreach($intersect as $i) {
		$ord = ord($i);
		if($ord > 90) { //lowercase
			$ord-=96;
		}
		else { //uppercase
			$ord-=(64-26);
		}
		echo $i . "\t" . ord($i) . "\t" . $ord . "\n";
		$sum+=$ord;
	}
}

echo "\n\nPart 1: " . $sum;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
