<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = explode("\n",trim(str_replace("\r","",file_get_contents("02.txt"))));

$points = [];
$points["rock"] = 1;
$points["paper"] = 2;
$points["scissors"] = 3;
$wins = [];
$wins["rock"] = "scissors";
$wins["paper"] = "rock";
$wins["scissors"] = "paper";
$code = [];
$code["A"] = $code["X"] = "rock";
$code["B"] = $code["Y"] = "paper";
$code["C"] = $code["Z"] = "scissors";


$me = $elf = 0;
foreach($input as $line) {
	$men = $elfn = 0;
	$bits = explode(" ",$line);
	$mine = $code[$bits[1]];
	$them = $code[$bits[0]];
	$me+=$points[$mine];
	$elf+=$points[$them];
	if($wins[$mine] == $them) {
		$me+=6;
	}
	else if($wins[$them] == $mine) {
		$elf+=6;
	}
	else {
		$me+=3;
		$elf+=3;
	}
	
	//echo $bits[0] . " ("  . $code[$bits[0]] . ")\t" . $elfn . "\t" . $bits[1] . " (" . $code[$bits[1]] . ")\t" . $men . "\n";
	
	//print_r($bits);
}

echo "\n\nPart 1: " . $me;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
