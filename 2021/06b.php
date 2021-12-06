<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("06.txt")));

$fish = explode(",",$input);
$count = [];
foreach($fish as $f) {
	$count[$f] += 1;
}
for($d=1;$d<=256;$d++) {
	$temp = [];
	for($i=1;$i<=8;$i++) {
		$temp[$i-1] = $count[$i];
	}
	$temp[6] += $count[0];
	$temp[8] = $count[0];
	$count = $temp;
}

echo "Answer: " . array_sum($count);

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
