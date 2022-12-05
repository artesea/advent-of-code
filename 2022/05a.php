<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = explode("\n",(str_replace("\r","",file_get_contents("05.txt"))));
$part1 = "";

$n = 9;
$stack = [];
for($j=1;$j<=$n;$j++) {
	$stack[$j] = [];
}
for($i=0;$i<sizeof($input);$i++) {
	$line = $input[$i];
	if(strpos($line,"[") !== false) {
		//echo "Line: {$i}\t{$line}\n";
		for($j=1;$j<=$n;$j++) {
			$char = $line[$j*4-3];
			if(trim($char) != "") {
				//echo "Found {$char} in stack {$j}\n";
				array_unshift($stack[$j], $char);
			}
		}
	}
	else if(strpos($line,"move") !== false) {
		print_r($stack);
		preg_match("#move (\d+) from (\d) to (\d)#", $line, $matches);
		echo "{$line}\n";
		print_r($matches);
		for($x=1;$x<=$matches[1];$x++) {
			array_push($stack[$matches[3]],array_pop($stack[$matches[2]]));
		}
	}
}
print_r($stack);
for($j=1;$j<=$n;$j++) {
	$part1 .= $stack[$j][sizeof($stack[$j])-1];
}

echo "\n\nPart 1: " . $part1;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
