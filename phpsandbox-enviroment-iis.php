<?php
$fakeServerEnv = array(
	'OS' => 'Windows_NT',
	'COMPUTERNAME' => 'localhost',
	'REMOTE_ADDR' => '127.0.0.1',
	'REMOTE_HOST' => '127.0.0.1',
	'REQUEST_METHOD' => 'GET',
	'SERVER_NAME' => 'localhost',
	'SERVER_PORT' => '80',
	'SERVER_PORT_SECURE' => '0',
	'SERVER_PROTOCOL' => 'HTTP/1.1',
	'SERVER_SOFTWARE' => 'Microsoft-IIS/6.0',
	'REMOTE_USER' => '',
	'REMOTE_PORT' => '1041',
	'NUMBER_OF_PROCESSORS' => '1',
	'GATEWAY_INTERFACE' => 'CGI/1.1',
	'HTTPS' => 'off',
	'HTTPS_KEYSIZE' => '',
	'HTTPS_SECRETKEYSIZE' => '',
	'HTTPS_SERVER_ISSUER' => '',
	'HTTPS_SERVER_SUBJECT' => '',
	'HTTP_CONNECTION' => 'keep-alive',
	'HTTP_ACCEPT' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*\/*;q=0.8',
	'HTTP_ACCEPT_ENCODING' => 'gzip, deflate',
	'HTTP_ACCEPT_LANGUAGE' => 'en-gb,en;q=0.5',
	'HTTP_HOST' => 'localhost',
	'HTTP_USER_AGENT' => 'Mozilla/5.0 (Windows NT 5.2; rv:6.0) Gecko/20100101 Firefox/6.0',
);


/*
  ["_FCGI_X_PIPE_"]=>
  string(53) "\\.\pipe\IISFCGI-30e73c76-2f53-45c2-8bb5-321448f98e79"
  ["PHP_FCGI_MAX_REQUESTS"]=>
  string(5) "10000"
  ["PHPRC"]=>
  string(21) "C:\Program Files\PHP\"
  ["ALLUSERSPROFILE"]=>
  string(35) "C:\Documents and Settings\All Users"
  ["APP_POOL_ID"]=>
  string(14) "DefaultAppPool"
  ["ClusterLog"]=>
  string(30) "C:\WINDOWS\Cluster\cluster.log"
  ["CommonProgramFiles"]=>
  string(29) "C:\Program Files\Common Files"
  ["COMPUTERNAME"]=>
  string(9) "WIN2K3SQL"
  ["ComSpec"]=>
  string(27) "C:\WINDOWS\system32\cmd.exe"
  ["FP_NO_HOST_CHECK"]=>
  string(2) "NO"
  ["lib"]=>
  string(32) "C:\Program Files\SQLXML 4.0\bin\"
  ["NUMBER_OF_PROCESSORS"]=>
  string(1) "1"
  ["OS"]=>
  string(10) "Windows_NT"
  ["Path"]=>
  string(381) "C:\Program Files\PHP\;C:\WINDOWS\system32;C:\WINDOWS;C:\WINDOWS\System32\Wbem;C:\Program Files\Microsoft SQL Server\80\Tools\Binn\;C:\Program Files\Microsoft SQL Server\90\Tools\binn\;C:\Program Files\Microsoft SQL Server\90\DTS\Binn\;C:\Program Files\Microsoft SQL Server\90\Tools\Binn\VSShell\Common7\IDE\;C:\Program Files\Microsoft Visual Studio 8\Common7\IDE\PrivateAssemblies\"
  ["PATHEXT"]=>
  string(48) ".COM;.EXE;.BAT;.CMD;.VBS;.VBE;.JS;.JSE;.WSF;.WSH"
  ["PROCESSOR_ARCHITECTURE"]=>
  string(3) "x86"
  ["PROCESSOR_IDENTIFIER"]=>
  string(47) "x86 Family 6 Model 23 Stepping 10, GenuineIntel"
  ["PROCESSOR_LEVEL"]=>
  string(1) "6"
  ["PROCESSOR_REVISION"]=>
  string(4) "170a"
  ["ProgramFiles"]=>
  string(16) "C:\Program Files"
  ["SystemDrive"]=>
  string(2) "C:"
  ["SystemRoot"]=>
  string(10) "C:\WINDOWS"
  ["TEMP"]=>
  string(15) "C:\WINDOWS\TEMP"
  ["TMP"]=>
  string(15) "C:\WINDOWS\TEMP"
  ["USERPROFILE"]=>
  string(38) "C:\Documents and Settings\Default User"
  ["windir"]=>
  string(10) "C:\WINDOWS"
  ["FCGI_ROLE"]=>
  string(9) "RESPONDER"
  ["APPL_MD_PATH"]=>
  string(23) "/LM/W3SVC/33230916/Root"
  ["APPL_PHYSICAL_PATH"]=>
  string(20) "\\VBOXSVR\workspace\"
  ["AUTH_TYPE"]=>
  string(0) ""
  ["AUTH_PASSWORD"]=>
  string(0) ""
  ["AUTH_USER"]=>
  string(0) ""
  ["CERT_COOKIE"]=>
  string(0) ""
  ["CERT_FLAGS"]=>
  string(0) ""
  ["CERT_ISSUER"]=>
  string(0) ""
  ["CERT_SERIALNUMBER"]=>
  string(0) ""
  ["CERT_SUBJECT"]=>
  string(0) ""
  ["CONTENT_LENGTH"]=>
  string(1) "0"
  ["CONTENT_TYPE"]=>
  string(0) ""
  ["GATEWAY_INTERFACE"]=>
  string(7) "CGI/1.1"
  ["HTTPS"]=>
  string(3) "off"
  ["HTTPS_KEYSIZE"]=>
  string(0) ""
  ["HTTPS_SECRETKEYSIZE"]=>
  string(0) ""
  ["HTTPS_SERVER_ISSUER"]=>
  string(0) ""
  ["HTTPS_SERVER_SUBJECT"]=>
  string(0) ""
  ["INSTANCE_ID"]=>
  string(8) "33230916"
  ["INSTANCE_META_PATH"]=>
  string(18) "/LM/W3SVC/33230916"
  ["LOCAL_ADDR"]=>
  string(9) "127.0.0.1"
  ["LOGON_USER"]=>
  string(0) ""
  ["PATH_TRANSLATED"]=>
  string(35) "\\VBOXSVR\workspace\Testing\env.php"
  ["QUERY_STRING"]=>
  string(0) ""
  ["REMOTE_ADDR"]=>
  string(9) "127.0.0.1"
  ["REMOTE_HOST"]=>
  string(9) "127.0.0.1"
  ["REQUEST_METHOD"]=>
  string(3) "GET"
  ["SCRIPT_NAME"]=>
  string(16) "/Testing/env.php"
  ["SERVER_NAME"]=>
  string(9) "localhost"
  ["SERVER_PORT"]=>
  string(2) "80"
  ["SERVER_PORT_SECURE"]=>
  string(1) "0"
  ["SERVER_PROTOCOL"]=>
  string(8) "HTTP/1.1"
  ["SERVER_SOFTWARE"]=>
  string(17) "Microsoft-IIS/6.0"
  ["REMOTE_USER"]=>
  string(0) ""
  ["REMOTE_PORT"]=>
  string(4) "1041"
  ["URL"]=>
  string(16) "/Testing/env.php"
  ["REQUEST_URI"]=>
  string(16) "/Testing/env.php"
  ["DOCUMENT_ROOT"]=>
  string(19) "\\VBOXSVR\workspace"
  ["SCRIPT_FILENAME"]=>
  string(35) "\\VBOXSVR\workspace\Testing\env.php"
  ["HTTP_CONNECTION"]=>
  string(10) "keep-alive"
  ["HTTP_ACCEPT"]=>
  string(63) "text/html,application/xhtml+xml,application/xml;q=0.9,*\/*;q=0.8"
  ["HTTP_ACCEPT_ENCODING"]=>
  string(13) "gzip, deflate"
  ["HTTP_ACCEPT_LANGUAGE"]=>
  string(14) "en-gb,en;q=0.5"
  ["HTTP_HOST"]=>
  string(9) "localhost"
  ["HTTP_REFERER"]=>
  string(25) "http://localhost/Testing/"
  ["HTTP_USER_AGENT"]=>
  string(63) "Mozilla/5.0 (Windows NT 5.2; rv:6.0) Gecko/20100101 Firefox/6.0"
  ["ORIG_PATH_INFO"]=>
  string(16) "/Testing/env.php"
  ["PHP_SELF"]=>
  string(16) "/Testing/env.php"
  ["REQUEST_TIME"]=>
  int(1311095240)
}
*/