<?php

function app_autoloader ($classname) {
	$cLoc = $classname = preg_replace('/[^A-Z\d_-]+/i', '', $classname);
	$prefixes = array(
		'App',
		'Model',
		'Filter',
		'Controller',
	);
	foreach ($prefixes as $prefix) {
		if (preg_match('#^' . $prefix . '#', $classname)) {
			$cLoc = preg_replace('#^' . $prefix . '#', $prefix . DS, $classname);
			if ($cLoc === $prefix . DS) $cLoc .= $classname;
			break;//May only be performed once!
		}
	}
	if (!file_exists(APP_CLASS_DIR . $cLoc . '.php')) {
		return false;
	}
	require_once(APP_CLASS_DIR . $cLoc . '.php');
	return true;
}
spl_autoload_register('app_autoloader');
