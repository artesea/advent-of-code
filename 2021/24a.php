<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("24.txt")));

$lines = explode("\n",$input);
$var = ['w'=>0,'x'=>0,'y'=>0,'z'=>0];
$inp = array_fill(1,14,9);
$pointer = 1;

$debug = isset($_GET['debug']);

$x = 0;
$y = 0;
$dump = [];
$lets = [];
for($i=0;$i<14;$i++) {
	$l = chr(65+$i);
	$stuff = [];
	$stuff[] = explode(" ",$lines[($i*18)+4])[2];
	$stuff[] = explode(" ",$lines[($i*18)+5])[2];
	$stuff[] = explode(" ",$lines[($i*18)+15])[2];
	if($stuff[0] == 1) {
		$dump[] = [$l,$stuff[2]];
	}
	else {
		$d = array_pop($dump);
		echo $l . ' = ' . $d[0] . (($d[1]+$stuff[1]>=0)?' + ':' - ') . abs($d[1]+$stuff[1]) . "\n";
		$lets[] = [$l,$d[0],$d[1]+$stuff[1]];
	}
}
echo "\n";

$min = $max = array_fill(1,14,0);
foreach($lets as $l) {
	$a = ord($l[0])-64;
	$b = ord($l[1])-64;
	if($l[2]>0) {
		$max[$a] = 9;
		$max[$b] = 9 - $l[2];
		$min[$b] = 1;
		$min[$a] = 1 + $l[2];
	}
	else {
		$max[$b] = 9;
		$max[$a] = 9 + $l[2];
		$min[$a] = 1;
		$min[$b] = 1 - $l[2];
	}
}
echo "Max: " . implode("", $max) . " " . alu($lines,$max) .  "\n";
echo "Min: " . implode("", $min) . " " . alu($lines,$max) .  "\n";

function alu($lines, $inp) {
	global $debug;
	$var = ['w'=>0,'x'=>0,'y'=>0,'z'=>0];
	foreach($lines as $line) {
		$bits = explode(" ",$line);
		if($bits[0] == "inp") {
			$var[$bits[1]] = array_shift($inp);
			if($debug) echo "\n\n" . str_pad($line,9," ") . "\t \t \t" . $bits[1] . "\t=\t". $var[$bits[1]] . "\n";
		}
		else {
			$a = $var[$bits[1]];
			$b = (is_numeric($bits[2])) ? $bits[2] : $var[$bits[2]];
			if($bits[0] == "add") {
				$var[$bits[1]] = $a + $b;
				if($debug) echo str_pad($line,9," ") . "\t" . $a . "\t+\t" . $b . "\t=\t". $var[$bits[1]] . "\n";
			}
			else if($bits[0] == "mul") {
				$var[$bits[1]] = $a * $b;
				if($debug) echo str_pad($line,9," ") . "\t" . $a . "\t*\t" . $b . "\t=\t". $var[$bits[1]] . "\n";
			}
			else if($bits[0] == "div") {
				if($b == 0) {
					if($debug) str_pad($line,9," ") . "\t" . $a . "\t/\t" . $b . "\t=\tDIV/0\n";
					return -1;
				}
				$var[$bits[1]] = floor($a / $b);
				if($debug) echo str_pad($line,9," ") . "\t" . $a . "\t/\t" . $b . "\t=\t". $var[$bits[1]] . "\n";
			}
			else if($bits[0] == "mod") {
				if($a<0 || $b<=0) {
					if($debug) echo str_pad($line,9," ") . "\t" . $a . "\t%\t" . $b . "\t=\tDIV/0\n";
					return -1;
				}
				$var[$bits[1]] = $a % $b;
				if($debug) echo  str_pad($line,9," ") . "\t" . $a . "\t%\t" . $b . "\t=\t". $var[$bits[1]] . "\n";
			}
			else if($bits[0] == "eql") {
				$var[$bits[1]] = ($a == $b) ? 1 : 0;
				if($debug) echo  str_pad($line,9," ") . "\t" . $a . "\t==\t" . $b . "\t=\t". $var[$bits[1]] . "\n";
			}
		}
	}
	return $var['z'];
}

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
