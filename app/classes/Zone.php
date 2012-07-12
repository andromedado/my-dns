<?php

/**
 * Pseudo Model
 */
class Zone extends Model
{
	protected $valid = true;
	protected $idCol = 'zone';
	public $zone;
	protected $Records = NULL;
	
	public function __construct($zone = '') {
		$this->id = $this->zone = $zone;
		$this->valid = $this->hasRecords();
	}
	
	protected function deleteMyself() {
		UtilsArray::callOnAll($this->getRecords(), 'delete');
	}
	
	public function getData() {
		$data = array('id' => $this->id, 'zone' => $this->zone);
		$data['href'] = FilterRoutes::buildUrl(array('Zone', 'review', $this->id));
		$data['records'] = UtilsArray::callOnAll(ModelRecord::findAllBelongingTo($this), 'getData');
		$data['deleteHref'] = FilterRoutes::buildUrl(array('Zone', 'delete', $this->id));
		return $data;
	}
	
	public function hasRecords() {
		$this->getRecords();
		return !empty($this->Records);
	}
	
	public function getRecords($force = false) {
		if (is_null($this->Records) || $force) {
			$this->Records = ModelRecord::findAllBelongingTo($this);
		}
		return $this->Records;
	}
	
	public static function findOwner(ModelRecord $MR) {
		$c = get_called_class();
		return new $c($MR->zone);
	}
	
	public static function findAll() {
		return ModelRecord::getAllZones();
	}
	
}
