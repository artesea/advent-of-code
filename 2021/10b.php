<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("10.txt")));

$bs = array(
	')' => array('op' => '(', 'c' => 0, 'm' => 3),
	']' => array('op' => '[', 'c' => 0, 'm' => 57),
	'}' => array('op' => '{', 'c' => 0, 'm' => 1197),
	'>' => array('op' => '<', 'c' => 0, 'm' => 25137)
);
$rs = array(
	'(' => array('op' => ')', 'p' => 1),
	'[' => array('op' => ']', 'p' => 2),
	'{' => array('op' => '}', 'p' => 3),
	'<' => array('op' => '>', 'p' => 4)
);
$autocomplete = [];

$lines = explode("\n",$input);
foreach($lines as $line) {
	$error = false;
	$brackets = [];
	for($i=0;$i<strlen($line);$i++) {
		$c = $line[$i];
		if($c=='(' || $c=='[' || $c=='{' || $c=='<') {
			array_push($brackets, $c);
		}
		else {
			$x = array_pop($brackets);
			if($bs[$c]['op'] != $x) {
				$bs[$c]['c'] += 1;
				$error = true;
				break;
			}
		}
	}
	if(!$error) {
		//need to autocomplete
		$score = 0;
		while(sizeof($brackets) > 0) {
			$x = array_pop($brackets);
			$score *= 5;
			$score += $rs[$x]['p'];
		}
		$autocomplete[] = $score;
	}
}
//print_r($bs);
$parta = 0;
foreach($bs as $b) {
	$parta += $b['c'] * $b['m'];
}

sort($autocomplete);
//print_r($autocomplete);
$partb = $autocomplete[(sizeof($autocomplete)-1)/2];


echo "Part 1: {$parta} Part 2: {$partb}";

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
