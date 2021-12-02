<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("02.txt")));
$lines = explode("\n",$input);

$h = 0;
$d = 0;
$a = 0;
foreach($lines as $line) {
	$bits = explode(" ", $line);
	$v = (int)$bits[1];
	switch($bits[0]) {
		case "forward": $h += $v; $d += ($a*$v); break;
		case "down": $a += $v; break;
		case "up": $a -= $v; break;
	}
}
echo "h:{$h} d:{$d} a:" . ($d*$h);


$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
