<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("06.txt")));

$fish = explode(",",$input);
for($d=1;$d<=80;$d++) {
	$toadd = 0;
	for($i=0;$i<sizeof($fish);$i++) {
		if($fish[$i] == 0) {
			$fish[$i] = 6;
			$toadd++;
		}
		else {
			$fish[$i] -= 1;
		}
	}
	for($i=0;$i<$toadd;$i++) {
		$fish[] = 8;
	}
	/*
	if($d<=18) {
		echo "After {$d} days: " . implode(",",$fish) . "\n";
	}
	*/
}
echo "Answer: " . sizeof($fish);

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
