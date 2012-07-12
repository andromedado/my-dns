<?php

class ModelRecord extends Model
{
	protected $rid;
	protected $zone;
	protected $name = '@';
	protected $ttl;
	protected $type;
	protected $adi;
	protected $value = '127.0.0.1';
	
	protected $dbFields = array(
		'rid',
		'zone',
		'name',
		'ttl',
		'type',
		'adi',
		'value',
	);
	protected $readOnly = array(
	);
	protected $requiredFields = array(
		'name' => 'Name is required',
		'value' => 'Value is required',
	);
	protected $whatIAm = 'DNS Zone Record';
	protected $table = 'records';
	protected $idCol = 'rid';
	protected static $WhatIAm = 'DNS Zone Record';
	protected static $Table = 'records';
	protected static $IdCol = 'rid';
	protected static $AllData = array();
	protected static $Types = array(
		'A', 'CNAME', 'MX', 'NS',
	);
	
	public function load() {
		parent::load();
	}
	
	public function getZone () {
		return Zone::findOwner($this);
	}
	
	protected function appendAdditionalData(array &$data) {
		$data['editUrl'] = FilterRoutes::buildUrl(array('Record', 'update', $this->id));
		$data['deleteUrl'] = FilterRoutes::buildUrl(array('Record', 'delete', $this->id));
	}
	
	protected function preFilterVars (array &$vars, $creating) {
		if (isset($vars['ttl']) && $vars['ttl'] === '') {
			$vars['ttl'] = null;
		}
	}
	
	public static function getTypes() {
		return self::$Types;
	}
	
	public static function getAllZones() {
		$sql = "SELECT DISTINCT(`zone`) FROM `" . self::$Table . "` ORDER BY `zone` ASC";
		return UtilsPDO::fetchIdsIntoInstances($sql, array(), 'Zone');
	}
	
}

/*
CREATE TABLE `records` (
  `rid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `zid` int(11) NOT NULL,
  `name` varchar(120) NOT NULL DEFAULT '',
  `ttl` int(11) NOT NULL,
  `type` varchar(6) NOT NULL DEFAULT '',
  `adi` varchar(30) NOT NULL DEFAULT '',
  `value` varchar(120) NOT NULL DEFAULT '',
  PRIMARY KEY (`rid`),
  KEY `zid` (`zid`),
  KEY `name` (`name`),
  KEY `zid_2` (`zid`,`name`),
  KEY `type` (`type`),
  KEY `value` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 */
