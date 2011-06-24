<?php
require_once 'phpsandbox.php';

$sandbox = new PHPSandbox();

//For example purposes
session_start();
$_SESSION['TestValue'] = 'Yay :-)';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>PHPSandbox Examples</title>
	</head>
	<body>
		<div>
			<div>Example 1 - Valid Code</div>
			<div style="border:1px; padding:15px; margin:15px; background:cornsilk;"><?php echo($sandbox->runFile('./samples/valid.php')); ?></div>
		</div>
		
		<div>
			<div>Example 2 - Invalid PHP</div>
			<div style="border:1px; padding:15px; margin:15px; background:cornsilk;"><?php echo($sandbox->runFile('./samples/invalid.php')); ?></div>
		</div>
		
		<div>
			<div>Example 3 - Malicious PHP</div>
			<div style="border:1px; padding:15px; margin:15px; background:cornsilk;"><?php echo($sandbox->runFile('./samples/malicious.php')); ?></div>
		</div>
		
		<div>
			<div>Example 4 - Recon PHP</div>
			<div style="border:1px; padding:15px; margin:15px; background:cornsilk;"><?php echo($sandbox->runFile('./samples/recon.php')); ?></div>
		</div>
	
		<div>
			<div>Example 5 - Slow PHP</div>
			<div style="border:1px; padding:5px;"><?php echo($sandbox->runFile('./samples/slow.php')); ?></div>
		</div>
	</body>
</html>