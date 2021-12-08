<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("08.txt")));

function chars_found($string, $chars) {
	$found = 0;
	foreach(str_split($chars) as $char) {
		if(strpos($string, $char) !== false) $found++;
	}
	return $found;
}

$lines = explode("\n",$input);
$count = 0;
foreach($lines as $line) {
	$segs = [];
	$digs = [];
	preg_match_all("#[a-g]+#", $line, $bits);
	//bits[0][0-9] are the potential, [10-13] are the outputs
	//pass one, sort everything alpha and find the easy bits (1,4,7,8)
	for($i=0;$i<sizeof($bits[0]);$i++) {
		$temp = str_split($bits[0][$i]);
		sort($temp,SORT_STRING);
		$bits[0][$i] = implode("", $temp);
		
		$t = $bits[0][$i];
		$s = strlen($bits[0][$i]);
		switch($s) {
			case 2: $segs[1] = $t; $digs[$t] = 1; break;
			case 3: $segs[7] = $t; $digs[$t] = 7; break;
			case 4: $segs[4] = $t; $digs[$t] = 4; break;
			case 7: $segs[8] = $t; $digs[$t] = 8; break;
		}
	}
	//pass two, find 3, 6 and 9
	for($i=0;$i<10;$i++) {
		$t = $bits[0][$i];
		$s = strlen($bits[0][$i]);
		if(!isset($digs[$t])) {
			if($s == 5 && chars_found($t, $segs[1]) == 2) {
				$segs[3] = $t; $digs[$t] = 3;
			}
			else if($s == 6 && chars_found($t, $segs[4]) == 4) {
				$segs[9] = $t; $digs[$t] = 9;
			}
			else if($s == 6 && chars_found($t, $segs[1]) == 1) {
				$segs[6] = $t; $digs[$t] = 6;
			}
		}
	}
	//pass three, find 0, 2, 5
	for($i=0;$i<10;$i++) {
		$t = $bits[0][$i];
		$s = strlen($bits[0][$i]);
		if(!isset($digs[$t])) {
			if($s == 6) {
				$segs[0] = $t; $digs[$t] = 0;
			}
			else if($s == 5 && chars_found($segs[6], $t) == 5) {
				$segs[5] = $t; $digs[$t] = 5;
			}
			else if($s == 5 && chars_found($segs[6], $t) == 4) {
				$segs[2] = $t; $digs[$t] = 2;
			}
		}
	}
	$digit = "";
	for($i=10;$i<=13;$i++) {
		$digit .= $digs[$bits[0][$i]];
	}
	/*
	ksort($segs);
	print_r($bits[0]);
	print_r($segs);
	print_r($digs);
	echo $digit . "\n";
	*/
	$count += (int)$digit;
}
echo $count;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
