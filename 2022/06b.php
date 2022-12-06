<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = str_replace("\r","",file_get_contents("06.txt"));
$part1 = $part2 = "";

$d = str_split($input);

for($i=0;$i<sizeof($d);$i++) {
	if(sizeof(array_unique(array_slice($d,$i,14))) == 14) {
		$part2 = $i+14;
		break;
	}
}

echo "\n\nPart 1: " . $part1;
echo "\n\nPart 2: " . $part2;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
