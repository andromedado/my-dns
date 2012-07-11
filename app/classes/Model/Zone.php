<?php

class ModelZone extends Model
{
	protected $zid;
	protected $zone;
	protected $serial = 0;
	
	protected $dbFields = array(
		'zid',
		'zone',
		'serial',
	);
	protected $readOnly = array(
	);
	protected $requiredFields = array(
		'zone' => 'Zone is a required field',
	);
	protected $whatIAm = 'DNS Zone';
	protected $table = 'zones';
	protected $idCol = 'zid';
	protected static $WhatIAm = 'DNS Zone';
	protected static $Table = 'zones';
	protected static $IdCol = 'zid';
	protected static $AllData = array();
	
	public function load() {
		parent::load();
	}
	
	protected function appendAdditionalData(array &$data) {
		$data['href'] = FilterRoutes::buildUrl(array('Zone', 'review', $this->id));
	}
	
	protected function preFilterVars (array &$vars, $creating) {
		$vars['serial'] = $this->serial + 1;
	}
	
}

/*
CREATE TABLE `zones` (
  `zid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `zone` varchar(120) NOT NULL DEFAULT '',
  `serial` int(11) NOT NULL,
  PRIMARY KEY (`zid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
 */
