<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("22.txt")));

$lines = explode("\n",$input);
$cubes = [];

$i = 1;
foreach($lines as $line) {
	preg_match("#(on|off) x=(-?\d+)\.\.(-?\d+),y=(-?\d+)\.\.(-?\d++),z=(-?\d+)\.\.(-?\d++)#", $line, $code);
	$code[1] = ($code[1] == "on") ? 1 : -1;
	//echo "\nLine Data:\n";
	//print_r($code);
	$new = [];
	foreach($cubes as $cube) {
		$ax = max($code[2],$cube[2]);
		$bx = min($code[3],$cube[3]);
		$ay = max($code[4],$cube[4]);
		$by = min($code[5],$cube[5]);
		$az = max($code[6],$cube[6]);
		$bz = min($code[7],$cube[7]);
		if($ax <= $bx && $ay <= $by && $az <= $bz) {
			//echo "Overlapping:\n";
			$overlap = ["", -$cube[1], $ax, $bx, $ay, $by, $az, $bz];
			//print_r($overlap);
			$new[] = $overlap;
		}
	}
	if($code[1] == 1) $new[] = $code;
	//echo "New stuff:\n";
	//print_r($new);
	$cubes = array_merge($cubes, $new);
	//echo "Updated cubes:\n";
	//print_r($cubes);
	$i++;
	//if($i>5) break;
}

$volume = 0;
foreach($cubes as $cube) {
	$volume += $cube[1] * ($cube[3]-$cube[2]+1) * ($cube[5]-$cube[4]+1) * ($cube[7]-$cube[6]+1);
}
echo "Volume: {$volume}";

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
