<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("18.txt")));

function sf_add($a,$b) {
	return "[{$a},{$b}]";
}

function sf_reduce($a) {
	$o = $a;
	$a = sf_explode($a);
	if($a!=$o) {
		$a = sf_reduce($a);
	}
	else {
		$a = sf_split($a);
		if($a!=$o) {
			$a = sf_reduce($a);
		}
	}
	return $a;		
}

function sf_build_stack($a) {
	preg_match_all("#\[|\]|,|\d+#", $a, $matches);
	return $matches[0];
}

function sf_colaspe_stack($stack) {
	return implode("", $stack);
}

function sf_explode($a) {
	$stack = sf_build_stack($a);
	$opened = 0;
	for($i=0;$i<sizeof($stack)-2;$i++) {
		$v = $stack[$i];
		if($v=='[') $opened++;
		else if($v==']') $opened--;
		else if(is_numeric($v) && $stack[$i+1] == ',' && is_numeric($stack[$i+2]) && $opened > 4) {
			//[[6,[5,[4,[3,2]]]],1] becomes [[6,[5,[7,0]]],3].			
			//work backwards to find left int
			for($j=$i-1;$j>=0;$j--) {
				if(is_numeric($stack[$j])) {
					$stack[$j]+= $v;
					break;
				}
			}
			//work forward to find right int
			for($j=$i+3;$j<sizeof($stack);$j++) {
				if(is_numeric($stack[$j])) {
					$stack[$j]+= $stack[$i+2];
					break;
				}
			}
			//cut middle out
			array_splice($stack, $i-1,5,0);
			//echo "after explode:  " . sf_colaspe_stack($stack) . "\n";
			break;
		}
	}
	return sf_colaspe_stack($stack);
}

function sf_split($a) {
	$stack = sf_build_stack($a);
	for($i=0;$i<sizeof($stack);$i++) {
		$v = $stack[$i];
		if(is_numeric($v) && (int)$v >= 10) {
			array_splice($stack, $i, 1, ['[',floor($v/2),',',ceil($v/2),']']);
			//echo "after split:    " . sf_colaspe_stack($stack) . "\n";
			break;
		}
	}
	return sf_colaspe_stack($stack);
}

function sf_magnitude($a) {
	$a = preg_replace_callback(
		"#\[(\d+),(\d+)\]#",
		function($matches) {
			//print_r($matches);
			return ($matches[1]*3) + ($matches[2]*2);
		},
		$a
	);
	if(strpos($a,',') !== false) {
		$a = sf_magnitude($a);
	}
	return $a;
}

function sf_test($a) {
	echo "START:          " . $a . "\n";
	$a = sf_reduce($a);
	echo "END:            " . $a . "\n\n";
	return $a;
}

$lines = explode("\n", $input);
$max = 0;

for($i=0;$i<sizeof($lines);$i++) {
	for($j=0;$j<sizeof($lines);$j++) {
		if($i!=$j) {
			$sum = sf_magnitude(sf_reduce(sf_add($lines[$i],$lines[$j])));
			$max = max($max,$sum);
		}
	}
}
echo "Max Magnitude: " . $max . "\n";

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
