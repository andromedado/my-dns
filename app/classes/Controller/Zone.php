<?php

class ControllerZone extends ControllerApp
{
	
	public static function doCacheOut() {
		$Zs = Zone::findAll();
		$namedConfFile = NAMED_CONF_DIR . 'named.conf';
		$existingZones = glob(ZONES_DIR . '*.*');
		if (!empty($existingZones)) {
			foreach ($existingZones as $zone) {
				unlink($zone);
			}
		}
		$namedHeadFile = $namedConfFile . '.head';
		$namedFootFile = $namedConfFile . '.foot';
		$nCHandle = fopen($namedConfFile, 'w');
		if (!$nCHandle) throw new ExceptionClear('Cant open ' . $namedConfFile);
		$namedConf = file_get_contents($namedHeadFile);
		$t = time();
		foreach ($Zs as $Zone) {
			$namedConf .= <<<EOT
zone "{$Zone->zone}" IN {
	type master;
	file "{$Zone->zone}.zone";
	allow-update { none; };
};


EOT;
			$zoneFile = ZONES_DIR . $Zone->zone . '.zone';
			$zoneHandle = fopen($zoneFile, 'w');
			if (!$zoneHandle) throw new ExceptionClear('Unable to open for writing: ' . $zoneFile);
			$zoneContents = <<<EOT
\$TTL    86400
\$ORIGIN {$Zone->zone}.
@       IN      SOA     {$Zone->zone}.      shad.downey.gmail.com (
                                        {$t}              ; serial
                                        3H              ; refresh
                                        15M             ; retry
                                        1W              ; expiry
                                        1D )            ; minimum
	1D	IN	NS	@

EOT;
			$Rs = $Zone->getRecords();
			foreach ($Rs as $Record) {
				$ttl = $Record->ttl;
				if (is_null($ttl) || $ttl ===  'NULL') $ttl = '';
				$zoneContents .= <<<EOT
{$Record->name}	{$ttl}	IN	{$Record->type}	{$Record->adi}	{$Record->value}	; rid-{$Record->id}

EOT;
			}
			$bytes = fwrite($zoneHandle, $zoneContents);
			fclose($zoneHandle);
			if ($bytes === false || $bytes < 1) throw new ExceptionClear('Couldnt write to ' . $zoneFile);
		}
		$namedConf .= file_get_contents($namedFootFile);
		$bytes = fwrite($nCHandle, $namedConf);
		fclose($nCHandle);
		if ($bytes === false || $bytes < 1) throw new ExceptionClear('Write failed on ' . $namedConfFile);
	}
	
	public function cacheOut() {
		$message = 'Zones Cached Out!';
		$bad = false;
		try {
			self::doCacheOut();
		} catch (ExceptionClear $e) {
			$bad = true;
			$message = $e->getMessage();
		}
		$this->response->addMessage($message, $bad);
		$this->response->redirectTo(array('Zone'));
	}
	
	public function review($id = NULL) {
		$MZ = new Zone($id);
		if (!$MZ->isValid()) return $this->notFound();
		$this->set('newRecordHref', FilterRoutes::buildUrl(array('Record', 'create', $MZ->id)));
		$this->set('zone', $MZ->getData());
	}
	
	public function index() {
		$this->set('zones', UtilsArray::callOnAll(Zone::findAll(), 'getData'));
		$this->set('newRecordHref', FilterRoutes::buildUrl(array('Record', 'create')));
//		$this->set('cacheOutAction', FilterRoutes::buildUrl(array('Zone', 'cacheOut')));
		$this->set('uploadAction', FilterRoutes::buildUrl(array('Record', 'importCsv')));
	}
	
	public function delete($id = NULL) {
		$MZ = new Zone($id);
		$this->response->redirectTo(array('Zone'));
		if ($MZ->isValid()) {
			$MZ->delete();
			$this->response->addMessage('Zone Deleted');
		} else {
			$this->response->addMessage('Invalid Zone', true);
		}
		return;
	}
	
	/*/
	public function create() {
		if ($this->request->isPost()) {
			$MZ = new Zone;
			try {
				$MZ->safeCreateWithVars($this->request->post());
				$this->response->addMessage($MZ->whatAmI() . ' Created');
				$this->response->redirectTo(array('Zone', 'review', $MZ->id));
				return;
			} catch (ExceptionValidation $e) {
				$this->response->addMessage($e->getMessage(), true);
			}
		} elseif ($this->request->isAjax()) {
			return array('html' => new AppForm('Create Zone', array('Zone', __FUNCTION__), array(
				'zone' => 'Zone',
			)));
		}
		$this->set('action', FilterRoutes::buildUrl(array('Zone', __FUNCTION__)));
	}
	/*/

}
