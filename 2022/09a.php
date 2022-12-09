<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = explode("\n",(str_replace("\r","",file_get_contents("09.txt"))));
$part1 = $part2 = "";

$head = [0,0];
$tail = [0,0];
$mark = [];

foreach($input as $line) {
	preg_match("#([UDLR]) (\d+)#", $line, $rule);
	for($i=1;$i<=$rule[2];$i++) {
		//move head
		switch($rule[1]) {
			case "U": $head[1]++; break;
			case "D": $head[1]--; break;
			case "L": $head[0]--; break;
			case "R": $head[0]++; break;
		}
		//move tail
		$x = $head[0] - $tail[0];
		$y = $head[1] - $tail[1];
		
		if(abs($x) == 2) {
			$tail[0]+= ($x>0?1:-1);
			if(abs($y) == 1) {
				$tail[1]+= ($y>0?1:-1);
			}
		}
		if(abs($y) == 2) {
			$tail[1]+= ($y>0?1:-1);
			if(abs($x) == 1) {
				$tail[0]+= ($x>0?1:-1);
			}
		}
		$mark[] = $tail[0] . "/" . $tail[1];
	}
}
print_r($mark);
$part1 = sizeof(array_unique($mark));


echo "\n\nPart 1: " . $part1;
echo "\n\nPart 2: " . $part2;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
