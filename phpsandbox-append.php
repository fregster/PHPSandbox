<?php
// Store the APC opcode cache.
if (if_defined('USE_APC') && USE_APC && function_exists('apc_bin_dumpfile') && (is_writable(APC_CACHE) || is_writable(dirname(APC_CACHE)))) {
	if(!apc_bin_dumpfile(NULL, NULL, APC_CACHE)){
		error_log('PHPSandbox is configured to use APC but creating the dumpfile failed in' . APC_CACHE);
	}
}
exit(0);