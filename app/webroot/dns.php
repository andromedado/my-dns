<?php
define('PaZsCA8p','Yeah!');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'bootstrap.php');
ControllerZone::doCacheOut();
echo "DNS Ran Successfuly\n";
exit;
