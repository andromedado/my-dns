<?php
define('PaZsCA8p','Yeah!');
require_once(__DIR__ . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'bootstrap.php');
$wPDO = DBCFactory::wPDO();
$stmt = $wPDO->prepare(<<<EOT
CREATE TABLE IF NOT EXISTS records (
  rid INTEGER PRIMARY KEY AUTOINCREMENT,
  zone varchar(120) NOT NULL DEFAULT '',
  name varchar(120) NOT NULL DEFAULT '',
  ttl int(11) DEFAULT NULL,
  type varchar(6) NOT NULL DEFAULT '',
  adi varchar(30) NOT NULL DEFAULT '',
  value varchar(120) NOT NULL DEFAULT ''
)
EOT
);
var_dump($stmt, $wPDO->errorCode(), $wPDO->errorInfo());
$stmt->execute(array());
