<?php
/**
 * PHP Sandbox
 * 
 * Default auto prepend file to fake a web enviroment and workaround common problems
 * 
 * @author Paul Fryer
 */

//Common problem so just setting it to something is better than nothing
date_default_timezone_set('UTC');

//If this is setup as root not really useful here and if your running as root your probably up ** creak anyway
//@chroot(dirname(__FILE__));

//Fake standard web server var's if passed in
$i = 1;
unset($argv[0]);
while ($i < 3 && isset($argv[$i])){
	if(substr($argv[$i], 0, 5) == '_POST'){
		$_POST = unserialize(substr($argv[$i], 6));
		unset($argv[$i]);
	}else if(substr($argv[$i], 0, 4) == '_GET'){
		$_GET = unserialize(substr($argv[$i], 5));
		unset($argv[$i]);
	}else if(substr($argv[$i], 0, 8) == '_SESSION'){
		$_SESSION = unserialize(substr($argv[$i], 9));
		unset($argv[$i]);
		break;
	}
	$i++;
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

