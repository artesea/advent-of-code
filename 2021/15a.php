<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("15.txt")));

//create lines array
$lines = explode("\n",$input);
$cavern = [];
for($r=0;$r<sizeof($lines);$r++) {
	for($c=0;$c<strlen($lines[$r]);$c++) {
		$cavern[$r][$c] = (int)$lines[$r][$c];
		$risk[$r][$c] = PHP_INT_MAX;
	}
}
//ignore initial square
$risk[0][0] = 0;
$max_rows = sizeof($cavern)-1;
$max_cols = sizeof($cavern[0])-1;

$queue = [[0,0]];

while(sizeof($queue)) {
	[$r, $c] = array_shift($queue);
	//up
	if(isset($cavern[$r-1][$c]) && $risk[$r-1][$c] > ($risk[$r][$c] + $cavern[$r-1][$c])) {
		$queue[] = [$r-1,$c];
		$risk[$r-1][$c] = $risk[$r][$c] + $cavern[$r-1][$c];
	}
	//down
	if(isset($cavern[$r+1][$c]) && $risk[$r+1][$c] > ($risk[$r][$c] + $cavern[$r+1][$c])) {
		$queue[] = [$r+1,$c];
		$risk[$r+1][$c] = $risk[$r][$c] + $cavern[$r+1][$c];
	}
	//left
	if(isset($cavern[$r][$c-1]) && $risk[$r][$c-1] > ($risk[$r][$c] + $cavern[$r][$c-1])) {
		$queue[] = [$r,$c-1];
		$risk[$r][$c-1] = $risk[$r][$c] + $cavern[$r][$c-1];
	}
	//down
	if(isset($cavern[$r][$c+1]) && $risk[$r][$c+1] > ($risk[$r][$c] + $cavern[$r][$c+1])) {
		$queue[] = [$r,$c+1];
		$risk[$r][$c+1] = $risk[$r][$c] + $cavern[$r][$c+1];
	}
}

echo "Part 1: " . $risk[$max_rows][$max_cols];

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
