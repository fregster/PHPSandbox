<?php
echo 'Starting infinate loop<br/>';

$i = 0;
while (true) {
	if($i/100 == intval($i/100)){
		echo '.';
	}
	
	if($i > 24700){
		$i = 0;
		echo '<br/>';
	}
	$i++;
}