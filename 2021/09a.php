<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("09.txt")));

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
		}
	}
}
echo $count;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
