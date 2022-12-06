<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = str_replace("\r","",file_get_contents("06.txt"));
$part1 = $part2 = "";

$d = str_split($input);

for($i=0;$i<sizeof($d);$i++) {
	$s = array_slice($d,$i,4);
	print_r($s);
	$u = array_unique($s);
	print_r($u);
	if(sizeof($u) == 4) {
		$part1 = $i+4;
		echo "FOUND IT {$i}\n\n";
		break;
	}
}

echo "\n\nPart 1: " . $part1;
echo "\n\nPart 2: " . $part2;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
