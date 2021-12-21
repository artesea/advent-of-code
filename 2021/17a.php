<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("17.txt")));

preg_match("#x=(-?\d+)\.\.(-?\d+), y=(-?\d+)\.\.(-?\d++)#", $input, $range);
print_r($range);

$part1 = [0,0,0];
for($x=0;$x<=$range[2];$x++) {
	for($y=0;$y<abs($range[3]);$y++) {
		$velocity = [$x,$y];
		//echo "\nTrying: {$x},{$y}\n";
		$pos = [0,0];
		$quit = false;
		$max_y = 0;
		while(!$quit) {
			//echo "Current position: " . $pos[0] . "," . $pos[1] . "\n";
			//echo "Current velocity: " . $velocity[0] . "," . $velocity[1] . "\n";
			$pos[0] += $velocity[0];
			$pos[1] += $velocity[1];
			$max_y = max($pos[1], $max_y);
			$velocity[0] = max(0, $velocity[0]-1);
			$velocity[1]--;
			if($pos[0] >= $range[1] && $pos[0] <= $range[2] && $pos[1] >= $range[3] && $pos[1] <= $range[4]) {
				//echo "HIT:              " . $pos[0] . "," . $pos[1] . "\n";
				$quit = true;
				//echo "MAX Y: " . $max_y . "\n";
				if($max_y > $part1[2]) {
					$part1 = [$x,$y,$max_y];
				}
			}
			else if($pos[0] > $range[2]) {
				//echo "OVER SHOT:        " . $pos[0] . "," . $pos[1] . "\n";
				$quit = true;
			}
			else if($pos[1] < $range[3] && $velocity[1] < 0) {
				//echo "UNDER SHOT:       " . $pos[0] . "," . $pos[1] . "\n";
				$quit = true;
			}
			else {
				//echo "-->\n";
			}
		}
	}
}

echo "\n\nPart 1: " . print_r($part1,1);

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
