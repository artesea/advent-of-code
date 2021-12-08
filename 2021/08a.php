<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("08.txt")));

$lines = explode("\n",$input);
$count = 0;
foreach($lines as $line) {
	$pipe = explode(" | ", $line);
	$rightbits = explode(" ", trim($pipe[1]));
	foreach($rightbits as $bit) {
		$s = strlen(trim($bit));
		if($s == 2 || $s == 4 || $s == 3 || $s == 7) {
			$count++;
		}
	}
}
echo $count;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
