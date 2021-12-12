<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("12.txt")));

$paths = [];
$lines = explode("\n",$input);
foreach($lines as $line) {
	$bits = explode("-",$line);
	$paths[$bits[0]][] = $bits[1];
	$paths[$bits[1]][] = $bits[0];
}

$cave = "start";
$history = [];
$count = track($paths, $cave, $history);

function track($paths, $cave, $history) {
	$count = 0;
	$history[] = $cave;
	foreach($paths[$cave] as $path) {
		//small cave, not already visited
		if(strtolower($path) === $path && in_array($path,$history)) {
			//bad path, go no further
		}
		else if($path == "end") {
			//reached the end
			$count += 1;
			//echo implode(",",$history) ."\n";
		}
		else {
			$count += track($paths, $path, $history);
		}
	}
	return $count;
}

echo "\nCount: {$count}";

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
