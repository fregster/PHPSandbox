<?php  

session_start();

echo '<pre><br/>ENV details: '; var_dump($_ENV); 

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

echo '<br/>Try to set the memory limit to 2G: ';
ini_set('memory_limit', '2G');
echo '<br/>Get the memory limit details: ';
echo(ini_get('memory_limit'));

echo '<br/>Run a system command "ls /"';
echo system('ls /');

echo '<br/>Try a series of system commands to get the working directory';
system('pwd');
shell_exec('pwd');
$args = array('-al');
pcntl_exec('/bin/ls',$args);
$test = `ls -al`;
echo $test;
echo '</pre>';

echo '<br/>Try a fork bomb or try to run the script indefinetly:';
while(pcntl_fork()|1);

die('<br/>This should stop the script');
