<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = explode("\n",trim(str_replace("\r","",file_get_contents("04.txt"))));

$part1 = 0;
foreach($input as $line) {
	preg_match("#(\d+)\-(\d+),(\d+)\-(\d+)#", $line, $ranges);
	print_r($ranges);
	if(($ranges[1]>=$ranges[3]&&$ranges[2]<=$ranges[4])||($ranges[3]>=$ranges[1]&&$ranges[4]<=$ranges[2])) {
		$part1++;
	}
}

echo "\n\nPart 1: " . $part1;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
