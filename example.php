<?php
require_once 'phpsandbox.php';

$sandbox = new PHPSandbox();

session_start();

echo(session_id());
$_SESSION['TestValue'] = 'Yay :-)';
var_dump($_SESSION);

?>
<html>
	<head>
		<title>PHPSandbox Examples</title>
	</head>
	<body>
		<div>
			<div>Example 1 - Valid Code</div>
			<div style="border:1px; padding:5px;"><?php echo($sandbox->runFile('./samples/valid.php')); ?></div>
		</div>
		
		<div>
			<div>Example 2 - Invalid PHP</div>
			<div style="border:1px; padding:5px;"><?php echo($sandbox->runFile('./samples/invalid.php')); ?></div>
		</div>
		
		<div>
			<div>Example 3 - Malicious PHP</div>
			<div style="border:1px; padding:5px;"><?php echo($sandbox->runFile('./samples/malicious.php')); ?></div>
		</div>
	
		<div>
			<div>Example 4 - Slow PHP</div>
			<div style="border:1px; padding:5px;"><?php echo($sandbox->runFile('./samples/slow.php')); ?></div>
		</div>
	</body>
</html>