<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = explode("\n",(str_replace("\r","",file_get_contents("08.txt"))));
$part1 = $part2 = "";

//echo implode("\n",$input) . "\n\n";

//build grid
$trees = [];
foreach($input as $line) {
	$trees[] = str_split($line);
}
//print_r($trees);
$grid = $trees;

for($y=0;$y<sizeof($trees);$y++) {
	$max = -1;
	for($x=0;$x<sizeof($trees[0]);$x++) {
		if($trees[$y][$x] > $max) {
			$max = $trees[$y][$x];
			$grid[$y][$x] = "x";
		}
	}
	$max = -1;
	for($x=sizeof($trees[0])-1;$x>=0;$x--) {
		if($trees[$y][$x] > $max) {
			$max = $trees[$y][$x];
			$grid[$y][$x] = "x";
		}
	}
}
for($x=0;$x<sizeof($trees[0]);$x++) {
	$max = -1;
	for($y=0;$y<sizeof($trees);$y++) {
		if($trees[$y][$x] > $max) {
			$max = $trees[$y][$x];
			$grid[$y][$x] = "x";
		}
	}
	$max = -1;
	for($y=sizeof($trees)-1;$y>=0;$y--) {
		if($trees[$y][$x] > $max) {
			$max = $trees[$y][$x];
			$grid[$y][$x] = "x";
		}
	}
}
//print_r($trees);
//print_r($grid);

$part1 = $part2 = 0;
for($y=0;$y<sizeof($trees);$y++) {
	//echo implode("",$grid[$y]) . "\n";
	for($x=0;$x<sizeof($trees[0]);$x++) {
		if($grid[$y][$x] == "x") {
			$part1++;
		}
	}
}

echo "\n\nPart 1: " . $part1;
echo "\n\nPart 2: " . $part2;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
