<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("13.txt")));

$before = [];
$folds = [];
$max_x = 0;
$max_y = 0;
$lines = explode("\n",$input);
foreach($lines as $line) {
	if(preg_match("#(\d+),(\d+)#", $line, $matches)) {
		$before[$matches[2]][$matches[1]] = "#";
		$max_x = max($max_x, $matches[1]);
		$max_y = max($max_y, $matches[2]);
	}
	else if(preg_match("#fold along ([xy])=(\d+)#", $line, $matches)) {
		$folds[] = [$matches[1],$matches[2]];
	}
}

//fold
foreach($folds as $fold) {
	$after = [];
	foreach($before as $y => $line) {
		foreach($line as $x => $s) {
			if($fold[0] == "x") {
				if($x > $fold[1]) {
					$after[$y][$max_x - $x] = $s;
				}
				else {
					$after[$y][$x] = $s;
				}
			}
			else {
				if($y > $fold[1]) {
					$after[$max_y - $y][$x] = $s;
				}
				else {
					$after[$y][$x] = $s;
				}
			}
		}
	}
	if($fold[0] == "x") {
		$max_x = $fold[1] - 1;
	}
	else {
		$max_y = $fold[1] - 1;
	}
	$before = $after;
}

for($y=0;$y<=$max_y;$y++) {
	for($x=0;$x<=$max_x;$x++) {
		echo (isset($before[$y][$x])) ? "#" : " ";
	}
	echo "\n";
}	

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
