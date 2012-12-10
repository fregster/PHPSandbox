<?php
$fakeServerEnv = array(
	'UNIQUE_ID' => sha1(rand(5, getrandmax()).time()),
	'HTTP_HOST' => 'localhost',
	'HTTP_ACCEPT' => string 'text/html,application/xhtml+xml,application/xml;q=0.9,*\/*;q=0.8',
	'HTTP_ACCEPT_LANGUAGE' => 'en-us,en;q=0.5',
	'HTTP_ACCEPT_ENCODING' => 'gzip, deflate',
	'HTTP_ACCEPT_CHARSET' => 'ISO-8859-1,utf-8;q=0.7,*;q=0.7',
	'HTTP_CONNECTION' => 'keep-alive',
	'REMOTE_PORT' => '49653',
	'GATEWAY_INTERFACE' => 'CGI/1.1',
	'SERVER_PROTOCOL' => 'HTTP/1.1',
	'REQUEST_METHOD' => 'GET',
	'SERVER_ADMIN' => 'user@example.com',
	'SERVER_SIGNATURE' => '',
	'SERVER_SOFTWARE' => 'Apache',
	'SERVER_NAME' => 'localhost',
	'SERVER_ADDR' => '127.0.0.1',
	'SERVER_PORT' => '80',
	'REMOTE_ADDR' => '127.0.0.1',
	'REQUEST_TIME' => time(),
);

/*
  'UNIQUE_ID' => string 'TiW4xwozAK0AAB2hKeoAAAAE' (length=24)
  'HTTP_HOST' => string 'localhost' (length=9)
  'HTTP_USER_AGENT' => string 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:5.0.1) Gecko/20100101 Firefox/5.0.1' (length=83)
  'HTTP_ACCEPT' => string 'text/html,application/xhtml+xml,application/xml;q=0.9,*\/*;q=0.8' (length=63)
  'HTTP_ACCEPT_LANGUAGE' => string 'en-us,en;q=0.5' (length=14)
  'HTTP_ACCEPT_ENCODING' => string 'gzip, deflate' (length=13)
  'HTTP_ACCEPT_CHARSET' => string 'ISO-8859-1,utf-8;q=0.7,*;q=0.7' (length=30)
  'HTTP_CONNECTION' => string 'keep-alive' (length=10)
  'HTTP_REFERER' => string 'http://localhost/Testing/' (length=25)
  'HTTP_COOKIE' => string 'PHPSESSID=5epc0am69c4olckfrav2843gk4' (length=36)
  'PATH' => string '/usr/bin:/bin:/usr/sbin:/sbin' (length=29)
  'SERVER_SIGNATURE' => string '' (length=0)
  'SERVER_SOFTWARE' => string 'Apache/2.2.17 (Unix) mod_ssl/2.2.17 OpenSSL/1.0.0d DAV/2 PHP/5.3.5' (length=66)
  'SERVER_NAME' => string 'localhost' (length=9)
  'SERVER_ADDR' => string '127.0.0.1' (length=9)
  'SERVER_PORT' => string '80' (length=2)
  'REMOTE_ADDR' => string '127.0.0.1' (length=9)
  'DOCUMENT_ROOT' => string '/www/workspace' (length=14)
  'SERVER_ADMIN' => string 'root@localhost' (length=14)
  'SCRIPT_FILENAME' => string '/www/workspace/Testing/env.php' (length=30)
  'REMOTE_PORT' => string '49653' (length=5)
  'GATEWAY_INTERFACE' => string 'CGI/1.1' (length=7)
  'SERVER_PROTOCOL' => string 'HTTP/1.1' (length=8)
  'REQUEST_METHOD' => string 'GET' (length=3)
  'QUERY_STRING' => string '' (length=0)
  'REQUEST_URI' => string '/Testing/env.php' (length=16)
  'SCRIPT_NAME' => string '/Testing/env.php' (length=16)
  'PHP_SELF' => string '/Testing/env.php' (length=16)
  'REQUEST_TIME' => int 1311094983
 */