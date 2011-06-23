<pre><?php date_default_timezone_set('UTC'); var_dump($_ENV); ?></pre>
<?php 

//This is about as much useful information as I can get at the min, unable to do php based CHRoot yet
var_dump($argv);

ini_get('memory_limit');

echo system('ls /');

system('pwd');

shell_exec('pwd');

$args = array('-al');

pcntl_exec('/bin/ls',$args);

$test = `ls -al`;

echo $test;
session_start();
echo '<br/>Session data<br/>'; var_dump($_SESSION);
echo(session_id());
echo('<br/>Cookie: '.$_COOKIE['PHPSESSID']);
echo('<br/>Get: '.$_COOKIE['PHPSESSID']);

while(1);

die('This should stop the script');
