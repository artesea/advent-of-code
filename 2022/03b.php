<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = explode("\n",trim(str_replace("\r","",file_get_contents("03.txt"))));

$sum = 0;
for($x=0;$x<sizeof($input);$x+=3) {
	$intersect = array_unique(array_intersect(str_split($input[$x]),str_split($input[$x+1]),str_split($input[$x+2])));
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

echo "\n\nPart 2: " . $sum;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
