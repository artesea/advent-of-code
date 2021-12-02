<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("02.txt")));
$lines = explode("\n",$input);

$h = 0;
$d = 0;
foreach($lines as $line) {
	$bits = explode(" ", $line);
	switch($bits[0]) {
		case "forward": $h += (int)$bits[1]; break;
		case "down": $d += (int)$bits[1]; break;
		case "up": $d -= (int)$bits[1]; break;
	}
}
echo "h:{$h} d:{$d} a:" . ($d*$h);


$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
