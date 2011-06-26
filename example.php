<?php
require_once 'phpsandbox.php';

//Default sandbox
$sandbox = new PHPSandbox();

//Modified sandbox to allow testing of session data
$sandbox2 = new PHPSandbox(array('pass_session_data' => true));

//Modified sandbox to allow full access of session data
//FIXME: For some reason if the true session support is passed through to the cli the outer sctipt dies :-S
$sandbox3 = new PHPSandbox(array('pass_session_data' => true,
								//'pass_session_id' => true,
								'display_errors' => 'on',
));

$sandbox3->enableAllFunction(true);

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
		<h1>PHPSandbox</h1><h2>Run some PHP files with in an external PHP file in a 'safer' mannor</h2>
		
		<div>
			<div><h3>Output Session Data</h3><p>Show the start Session data</p></div>
			<div style="border:1px; padding:5px;"><?php echo 'Genuine Session ID: '.session_id().'<br/>'; var_dump($_SESSION); ?></div>
		</div>
		
		<div>
			<div><h3>Example 1 - Valid Code</h3><p>Just run some considered safe code</p></div>
			<div style="border:1px; padding:15px; margin:15px; background:cornsilk;"><?php echo($sandbox->runFile('./samples/valid.php')); ?></div>
		</div>
		
		<div>
			<div><h3>Example 2 - Invalid PHP</h3><p>Try to include a file that is badly formated</p></div>
			<div style="border:1px; padding:15px; margin:15px; background:cornsilk;"><?php echo($sandbox->runFile('./samples/invalid.php')); ?></div>
		</div>
		
		<div>
			<div><h3>Example 3 - Malicious PHP</h3><p>Try to run some code that would do something considered dodgy</p></div>
			<div style="border:1px; padding:15px; margin:15px; background:cornsilk;"><?php echo($sandbox->runFile('./samples/malicious.php')); ?></div>
		</div>
		
		<div>
			<div><h3>Example 4 - Recon PHP</h3><p>Run some PHP specifically for gathering information about the system (With a copy of the session information and a faked ID)</p></div>
			<div style="border:1px; padding:15px; margin:15px; background:cornsilk;"><?php echo($sandbox2->runFile('./samples/recon.php')); ?></div>
		</div>
		
		<div>
			<div><h3>Example 5 - Trusted PHP</h3><p>Run some trusted PHP with Session Access and Update rights (Direct Session access)</p></div>
			<div style="border:1px; padding:15px; margin:15px; background:cornsilk;"><?php echo($sandbox3->runFile('./samples/trusted.php')); ?></div>
		</div>
	
		<div>
			<div><h3>Example 6 - Slow PHP</h3><p>Include a PHP file that would run for longer than the allowed limit</p></div>
			<div style="border:1px; padding:5px; background:cornsilk;"><?php echo($sandbox->runFile('./samples/slow.php')); ?></div>
		</div>
		
		<div>
			<div><h3>Output Session Data</h3><p>Show the now Session data</p></div>
			<div style="border:1px; padding:5px;"><?php var_dump($_SESSION); ?></div>
		</div>
		
	</body>
</html>