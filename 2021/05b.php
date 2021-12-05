<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("05.txt")));
$lines = explode("\n",$input);

$grid = [];
$crossed = 0;
foreach($lines as $line) {
	preg_match('|(\d+),(\d+) -> (\d+),(\d+)|', $line, $matches);
	if($matches[1] == $matches[3]) {
		for($i=min($matches[2],$matches[4]);$i<=max($matches[2],$matches[4]);$i++) {
			$grid[$matches[1]][$i] += 1;
			if($grid[$matches[1]][$i] == 2) $crossed++;
		}
	}
	else if($matches[2] == $matches[4]) {
		for($i=min($matches[1],$matches[3]);$i<=max($matches[1],$matches[3]);$i++) {
			$grid[$i][$matches[2]] += 1;
			if($grid[$i][$matches[2]] == 2) $crossed++;
		}
	}
	else if(abs($matches[1]-$matches[3]) == abs($matches[2]-$matches[4])) {
		$x_dir = ($matches[3]-$matches[1]) > 0 ? 1 : -1;
		$y_dir = ($matches[4]-$matches[2]) > 0 ? 1 : -1;
		for($i=0;$i<=abs($matches[1]-$matches[3]);$i++) {
			$x=$matches[1] + ($i*$x_dir);
			$y=$matches[2] + ($i*$y_dir);
			$grid[$x][$y] += 1;
			if($grid[$x][$y] == 2) $crossed++;
		}
	}
}
echo $crossed;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
