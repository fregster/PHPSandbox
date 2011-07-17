<?php
/**
 * PHP Sandbox
 * 
 * A PHP sandboxing class to help increase security of unknown scripts
 * This is not the be all and end all of security!
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

class PHPSandbox {
	
	private $lint_code = true;
	private $session_workaround = false;
	
	private $options = 	array(	'chroot' => '/', 
								'display_errors' => 'off',
								'pass_post' => false, 
								'pass_get' => false, 
								'pass_session_data' => false,
								'pass_session_id' => false,
								'auto_prepend_file' => false, 
								'force_session_workaround' => true,
								'max_execution_time' => 1, 
								'memory_limit' => '2M', 
								'disable_functions' => 'exec,passthru,shell_exec,system,proc_open,popen,curl_exec,curl_multi_exec,parse_ini_file,show_source,pcntl_fork,pcntl_exec,session_start,phpinfo,ini_set',
								'safe_mode' => true,
								'directory_protection' => true,
								'directory_protection_allow_tmp' => true
								);
	
	private $cli_options = '';
	
	private $session_id = false;
	
	private $pre_fix_php = 'date_default_timezone_set("UTC");$i = 1;unset($argv[0]);while ($i < 3 && isset($argv[$i])){if(substr($argv[$i], 0, 5) == "_POST"){$_POST = unserialize(substr($argv[$i], 6));unset($argv[$i]);}else if(substr($argv[$i], 0, 4) == "_GET"){$_GET = unserialize(substr($argv[$i], 5));unset($argv[$i]);break;}$i++;}foreach($_ENV as $key => $value){putenv("$key=null");$_ENV[$key]=null;unset($_ENV[$key]);};echo"PREFIXED!";';
	
	/**
	 * 
	 * PHP Sandbox default construct
	 * 
	 * Current options are: display_errors => on|off, disable_functions => (csv of functions), pass_post => true|flase, pass_get => true|flase, pass_session => true|flase, max_execution_time => seconds, memory_limit => 2M
	 * 
	 * @param array $options
	 */
	public function __construct($options = array()){
		$this->options['chroot'] = sys_get_temp_dir();
		$this->options['auto_prepend_file'] = dirname(__FILE__).DIRECTORY_SEPARATOR.'phpsandbox-prepend.php';
		$this->options = array_merge($this->options, $options);
		
		if(isset($this->options['pass_session_id']) && $this->options['pass_session_id'] && isset($this->options['pass_session_data']) && $this->options['pass_session_data']){
			$this->enableFunction('session_start', false);
		}
		
		$this->tempPath = sys_get_temp_dir();
		
		$this->sessionWorkaround();
		
		$this->buildCLIOptions();
	}
	
	private function sessionWorkaround(){
		$session_workaround = array('Darwin' => true);
		if(isset($session_workaround[PHP_OS]) && $session_workaround[PHP_OS] || $this->options['force_session_workaround']){
			$this->session_workaround = true;
		}
	}
	
	/**
	 * 
	 * Build the CLI options string
	 */
	private function buildCLIOptions(){
		$this->cli_options = '-d session.name=PHPSESSID -d chroot='.$this->options['chroot'].' -d display_errors='.$this->options['display_errors']. ' -d memory_limit='.$this->options['memory_limit'].' -d max_execution_time='.$this->options['max_execution_time'];
		if(isset($this->options['disable_functions']) && $this->options['disable_functions'] != ''){
			$this->cli_options .=' -d disable_functions='.$this->options['disable_functions'];
		}
		
		if(ini_get('session.save_path') && ini_get('session.save_path') != ''){
			$this->cli_options .= ' -d session.save_path='.ini_get('session.save_path');
		}else{
			$this->cli_options .= ' -d session.save_path='.$this->tempPath;
		}
	}
	
	/**
	 * 
	 * Enable a function from the disallowed function list
	 * @param string $function
	 * @param bool $force_rebuild
	 */
	public function enableFunction($function, $force_rebuild = true){
		$functions = explode(',', $this->options['disable_functions']);
		$functions = array_flip($functions);
		if(isset($function) && isset($functions[$function])){
			unset($functions[$function]);
		}
		$functions = array_flip($functions);
		$this->options['disable_functions'] = implode(',', $functions);
		if($force_rebuild){
			$this->buildCLIOptions();
		}
	}
	
	/**
	 * 
	 * Remove all function and method restrictions
	 * @param bool $YesIReallyWantTo
	 */
	public function enableAllFunction($YesIReallyWantTo = false){
		if($YesIReallyWantTo){
			$this->options['disable_functions'] = '';
			$this->buildCLIOptions();
		}
	}
	
	/**
	 * 
	 * Run the specified file in a PHP sandbox
	 * @param string $path
	 * @param array $pass_through_vars
	 * @param bool $lintCode
	 */
	public function runFile($path, $pass_through_vars = array(), $lintCode = true){
		$restart_session = false;
		$session_id = null;
		$response = false;
		if(file_exists($path)){
			if(($lintCode && $this->lintFile($path)) || !$lintCode){
				if(isset($this->options['pass_session_id']) && $this->options['pass_session_id']){
					$this->session_id = session_id();
					session_write_close();
					$restart_session = true;
				}
				$chroot = dirname($path);
				if(isset($this->options['auto_prepend_file']) && file_exists($this->options['auto_prepend_file'])){
					//For debuging
					//echo("php $this->cli_options -d auto_prepend_file=".$this->options['auto_prepend_file']." -d chroot=$chroot -f $path ".$this->buildVars($pass_through_vars));
					$response = shell_exec("php $this->cli_options -d auto_prepend_file=".$this->options['auto_prepend_file'].$this->enhancedProtection($chroot)." -d chroot=$chroot -f $path ".$this->buildVars($pass_through_vars));	
				}else{
					$response = shell_exec("php $this->cli_options -d chroot=$chroot ".$this->enhancedProtection($chroot). " -f $path ".$this->buildVars($pass_through_vars));
				}	
			}
		}
		
		if($restart_session){
			//Ignore the warning about headers, we know already!
			session_id($this->session_id);
			@session_start();
			if($this->session_workaround){
				session_decode(file_get_contents($this->tempPath.'sess_'.$this->session_id));
				/*
				if($this->tempPath.'sess_'.$this->session_id != ini_get('session.save_path')){
					unlink($this->tempPath.'sess_'.$this->session_id);
				}
				*/
			}
		}
		
		return $response;
	}
	
	/**
	 * NOT YET IMPLEMENTED
	 * For running PHP code directly in a Sandboxed enviroment
	 * @param string $code
	 * @param array $pass_through_vars
	 * @param bool $lintCode
	 */
	public function runCode($code, $pass_through_vars = array(), $lintCode = false){
		$path = tempnam($this->tempPath, 'tmp');
		file_put_contents($path, $code);
		
		$response = $this->runFile($path, $pass_through_vars, $lintCode);
		unlink($path);
		return $response;
	}
	
	/**
	 * 
	 * Build up the standard arguments to pass to the CLI
	 * Allows for custom arguments to be added to the end
	 * @param array $pass_through_vars
	 */
	private function buildVars($pass_through_vars = array()){
		$string = '';
		
		if($this->options['pass_post']){
			$string .= ' _POST=\''.serialize($_POST)."'";
		}
		
		if($this->options['pass_get']){
			$string .= ' _GET=\''.serialize($_GET)."'";
		}
		
		if($this->session_workaround){
			$string .= ' _SESSWORKAROUND=\'true\'';
		}
		
		if($this->options['pass_session_data'] && $this->session_id && $this->session_id != ''){
			if(isset($this->options['pass_session_id']) && $this->options['pass_session_id'] ){
				$string .= ' _PHPSESSID=\''.$this->session_id."'";
			}else {
				$string .= ' _PHPSESSID=\''.sha1(rand(0,getrandmax()).serialize($_SERVER).time())."'";
			}
		}
		
		if($this->options['pass_session_data']){
			$string .= ' _SESSION=\''.serialize($_SESSION)."'";
		}
		
		$string .= ' _END';
			
		if(isset($pass_through_vars) and count($pass_through_vars) > 0){
			foreach ($pass_through_vars as $value){
				$string .= ' '.$value;
			}
		}
		
		return $string;
	}
	
	private function lintCode($code){
		return true;
		return shell_exec("php -l -r $code");
	}
	
	/**
	 * 
	 * lintFile Calls the PHP binary with the lint only function to validate the file format
	 * @param string $path
	 */
	private function lintFile($path){
		$output;
		$return_var;
		exec("php -l -f $path", $output, $return_var);
		
		if($return_var == 0){
			return true;
		}
		return false;
	}
	
	/**
	 * NOT YET IMPLEMENTED
	 * Create a unique directory for CHRoot'ing to
	 */
	private function createTempCHRoot(){
		return sys_get_temp_dir();
	}
	
	/**
	 * enhancedProtection
	 * Sets the additional options to help prevent directory traversal and PHP safe mode
	 * @param string the directory of the sctips
	 */
	private function enhancedProtection($scriptDir){
		$dir_seperator = ':';
		if(PHP_OS == 'win'){
			$dir_seperator = ';';
		}
		
		$str = '';
		if(substr($scriptDir, -1) != DIRECTORY_SEPARATOR){
			$scriptDir .= DIRECTORY_SEPARATOR;
		}
		
		if($this->options['safe_mode']){
			$str .= ' -d safe_mode=1 -d safe_mode_exec_dir="'.$scriptDir.'" ';
		}
		
		if($this->options['directory_protection']){
			$str .= ' -d open_basedir="'.$scriptDir.$dir_seperator.dirname($this->options['auto_prepend_file']).DIRECTORY_SEPARATOR;
			
			if($this->options['directory_protection_allow_tmp']){
				$str .= $dir_seperator . $this->tempPath;
			}
			$str .= '" ';
		}
		
		return $str;
	}
}
