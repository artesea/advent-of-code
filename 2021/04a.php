<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("04.txt")));
$lines = explode("\n",$input);

$balls = explode(",",$lines[0]);
$b = (sizeof($lines)-1)/6;
for($i=0;$i<$b;$i++) {
	for($l=0;$l<5;$l++) {
		$line = $lines[2+($i*6)+$l];
		for($j=0;$j<5;$j++) {
			$ball = (int)substr($line,$j*3,2);
			$board[$i]["row"][$l][] = $ball;
			$board[$i]["col"][$j][] = $ball;
		}
	}
}

$copy = array_merge($board);
$winning_board = -1;
$winning_ball = -1;
$winning_dir = "";
foreach($balls as $ball) {
	for($i=0;$i<sizeof($board);$i++){
		for($l=0;$l<5;$l++) {
			$row = 0; $col = 0;
			for($j=0;$j<5;$j++) {
				if($board[$i]["row"][$l][$j] == $ball) {
					$copy[$i]["row"][$l][$j] = "X";
				}
				if($board[$i]["col"][$l][$j] == $ball) {
					$copy[$i]["col"][$l][$j] = "X";
				}
				if($copy[$i]["row"][$l][$j] == "X") {
					$row++;
				}
				if($copy[$i]["col"][$l][$j] == "X") {
					$col++;
				}
			}
			if($row == 5 || $col == 5) {
				$winning_board = $i;
				$winning_ball = $ball;
				$winning_dir = ($row == 5) ? "row" : "col";
				break 3;
			}
		}
	}
}

$sum = 0;
for($l=0;$l<5;$l++) {
	for($j=0;$j<5;$j++) {
		if($copy[$winning_board][$winning_dir][$l][$j] !== "X") {
			$sum += $copy[$winning_board][$winning_dir][$l][$j];
		}
	}
}
$answer = $sum * $winning_ball;
		
echo "Winning Board: {$winning_board} Winning Ball: {$winning_ball} Sum: {$sum} Answer: {$answer}\n";
print_r($copy[$winning_board]);
print_r($board[$winning_board]);

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
