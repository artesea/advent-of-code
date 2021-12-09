<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("09.txt")));

function check_neighbours($lines, $row, $col, $neighbours) {
	$neighbours[] = "{$row},{$col}";
	//left
	if($col>0) {
		$c = $col-1;
		$r = $row;
		$z = (int)$lines[$r][$c];
		if(!in_array("{$r},{$c}", $neighbours) && $z > $v && $z !== 9) {
			$neighbours = check_neighbours($lines, $r, $c, $neighbours);
		}
	}
	//right
	if($col<strlen($lines[$row])-1) {
		$c = $col+1;
		$r = $row;
		$z = (int)$lines[$r][$c];
		if(!in_array("{$r},{$c}", $neighbours) && $z > $v && $z !== 9) {
			$neighbours = check_neighbours($lines, $r, $c, $neighbours);
		}
	}
	//up
	if($row>0) {
		$c = $col;
		$r = $row-1;
		$z = (int)$lines[$r][$c];
		if(!in_array("{$r},{$c}", $neighbours) && $z > $v && $z !== 9) {
			$neighbours = check_neighbours($lines, $r, $c, $neighbours);
		}
	}
	//down
	if($row<sizeof($lines)-1) {
		$c = $col;
		$r = $row+1;
		$z = (int)$lines[$r][$c];
		if(!in_array("{$r},{$c}", $neighbours) && $z > $v && $z !== 9) {
			$neighbours = check_neighbours($lines, $r, $c, $neighbours);
		}
	}
	return $neighbours;
}

$lines = explode("\n",$input);
$count = 0;
for($row=0;$row<sizeof($lines);$row++) {
	for($col=0;$col<strlen($lines[$row]);$col++) {
		$lowest = true;
		$v = (int)$lines[$row][$col];
		if($col>0 && (int)$lines[$row][$col-1] <= $v) $lowest = false;
		if($col<strlen($lines[$row])-1 && (int)$lines[$row][$col+1] <= $v) $lowest = false;
		if($row>0 && (int)$lines[$row-1][$col] <= $v) $lowest = false;
		if($row<sizeof($lines)-1 && (int)$lines[$row+1][$col] <= $v) $lowest = false;
		if($lowest) {
			$count += 1 + $v;
			$neighbours = check_neighbours($lines, $row, $col, array());
			$basin[] = sizeof($neighbours);
		}
	}
}
rsort($basin);
$partb = $basin[0]*$basin[1]*$basin[2];
echo "Part 1: {$count} Part 2: {$partb}";

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
