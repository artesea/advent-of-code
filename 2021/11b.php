<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("11.txt")));

//create octopus array
$lines = explode("\n",$input);
$oct = [];
for($r=0;$r<sizeof($lines);$r++) {
	for($c=0;$c<strlen($lines[$r]);$c++) {
		$oct[$r][$c] = (int)$lines[$r][$c];
	}
}

//variables
$loops = 100;
$flashes = 0;
$sync = 0;

//loop
$l=0;
while($sync==0) {
	$l++;
	//first pass, add 1 to everything and set 
	for($r=0;$r<sizeof($oct);$r++) {
		for($c=0;$c<sizeof($oct[$r]);$c++) {
			$oct[$r][$c]++;
		}
	}
	//next pass, flash flash
	for($r=0;$r<sizeof($oct);$r++) {
		for($c=0;$c<sizeof($oct[$r]);$c++) {
			if($oct[$r][$c] >9) {
				$oct = flash($oct, $r, $c);
			}
		}
	}
	$sum = 0;
	foreach($oct as $row) {
		$sum+= array_sum($row);
	}
	if($sum==0) {
		$sync = $l;
	}
}

function flash($oct, $r, $c) {
	global $flashes;
	$flashes++;
	$oct[$r][$c] = 0;
	for($i=-1;$i<=1;$i++) {
		for($j=-1;$j<=1;$j++) {
			if($i==0 && $j==0) {
			}
			else {
				if($r+$i >= 0 && $r+$i < sizeof($oct) && $c+$j >= 0 && $c+$j < sizeof($oct[$r]) && $oct[$r+$i][$c+$j] != 0) {
					$oct[$r+$i][$c+$j]++;
					if($oct[$r+$i][$c+$j] >9) {
						$oct = flash($oct, $r+$i, $c+$j);
					}
				}
			}
		}
	}
	return $oct;
}

echo "Synchronize: {$sync}";

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
