<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("21.txt")));

preg_match_all("#Player (\d+) starting position: (\d+)#", $input, $matches);
for($i=0;$i<sizeof($matches[1]);$i++) {
	$player[$matches[1][$i]] = ["start" => $matches[2][$i], "score" => 0, "pos" => $matches[2][$i]];
}
print_r($player);

$dice = 0;
$turn = 1;
$rolled = 0;
while(1) {
	for($i=1;$i<=3;$i++) {
		$roll[$i] = ++$dice;
		$rolled++;
		if($dice == 100) $dice = 0;
	}
	$rolls = array_sum($roll);
	$space = ($player[$turn]["pos"] + $rolls) % 10;
	if($space == 0) $space = 10;
	$player[$turn]["pos"] = $space;
	$score = $player[$turn]["score"] + $space;
	$player[$turn]["score"] = $score;
	
	echo "- Player " . $turn . " rolls " . implode(",",$roll). " and moves to space " . $space . " for a total score of " . $score . "\n";
	
	if($score>=1000) break;
	
	$turn = ($turn==1) ? 2 : 1;
}
echo "<strong>Player " . $turn . " wins\n";
$loser = ($turn==1) ? 2 : 1;
echo $player[$loser]["score"] . " * " . $rolled . " = " . ($player[$loser]["score"]*$rolled);

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
