<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = explode("\n",(str_replace("\r","",file_get_contents("09.txt"))));
$part1 = $part2 = "";

$knot = [];
for($z=0;$z<=9;$z++) {
	$knot[$z] = [0,0];
}
$mark = [];

foreach($input as $line) {
	preg_match("#([UDLR]) (\d+)#", $line, $rule);
	for($i=1;$i<=$rule[2];$i++) {
		//move head
		switch($rule[1]) {
			case "U": $knot[0][1]++; break;
			case "D": $knot[0][1]--; break;
			case "L": $knot[0][0]--; break;
			case "R": $knot[0][0]++; break;
		}
		//move tail
		for($z=1;$z<=9;$z++) {
			$x = $knot[$z-1][0] - $knot[$z][0];
			$y = $knot[$z-1][1] - $knot[$z][1];
			
			if(abs($x) == 2) {
				$knot[$z][0]+= ($x>0?1:-1);
				if(abs($y) == 1) {
					$knot[$z][1]+= ($y>0?1:-1);
				}
			}
			if(abs($y) == 2) {
				$knot[$z][1]+= ($y>0?1:-1);
				if(abs($x) == 1) {
					$knot[$z][0]+= ($x>0?1:-1);
				}
			}
		}
		$mark[] = $knot[9][0] . "/" . $knot[9][1];
	}
}
print_r($mark);
$part2 = sizeof(array_unique($mark));


echo "\n\nPart 1: " . $part1;
echo "\n\nPart 2: " . $part2;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
