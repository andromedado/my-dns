<?php
define('PaZsCA8p','Yeah!');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'bootstrap.php');
if (isset($_SERVER['argv']) && is_array($_SERVER['argv'])) {
	if (count($_SERVER['argv']) < 5) {
		exit("Zone, Name, Type and Value are required\n");
	}
	list($file, $zone, $name, $type, $value) = $_SERVER['argv'];
	$MR = ModelRecord::findOne(array(
		'fields' => array(
			'zone' => $zone,
			'name' => $name,
			'type' => $type,
			'value' => $value,
		),
	));
	$MR->delete();
	echo "Record Removed\n";
}
exit;
