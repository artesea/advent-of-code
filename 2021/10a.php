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
				break;
			}
		}
	}
}
print_r($bs);
$answer = 0;
foreach($bs as $b) {
	$answer += $b['c'] * $b['m'];
}
echo "Part 1 : {$answer}";

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
