<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = explode("\n",(str_replace("\r","",file_get_contents("10.txt"))));
$part1 = $part2 = "";

$cycle = 0;
$x = 1;
$part1 = 0;
$col = 0;
$part2 = "\n";

foreach($input as $line) {
	for($z=1;$z<=($line=="noop"?1:2);$z++) {
		$cycle++;
		if($cycle%40 == 20) {
			$sig = $cycle*$x;
			$part1+=$sig;			
		}
		if($col >= $x-1 && $col <= $x+1) {
			$part2.="#";
		}
		else {
			$part2.=" ";
		}
		$col++;
		if($col==40) {
			$part2.="\n";
			$col=0;
		}
	}
	if(preg_match("#addx (\-?\d+)#",$line,$v)) {
		$x+=$v[1];
	}
}

echo "\n\nPart 1: " . $part1;
echo "\n\nPart 2: " . $part2;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
