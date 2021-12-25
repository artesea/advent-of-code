<?php 
$mcstart = microtime(true); 
echo "<pre>\n"; 
$input = trim(str_replace("\r","",file_get_contents("25.txt"))); 
 
$debug = 0; 
$lines = explode("\n",$input); 
 
$mc=strlen($lines[0]); 
$mr=sizeof($lines); 
 
$pre = []; 
 
for($r=0;$r<$mr;$r++) { 
	$pre[$r] = str_split($lines[$r]); 
} 
$post=$pre; 
 
if($debug) { 
	echo "Initial\n"; 
	foreach($post as $row) echo implode('',$row) . "\n"; 
} 
 
$l=0; 
while(1) { 
	$l++; 
	if($debug) echo "\nMoved {$l}\n"; 
	$moved = false; 
	for($r=0;$r<$mr;$r++) { 
		for($c=0;$c<$mc;$c++) { 
			if($pre[$r][$c] == '>' && $pre[$r][($c+1)%$mc] == '.') { 
				$post[$r][$c] = '.'; 
				$post[$r][($c+1)%$mc] = '>'; 
				$moved = true; 
			} 
		} 
	} 
	$pre = $post; 
	for($r=0;$r<$mr;$r++) { 
		for($c=0;$c<$mc;$c++) { 
			if($pre[$r][$c] == 'v' && $pre[($r+1)%$mr][$c] == '.') { 
				$post[$r][$c] = '.'; 
				$post[($r+1)%$mr][$c] = 'v'; 
				$moved = true; 
			} 
		} 
	} 
	if($debug) {  
		//print_r($post); 
		foreach($post as $row) echo implode('',$row) . "\n"; 
	} 
//compare, break if same 
	$pre = $post; 
	if(!$moved) break; 
} 
 
echo "\nANSWER: {$l}"; 
 
$mcdiff = microtime(true) - $mcstart; 
echo "\n\nTime: {$mcdiff}"; 
