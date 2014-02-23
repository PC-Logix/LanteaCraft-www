<?php
require("config.php");
if (ini_get("register_globals") == 1 && !$metrics_conf["security"]["ignore_phpglobals"])
	die("Cannot run metrics; register_globals is enabled");

function __autoload($name) { include "core/" . $name . ".php"; }

function exceptionHandler($exception) {
	$traceline = "&nbsp;&nbsp;&nbsp;&nbsp;#%s %s(%s) (%s:%s)<br />\n";
	$msg = "<span style='font-weight:bold; color:red;'>Uncaught exception '%s': '%s' (%s:%s)</span><br />\n" .
		"Stack trace:<br />\n%s   thrown in %s on line %s";
	
	$trace = $exception->getTrace();
	foreach ($trace as $key => $stackPoint)
		$trace[$key]['args'] = array_map('gettype', $trace[$key]['args']);
	$result = array();
	foreach ($trace as $key => $stackPoint)
		$filename = $stackPoint['file'];
		$matches = array(
			str_replace("\\", "/", $_SERVER['DOCUMENT_ROOT']), 
			str_replace("/", "\\", $_SERVER['DOCUMENT_ROOT']));
		foreach ($matches as $keym => $matchm)
			if (strrpos($filename, $matchm) !== false)
				$filename = substr($filename, strlen($matchm));
			
		$result[] = sprintf($traceline, $key, $stackPoint['function'],
			implode(', ', $stackPoint['args']), $filename, $stackPoint['line']);
	$result[] = '&nbsp;&nbsp;&nbsp;&nbsp;#' . ++$key . ' {main script}';

	$filename = $exception->getFile();
	$matches = array($_SERVER['DOCUMENT_ROOT'], str_replace("/", "\\", $_SERVER['DOCUMENT_ROOT']));
	foreach ($matches as $keym => $matchm)
		if (strrpos($filename, $matchm) !== false)
			$filename = substr($filename, strlen($matchm));
	$msg = sprintf("<div style='font-family:monospace;'>" . $msg . "</div>",
		get_class($exception), $exception->getMessage(), $filename,
		$exception->getLine(), implode("\n", $result), $filename, $exception->getLine());
	ob_end_clean();
	die($msg);
}

set_exception_handler('exceptionHandler');
ob_start();
$context = new Metrics($metrics_conf);
$context->run();
ob_flush();