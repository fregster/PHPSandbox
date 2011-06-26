<pre><?php date_default_timezone_set('UTC'); echo '<br/>ENV details: '; var_dump($_ENV); ?></pre>
<?php 

session_start();
echo '<br/>Session data<br/>'; var_dump($_SESSION);
echo(session_id());
echo '<br/>Update a session value:<br/>';
$_SESSION['NAUGHTY_TIME'] = time();
var_dump($_SESSION);
echo('<br/>Cookie: '.$_COOKIE['PHPSESSID']);
echo('<br/>Get: '.$_COOKIE['PHPSESSID']);


//This is about as much useful information as I can get at the min, unable to do php based CHRoot yet
echo '$argv details: ';
var_dump($argv);

echo '<br/>Get the memory limit details: ';
ini_get('memory_limit');

echo '<br/>Run a system command "ls /"';
echo system('ls /');

echo '<br/>Try a series of system commands to get the working directory';
system('pwd');
shell_exec('pwd');
$args = array('-al');
pcntl_exec('/bin/ls',$args);
$test = `ls -al`;
echo $test;

echo '<br/>Try to run the secipt indefinetly';
while(1);

die('<br/>This should stop the script');
