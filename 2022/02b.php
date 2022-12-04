<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = explode("\n",trim(str_replace("\r","",file_get_contents("02.txt"))));

$points = [];
$points["rock"] = 1;
$points["paper"] = 2;
$points["scissors"] = 3;
$code = [];
$code["A"] = $code["X"] = "rock";
$code["B"] = $code["Y"] = "paper";
$code["C"] = $code["Z"] = "scissors";


$me = $elf = 0;
foreach($input as $line) {
	$men = $elfn = 0;
	$bits = explode(" ",$line);
	$them = $code[$bits[0]];
	if($bits[1] == "X") { //lose
		switch($them) {
			case "rock":     $mine = "scissors"; break;
			case "paper":    $mine = "rock";     break;
			case "scissors": $mine = "paper";    break;
		}
		$men+=0;
		$elfn+=6;
	}
	else if($bits[1] == "Y") { //draw
		$mine = $them;
		$men+=3;
		$elfn+=3;
	}
	else {
		switch($them) {
			case "rock":     $mine = "paper";    break;
			case "paper":    $mine = "scissors"; break;
			case "scissors": $mine = "rock";     break;
		}
		$men+=6;
		$elfn+=0;			
	}
	
	$men+=$points[$mine];
	$elfn+=$points[$them];

	$elf+=$elfn;
	$me+=$men;
	
	echo $bits[0] . " ("  . $them . ")\t" . $elfn . "\t" . $bits[1] . " (" . $mine . ")\t" . $men . "\n";
	
	//print_r($bits);
}
echo "\n\nPart 2: " . $me;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
