<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("22.txt")));

$lines = explode("\n",$input);
$reactor = [];
$count = 0;
foreach($lines as $line) {
	preg_match("#(on|off) x=(-?\d+)\.\.(-?\d+),y=(-?\d+)\.\.(-?\d++),z=(-?\d+)\.\.(-?\d++)#", $line, $code);
	//print_r($code);
	for($x=max(-50,$code[2]);$x<=min(50,$code[3]);$x++) {
		for($y=max(-50,$code[4]);$y<=min(50,$code[5]);$y++) {
			for($z=max(-50,$code[6]);$z<=min(50,$code[7]);$z++) {
				if($code[1] == "on") {
					if(!isset($reactor[$x][$y][$z])) {
						$reactor[$x][$y][$z] = 1;
						$count++;
					}
				}
				else {
					if(isset($reactor[$x][$y][$z])) {
						unset($reactor[$x][$y][$z]);
						$count--;
					}
				}
			}
		}
	}
	//echo "Count: {$count}\n";
}
echo "Count: {$count}\n";

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
