<?php
/**
 * PHP Sandbox
 * 
 * A PHP sandboxing class to help increase security of unknown scripts
 * This is not the be all and end all of security!
 * 
 * @author Paul Fryer
 *
 */

class PHPSandbox {
	
	private $lint_code = true;
	private $options = 	array(	'chroot' => '/', 
								'display_errors' => 'off',
								'pass_post' => false, 
								'pass_get' => false, 
								'pass_session' => true,
								'auto_prepend_file' => false, 
								'max_execution_time' => 2, 
								'memory_limit' => '2M', 
								'disable_functions' => 'exec,passthru,shell_exec,system,proc_open,popen,curl_exec,curl_multi_exec,parse_ini_file,show_source,pcntl_fork,pcntl_exec,session_start');
	private $cli_options = '';
	
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
		
		
		$this->cli_options .= '-d chroot='.$this->options['chroot'].' -d display_errors='.$this->options['display_errors'].' -d disable_functions='.$this->options['disable_functions']. ' -d memory_limit='.$this->options['memory_limit'].' -d max_execution_time='.$this->options['max_execution_time'];
	}
	
	/**
	 * 
	 * Enable a function from the disallowed function list
	 * @param string $function
	 */
	public function enableFunction($function){
		$functions = explode(',', $this->options['disable_functions']);
		array_flip($functions);
		if(isset($function) && isset($functions[$function])){
			unset($functions[$function]);
		}
		array_flip($functions);
		$this->options['disable_functions'] = implode(',', $functions);
	}
	
	/**
	 * 
	 * Run the specified file in a PHP sandbox
	 * @param string $path
	 * @param array $pass_through_vars
	 * @param bool $lintCode
	 */
	public function runFile($path, $pass_through_vars = array(), $lintCode = true){
		if(file_exists($path)){
			if(($lintCode && $this->lintFile($path)) || !$lintCode){
				$chroot = dirname($path);
				return shell_exec("php $this->cli_options -d auto_prepend_file=".$this->options['auto_prepend_file']." -d chroot=$chroot -f $path ".$this->buildVars($pass_through_vars));	
			}
		}
		return false;
	}
	
	/**
	 * NOT YET IMPLEMENTED
	 * For running PHP code directly in a Sandboxed enviroment
	 * @param string $code
	 * @param array $pass_through_vars
	 * @param bool $lintCode
	 */
	public function runCode($code, $pass_through_vars = array(), $lintCode = false){
		if(($lintCode && $this->lintCode($code)) || !$lintCode || true){
			$chroot = $this->createTempCHRoot();
			
			
			$command = 'php -r "eval(\'?>hello<?php ;\');";';
			
			return shell_exec($command);
		}
		return false;
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
		
		if($this->options['pass_session'] && session_id() != ''){
			$string .= ' _SESSION=\''.serialize($_SESSION)."'";
		}
			
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
	
}
