<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = explode("\n",trim(str_replace("\r","",file_get_contents("01.txt"))));

$elfs = [];
$i = 0;
foreach($input as $line) {
	if($line == "") {
		$i++;
	}
	$elfs[$i] += (int)$line;
}
rsort($elfs);
echo print_r($elfs);
echo "\n\nPart 1: " . $elfs[0];
echo "\n\nPart 2: " . ($elfs[0]+$elfs[1]+$elfs[2]);

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
