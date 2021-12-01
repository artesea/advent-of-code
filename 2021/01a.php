<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("01.txt")));
$lines = explode("\n",$input);

$count = 0;
for($i=1;$i<sizeof($lines);$i++) {
	if($lines[$i] > $lines[$i-1]) $count++;
}
echo $count;


$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
