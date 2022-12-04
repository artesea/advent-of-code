<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = explode("\n",trim(str_replace("\r","",file_get_contents("01.txt"))));

$elfs = [];
$i = 0;
$l = 0;
$e = -1;
foreach($input as $line) {
	if($line == "") {
		if($elfs[$i] > $l) {
			$l = $elfs[$i];
			$e = $i;
		}
		$i++;
	}
	$elfs[$i] += (int)$line;
}
echo print_r($elfs);
echo "\n\nPart 1: " . $l;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
