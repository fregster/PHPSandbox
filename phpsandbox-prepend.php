<?php

/**
 * PHP Sandbox
 * 
 * A PHP sandboxing class to help increase security of unknown scripts
 * This is not the be all and end all of security!
 * 
 * Default auto prepend file to fake a web enviroment and workaround common problems
 * 
 * Requirements: PHP5
 * Copyright (c) 2011 Paul Fryer (www.fryer.org.uk)
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the The GNU Lesser General Public License as published by
 * the Free Software Foundation; version 3 or any latter version of the license.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * The GNU Lesser General Public License (LGPLv3) for more details.
 * 
 * 
 * @package PHPSandbox
 * @author Paul Fryer <paul@fryer.org.uk>
 * @license http://www.opensource.org/licenses/lgpl-3.0.html LGPL
 *
 */

//Common problem so just setting it to something is better than nothing
date_default_timezone_set('UTC');

//PHP CLI Performance can not take advantage of OpCachers, however APC supports dumping and loading of the cache files
//Requires apc.enable_cli = 1 in the configuration
if ( !defined('__DIR__') ) define('__DIR__', dirname(__FILE__));

//If this is setup as root not really useful here and if your running as root your probably up ** creak anyway
//@chroot(dirname(__FILE__));

//Fake standard web server var's if passed in
$session_workaround = false;
$i = 1;
unset($argv[0]);
while ($i < 100 && isset($argv[$i])){
	if(substr($argv[$i], 0, 5) == '_POST'){
		$_POST = unserialize(substr($argv[$i], 6));
		unset($argv[$i]);
	}else if(substr($argv[$i], 0, 4) == '_GET'){
		$_GET = unserialize(substr($argv[$i], 5));
		unset($argv[$i]);
	}else if(substr($argv[$i], 0, 15) == '_SESSWORKAROUND'){
		$session_workaround = true;
		unset($argv[$i]);
	}else if(substr($argv[$i], 0, 10) == '_PHPSESSID'){
		$_COOKIE['PHPSESSID'] = substr($argv[$i], 11);
		session_id($_COOKIE['PHPSESSID']);
		unset($argv[$i]);
	}else if(substr($argv[$i], 0, 8) == '_SESSION'){
		$_SESSION = unserialize(substr($argv[$i], 9));
		if($session_workaround){
			@file_put_contents(ini_get('session.save_path').DIRECTORY_SEPARATOR.'sess_'.session_id(), sessionRawEncode($_SESSION));
		}
		unset($argv[$i]);
	}else if(substr($argv[$i], 0, 4) == '_APC'){
		define('USE_APC', true);
		unset($argv[$i]);
	}else if (substr($argv[$i], 0, 4) == '_END'){
		unset($argv[$i]);
		break;
	}
	$i++;
}
unset($session_workaround);

define('APC_CACHE_FILENAME', md5(__DIR__.DIRECTORY_SEPARATOR.__FILE__).'.apc');
if(PHP_OS == 'WINNT'){
	define('APC_CACHE', sys_get_temp_dir().APC_CACHE_FILENAME);
} else {
	define('APC_CACHE', '/dev/shm/'.APC_CACHE_FILENAME);
}

if (defined('USE_APC') && function_exists('apc_bin_loadfile') && is_readable(APC_CACHE)) {
	apc_bin_loadfile(APC_CACHE, NULL, APC_BIN_VERIFY_CRC32 | APC_BIN_VERIFY_MD5);
}

//Hide the enviroment veriables to help provide obscurification
foreach($_ENV as $key => $value){
	putenv("$key=null");
	$_ENV[$key]=null;
	unset($_ENV[$key]);
}

foreach($_SERVER as $key => $value){
	$_SERVER[$key]=null;
	unset($_SERVER[$key]);
}


function sessionRawEncode($array, $safe = true){  
    // the session is passed as refernece, even if you dont want it to
    if($safe){
        $array = unserialize(serialize($array));
    }
   
    $raw = '';
    $line = 0;
    $keys = array_keys($array);
    foreach($keys as $key){
        $value = $array[$key];
        $line ++ ;
       
        $raw .= $key.'|';
       
        if(is_array($value) && isset($value['huge_recursion_blocker_we_hope'])) {
            $raw .= 'R:'. $value['huge_recursion_blocker_we_hope'].';';
        } else {
            $raw .= serialize($value) ;
        }
        $array[$key] = Array('huge_recursion_blocker_we_hope' => $line ) ;
    }
   
    return $raw;
}

function fakeEnviroment(){
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
	
	
array(76) {
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
	
}

function fakeEnviromentIIS(){
	
}

function fakeEnviromentApache(){
	
}