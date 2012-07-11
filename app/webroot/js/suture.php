<?php
/* Suture Type */
define('EXTENSION', 'js');
define('CONTENT_TYPE', 'text/javascript');
define('FILE_HEADER', '//JavaScript Document');

/* Suture Settings */
define('LOAD_CLASSES', false);
define('PERMIT_CACHE', false);
define('PERMIT_304', false);
define('HARD_STOP', false);
define('MAJOR_VERSION', 1);
$defaults = array('jquery', 'app');

/* Suture Business */

$ks = array_merge($defaults, array_keys($_GET));
$hash = md5(implode('', $ks) . date('MY') . MAJOR_VERSION);
$et = '"' . substr($hash, -10) . '"';
if (PERMIT_304 && isset($_SERVER['HTTP_IF_NONE_MATCH']) && $_SERVER['HTTP_IF_NONE_MATCH'] == $et) {
	header('Not Modified', true, 304);
	if (HARD_STOP) exit;
}
ob_start();//'ob_gzhandler');
header('Cache-Control: Public');
header('ETag: ' . $et);
header('Content-Type: ' . CONTENT_TYPE);
echo FILE_HEADER;
if (!empty($ks)) {
	if (!defined('PaZsCA8p')) define('PaZsCA8p', 'OhYeah');
	if (LOAD_CLASSES) {
		require_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'baseConfigs.php');
		require_once(INC_ROOT . 'classes.php');
	}
	$cacheDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;
	$cacheFile = $cacheDir . $hash;
	if (PERMIT_CACHE && file_exists($cacheFile)) {
		ob_clean();
		header('Last-Modified: ' . date('D, d M Y h:i:s T', filemtime($cacheFile)));
		include($cacheFile);
		ob_end_flush();
		exit;
	}
	foreach ($ks as $f) {
		$file = preg_replace('/[^\dA-Z_-]/i', '', $f);
		$F = dirname(__FILE__) . DIRECTORY_SEPARATOR . $file . '.' . EXTENSION;
		echo "\n/* Begin {$file}." . EXTENSION . " */\n";
		if (file_exists($F)) include($F);
		echo "\n/* End {$file}." . EXTENSION . " */\n";
	}
	if (PERMIT_CACHE && (is_dir($cacheDir) || mkdir($cacheDir)) && $h = fopen($cacheFile, 'w')) {
		$s = '/* Cached File: ' . date('Y-m-d g:ia T', time()) . " */\n" . ob_get_contents();
		fwrite($h, $s);
		fclose($h);
	}
} else {
	echo "\n/* Empty _GET */\n";
}
ob_end_flush();
?>