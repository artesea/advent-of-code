<?php
$mcstart = microtime(true);
echo "<pre>\n";
$input = trim(str_replace("\r","",file_get_contents("16.txt")));

//wrong
//29

//convert to bin
$binary = "";
for($i=0;$i<strlen($input);$i++) {
	$binary .= str_pad(base_convert($input[$i],16,2),4,0,STR_PAD_LEFT);
}
echo $input . "\n";

$count = 0;

function packet($binary, $find) {
	global $count;
	if(strlen($binary) < 6) {
		echo "Something gone wrong here!\n";
		return "";
	}
	echo "\n\nNew binary (" . $find . ")\n" . $binary . "\n";
	$version = substr($binary, 0 ,3);
	echo "Version: " . $version . " " . base_convert($version,2,10) . "\n";
	$count += base_convert($version,2,10);
	$binary = substr($binary, 3);
	echo $binary . "\n";
	$type = substr($binary, 0, 3);
	echo "Type: " . $type . " " . base_convert($type,2,10) . "\n";
	$binary = substr($binary, 3);
	echo $binary . "\n";
	//literal
	if($type==="100") {
		$last_bit = 1;
		$literal = "";
		while($last_bit == 1) {
			$last_bit = substr($binary, 0, 1);
			$binary = substr($binary, 1);
			$literal .= substr($binary, 0, 4);
			$binary = substr($binary, 4);
		}
		echo "Literal: " . $literal . " " . base_convert($literal,2,10) . "\n";
	}
	else {
		$length_id = substr($binary,0,1);
		$binary = substr($binary,1);
		echo "Length Id: " . $length_id . "\n";
		if($length_id==="0") {
			//unknown packets within length of x
			$length = substr($binary,0,15);
			$len_dec = base_convert($length,2,10);
			$binary = substr($binary,15);
			echo "Length: ". $length . " " . $len_dec . "\n";
			$new_packet = substr($binary,0,$len_dec);
			$binary = substr($binary,$len_dec);
			$count += packet($new_packet, -1);
		}
		else {
			//x packets of unknown length
			$length = substr($binary,0,11);
			$len_dec = base_convert($length,2,10);
			$binary = substr($binary,11);
			echo "Count: ". $length . " " . $len_dec . "\n";
			$binary = packet($binary, $len_dec);
		}
	}
	echo "Checking what is left (" . $find . ")\n" . $binary . "\n";
	if(strpos($binary,"1")!==false && $find != 0) {
		echo "Find more!\n";
		$binary = packet($binary, $find-1);
	}
	else {
		echo "No more to find\n";
	}
	return $binary;
}

$temp = packet($binary, 1);

echo "\n\nPart 1: " . $count;

$mcdiff = microtime(true) - $mcstart;
echo "\n\nTime: {$mcdiff}";
