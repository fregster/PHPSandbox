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

 //This script is currently quite procedual in style for several reasons. Once completly functionally complete we will seperate in to classes and objects where possible
 
//Common problem so just setting it to something is better than nothing
date_default_timezone_set('UTC');

//PHP CLI Performance can not take advantage of OpCachers, however APC supports dumping and loading of the cache files
//Requires apc.enable_cli = 1 in the configuration
if ( !defined('__DIR__') ) define('__DIR__', dirname(__FILE__));

$FILE = $_SERVER['SCRIPT_FILENAME'];

//If this is setup as root not really useful here and if your running as root your probably up **** creak anyway
//@chroot(dirname(__FILE__));

//Fake standard web server var's if passed in
$session_workaround = false;
$i = 1;
unset($argv[0]);

ini_set('error_log', sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'PHPSandbox_errors.log');

//FIXME: This is very dirty needs re-writing
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
		//Currently only works for file sessions
		if($session_workaround){
			@file_put_contents(ini_get('session.save_path') . DIRECTORY_SEPARATOR . 'sess_'.session_id(), sessionRawEncode($_SESSION));
		}
		unset($argv[$i]);
	}else if(substr($argv[$i], 0, 4) == '_APC' && extension_loaded('apc')){
		define('USE_APC', true);
		unset($argv[$i]);
	}else if (substr($argv[$i], 0, 4) == '_END'){
		unset($argv[$i]);
		break;
	}
	$i++;
}
unset($session_workaround);

//Define where the APC memory cache should be
define('APC_CACHE_FILENAME', md5(__DIR__ . DIRECTORY_SEPARATOR . __FILE__ . $FILE).'.apc');
if(PHP_OS == 'WINNT'){
	define('APC_CACHE', realpath(sys_get_temp_dir()) . DIRECTORY_SEPARATOR . APC_CACHE_FILENAME);
} else {
	define('APC_CACHE', realpath('/dev/shm/') . DIRECTORY_SEPARATOR . APC_CACHE_FILENAME);
}

//If we can and are allowed to use APC then use it
if (defined('USE_APC') && USE_APC && function_exists('apc_bin_loadfile') && file_exists(APC_CACHE)){
	if(is_readable(APC_CACHE)) {
		apc_bin_loadfile(APC_CACHE, NULL, APC_BIN_VERIFY_CRC32 | APC_BIN_VERIFY_MD5);
		//error_log('Loading APC Cache ' . APC_CACHE);
	} else {
		error_log('APC Cache file not readable ' . APC_CACHE);
	}
}

fakeEnviroment();

/**
 * function sessionRawEncode
 * Rebuilds any session data that we wish o provide to the end user
 */
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
        ++$line;
       
        $raw .= $key.'|';
       
        if(is_array($value) && isset($value['recursion_protection'])) {
            $raw .= 'R:'. $value['recursion_protection'].';';
        } else {
            $raw .= serialize($value) ;
        }
        $array[$key] = Array('recursion_protection' => $line ) ;
    }
   
    return $raw;
}

/**
 * function fakeEnviroment
 * Builds enviromental var's that are approprate for the platform but generic to protect the end user
 */
function fakeEnviroment(){
	//Hide the enviroment veriables to help provide obscurification
	foreach($_ENV as $key => $value){
		putenv("$key=null");
		$_ENV[$key]=null;
		unset($_ENV[$key]);
	}

	//Hide the server veriables to help provide obscurification
	foreach($_SERVER as $key => $value){
		$_SERVER[$key]=null;
		unset($_SERVER[$key]);
	}
	
	if(PHP_OS == 'WINNT'){
		require_once 'phpsandbox-enviroment-iis.php';
	} else {
		require_once 'phpsandbox-enviroment-apache.php';
	}
	
	foreach($fakeServerEnv as $env_key => $value){
		$_ENV[$env_key] = $value;
	}
}