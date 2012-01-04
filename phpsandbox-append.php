<?php
// Store the APC opcode cache.
if (function_exists('apc_bin_dumpfile') && (is_writable(APC_CACHE) || is_writable(dirname(APC_CACHE)))) {
  apc_bin_dumpfile(NULL, NULL, APC_CACHE);
}