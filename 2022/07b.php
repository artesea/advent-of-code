<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = explode("\n",(str_replace("\r","",file_get_contents("07.txt"))));
$part1 = $part2 = "";

$dirs = [];
$cd = [];
foreach($input as $line) {
	if($line == "$ cd /") {
		$cd = array("");
	}
	else if(preg_match("#cd ([a-z]+)#", $line, $matches)) {
		array_push($cd,$matches[1]);
	}
	else if(preg_match("#([0-9]+) ([a-z\.]+)#", $line, $matches)) {
		$dirs[implode("/",$cd)] += $matches[1];
	}
	else if($line == "$ cd ..") {
		$temp = $dirs[implode("/",$cd)];
		array_pop($cd);
		$dirs[implode("/",$cd)] += $temp;
	}
}
//move back to root if not already there
while(sizeof($cd) > 1) {
	$temp = $dirs[implode("/",$cd)];
	array_pop($cd);
	$dirs[implode("/",$cd)] += $temp;
}
print_r($dirs);

echo "\n\nPart 2\n";
$space = 70000000 - $dirs[""];
$find = 30000000 - $space;
echo "Space left on drive\t{$space}\nNeed\t\t\t{$find}\n";

//sum small dirs
$part1 = 0;
$part2 = 70000000;
foreach($dirs as $d) {
	if($d <= 100000) {
		$part1 += $d;
	}
	if($d>= $find && $d<$part2) {
		$part2 = $d;
	}
}



echo "\n\nPart 1: " . $part1;
echo "\n\nPart 2: " . $part2;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
