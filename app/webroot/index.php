<?php
define('PaZsCA8p','Yeah!');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'bootstrap.php');
$Response = Controller::handleRequest(new AppRequest($_SERVER, $_GET, $_POST, $_COOKIE));
if(!headers_sent() && OUTPUT_BUFFER){ob_start("ob_gzhandler");}
$Response->render();
if(!headers_sent() && OUTPUT_BUFFER){ob_end_flush();}
exit;
