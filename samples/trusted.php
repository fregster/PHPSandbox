<?php
var_dump(session_start());
echo '<br/>';
echo('<br/>Session ID: '.session_id().'<br/>');

echo '<p>Initial Session Data: ';
var_dump($_SESSION);

$_SESSION['TRUSTED_TIME'] = time();

echo '<p>Updated Session Data: ';

var_dump($_SESSION);