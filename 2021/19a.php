<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("19.txt")));

//too high 371, 368

$lines = explode("\n", $input);
$id = -1;
foreach($lines as $line) {
	if(preg_match("#--- scanner (\d+) ---#", $line, $matches)) {
		$id = $matches[1];
		$tofind[] = $matches[1];
	}
	else if(trim($line) !== "") {
		$scanner[$id][] = explode(",",$line);
		$strings[$id][] = $line;
	}
}
//print_r($scanner);

$diffs = [];
$diffs_lib = [];
//cal diffs
for($i=0;$i<sizeof($scanner);$i++) {
	$scan_diff = [];
	for($x=0;$x<sizeof($scanner[$i]);$x++) {
		for($y=$x+1;$y<sizeof($scanner[$i]);$y++) {
			$a = $scanner[$i][$x];
			$b = $scanner[$i][$y];
			$distance = ($b[0]-$a[0])**2 + ($b[1]-$a[1])**2 + ($b[2]-$a[2])**2;
			$scan_diff[] = $distance;
			$diffs_lib[$i][$distance] = [$a,$b];
		}
	}
	sort($scan_diff);
	$diffs[] = $scan_diff;
}
//print_r($diffs_lib);
//print_r($diffs);

//we assume that the first scanner is "correct" at 0,0,0
$loc[0] = [0,0,0];
$toscan[] = 0;
$found[] = 0;

while(sizeof($toscan)) {
	$i = array_pop($toscan);
	for($j=0;$j<sizeof($diffs);$j++) {
		if(!in_array($j,$found)) {
			$union = array_intersect($diffs[$i], $diffs[$j]);
			if(sizeof($union) >= 66) { //trig num of 12
				$temp = [];
				$offsets = [];
				echo "\nScanner {$i} and {$j} have at least " . sizeof($union) . " matches\n";
				foreach($union as $u) {
					$key_ia = implode(",",$diffs_lib[$i][$u][0]);
					$key_ib = implode(",",$diffs_lib[$i][$u][1]);
					$key_ja = implode(",",$diffs_lib[$j][$u][0]);
					$key_jb = implode(",",$diffs_lib[$j][$u][1]);
					$temp["{$key_ia}|{$key_ja}"]++;
					$temp["{$key_ib}|{$key_ja}"]++;
					$temp["{$key_ia}|{$key_jb}"]++;
					$temp["{$key_ib}|{$key_jb}"]++;
					//echo $u . "\t" . implode(",",$diffs_lib[$i][$u][0]) . "\t" . implode(",",$diffs_lib[$i][$u][1]) . "\t=>\t" . implode(",",$diffs_lib[$j][$u][0]) . "\t" . implode(",",$diffs_lib[$j][$u][1]) . "\n";
				}
				
				//print_r($temp);
				foreach($temp as $t => $v) {
					if($v>=11) { //the cord matched with with 11 others
						[$key_i,$key_j] = explode("|",$t);
						[$ix,$iy,$iz] = explode(",",$key_i);
						$beacon_j = explode(",",$key_j);
						$rotations = rotations($beacon_j);
						for($r=0;$r<24;$r++) {
							[$jx,$jy,$jz] = $rotations[$r];
							$dx = $ix-$jx;
							$dy = $iy-$jy;
							$dz = $iz-$jz;
							$offsets[$r]["{$dx},{$dy},{$dz}"]++;
						}
					}
				}
				//print_r($offsets);
				$rot = -1;
				foreach($offsets as $r => $v) {
					if(sizeof($v) == 1) {
						$rot = $r;
						$off = explode(",",key($v));
					}
				}
				if($rot == -1) {
					echo "<strong>Didn't find a rotation!</strong>\n";
				}
				else {
					//rotate and move found item
					echo "Rotation {$rot} needed, and offset is " . implode(",",$off) . "\n";
					$loc[$j] = $off;
					//print_r($scanner[$j]);
					for($t=0;$t<sizeof($scanner[$j]);$t++) {
						$scan = $scanner[$j][$t];
						$rots = rotations($scan);
						$new  = [$rots[$rot][0]+$loc[$j][0],$rots[$rot][1]+$loc[$j][1],$rots[$rot][2]+$loc[$j][2]];
						$scanner[$j][$t] = $new;
						$strings[$j][$t] = implode(",",$new);
					}
					//print_r($scanner[$j]);
					//rebuild diffs lib (sure we could do something better than this)
					for($x=0;$x<sizeof($scanner[$j]);$x++) {
						for($y=$x+1;$y<sizeof($scanner[$j]);$y++) {
							$a = $scanner[$j][$x];
							$b = $scanner[$j][$y];
							$distance = ($b[0]-$a[0])**2 + ($b[1]-$a[1])**2 + ($b[2]-$a[2])**2;
							$diffs_lib[$j][$distance] = [$a,$b];
						}
					}
					$found[] = $j;
					$toscan[] = $j;
					$uni = array_intersect($strings[$i],$strings[$j]);
					//print_r($uni);
					echo "Now have " . sizeof($uni) . " intersections\n";
				}
			}
		}
	}
}
//finally loop through all the scanners and save unique beacons
$unique = [];
foreach($strings as $id => $scan) {
	foreach($scan as $beacon) {
		//$unique[$beacon][] = $id;
		if(!in_array($beacon,$unique)) $unique[] = $beacon;
	}
}
//$unique = array_unique($unique);
//print_r($unique);
echo "\n\nBeacons: " . sizeof($unique) . "\n";
//print_r($loc);

$max = 0;
for($a=0;$a<sizeof($loc);$a++) {
	for($b=$a+1;$b<sizeof($loc);$b++) {
		$manhattan = abs($loc[$a][0]-$loc[$b][0]) + abs($loc[$a][1]-$loc[$b][1]) + abs($loc[$a][2]-$loc[$b][2]);
		$max = max($max,$manhattan);
	}
}
echo "Max Manhattan: {$max}\n";

function rotations($beacon) {
	[$x,$y,$z] = $beacon;
	return [
		[ $x, $y, $z],
		[ $x, $z,-$y],
		[ $x,-$y,-$z],
		[ $x,-$z, $y],
		
		[-$x,-$y, $z],
		[-$x,-$z,-$y],
		[-$x, $y,-$z],
		[-$x, $z, $y],
		
		[ $y,-$x, $z],
		[ $y, $z, $x],
		[ $y, $x,-$z],
		[ $y,-$z,-$x],
		
		[-$y, $x, $z],
		[-$y,-$z, $x],
		[-$y,-$x,-$z],
		[-$y, $z,-$x],
		
		[ $z, $y,-$x],
		[ $z, $x, $y],
		[ $z,-$y, $x],
		[ $z,-$x,-$y],
		
		[-$z,-$y,-$x],
		[-$z,-$x, $y],
		[-$z, $y, $x],
		[-$z, $x,-$y],
	];
}

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
