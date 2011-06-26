<pre><?php
echo 'ENV details: ';
var_dump($_ENV);

echo 'GET details: ';
var_dump($_GET);


echo 'POST details: ';
var_dump($_POST);


echo 'SESSION details (Copy of, the sessions faked ;-) : ';
echo('<br/>Session ID:'.session_id().'<br/>');
var_dump($_SESSION);


echo 'SERVER details: ';
var_dump($_SERVER);


echo 'PHPInfo() details: ';
phpinfo();
?></pre>