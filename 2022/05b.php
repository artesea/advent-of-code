<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = explode("\n",(str_replace("\r","",file_get_contents("05.txt"))));
$part1 = $part2 = "";

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
		$move = array_slice($stack[$matches[2]],-$matches[1]);
		$stack[$matches[2]] = array_slice($stack[$matches[2]],0,-$matches[1]);
		$stack[$matches[3]] = array_merge($stack[$matches[3]],$move);
	}
}
print_r($stack);
for($j=1;$j<=$n;$j++) {
	$part2 .= $stack[$j][sizeof($stack[$j])-1];
}

echo "\n\nPart 2: " . $part2;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
