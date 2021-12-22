<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("21.txt")));

preg_match_all("#Player (\d+) starting position: (\d+)#", $input, $matches);
for($i=0;$i<sizeof($matches[1]);$i++) {
	$player[$matches[1][$i]] = ["start" => $matches[2][$i], "score" => 0, "pos" => $matches[2][$i]];
}

for($a=1;$a<=3;$a++) {
	for($b=1;$b<=3;$b++) {
		for($c=1;$c<=3;$c++) {
			$states[$a+$b+$c]++;
		}
	}
}
//print_r($states);
//$states = [3=>1,4=>3,5=>6,6=>7,7=>6,8=>3,9=>1];
//print_r($player);

function dirac($player, $turn, $universes, $goes) {
	global $states;
	global $wins;
	$inital_score = $player[$turn]["score"];
	$inital_pos = $player[$turn]["pos"];
	foreach($states as $rolls => $times) {
		$space = ($inital_pos + $rolls) % 10;
		if($space == 0) $space = 10;
		$player[$turn]["pos"] = $space;
		$score = $inital_score + $space;
		$player[$turn]["score"] = $score;
		//echo str_pad("", $goes, " ") . "- Player " . $turn . " rolls " . $rolls. " and moves to space " . $space . " for a total score of " . $score . "\n";
		if($score >= 21) {
			$wins[$turn] += ($universes * $times);
			//echo str_pad("", $goes, " ") . "* Player " . $turn . " wins " . ($universes * $times) . " - total " . $wins[$turn] . "\n"; 
		}
		else {
			$next_turn = ($turn==1) ? 2 : 1;
			dirac($player, $next_turn, $universes * $times, $goes+1);
		}
	}
}

$wins = [1=>0,2=>0];
dirac($player, 1, 1, 0);
print_r($wins);

echo "Most universes: " . max($wins);


$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";