<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("14.txt")));

$mapings = [];
$before = [];
$lines = explode("\n",$input);
$template = $lines[0];
for($i=0;$i<strlen($template)-1;$i++) {
	$pair = substr($template,$i,2);
	$before[$pair]++;
}
for($i=2;$i<sizeof($lines);$i++) {
	$bits = explode(" -> ", $lines[$i]);
	$mapings[$bits[0]] = $bits[1];
}

//loop
for($step=1;$step<=10;$step++) {
	$after = [];
	foreach($before as $pair => $count) {
		$left = $pair[0] . $mapings[$pair];
		$right = $mapings[$pair] . $pair[1];
		$after[$left] += $count;
		$after[$right] += $count;
	}
	$before = $after;
}

//count letters
foreach($before as $pair => $count) {
	$left = $pair[0];
	$letters[$left] += $count;
}
$letters[substr($template,-1)] += 1; //need to add the final letter back on
print_r($letters);
sort($letters);
//print_r($letters);

$answer = $letters[sizeof($letters)-1] - $letters[0];
echo "Part 1: {$answer}\n";	

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
