<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = explode("\n",(str_replace("\r","",file_get_contents("07.txt"))));
$part1 = $part2 = "";

$dirs = [];
$cd = [];
foreach($input as $line) {
	echo "\n{$line}\n";
	if($line == "$ cd /") {
		echo "- root directory";
		$cd = array("");
	}
	else if(preg_match("#cd ([a-z]+)#", $line, $matches)) {
		echo "- changing directory\n";
		print_r($matches);
		array_push($cd,$matches[1]);
		print_r($cd);
	}
	else if(preg_match("#([0-9]+) ([a-z\.]+)#", $line, $matches)) {
		echo "- file found\n";
		print_r($matches);
		$dirs[implode("/",$cd)] += $matches[1];
	}
	else if($line == "$ cd ..") {
		echo "- moving out of directory\n";
		$temp = $dirs[implode("/",$cd)];
		array_pop($cd);
		$dirs[implode("/",$cd)] += $temp;
		print_r($cd);
	}
}
echo "\n\nReached end, move back to root\n";
//move back to root if not already there
while(sizeof($cd) > 1) {
	echo "- moving out of directory\n";
	$temp = $dirs[implode("/",$cd)];
	array_pop($cd);
	$dirs[implode("/",$cd)] += $temp;
	print_r($cd);
}
print_r($dirs);

//sum small dirs
$part1 = 0;
foreach($dirs as $d) {
	if($d <= 100000) {
		$part1 += $d;
	}
}

echo "\n\nPart 1: " . $part1;
echo "\n\nPart 2: " . $part2;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
