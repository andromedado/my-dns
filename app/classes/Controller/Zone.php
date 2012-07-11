<?php

class ControllerZone extends ControllerApp
{
	
	public function review($id = NULL) {
		$MZ = new ModelZone($id);
		if (!$MZ->isValid()) return $this->notFound();
		$this->set('zone', $MZ->getData());
	}
	
	public function index() {
		$this->set('zones', UtilsArray::callOnAll(ModelZone::findAll(), 'getData'));
		$this->set('newZoneHref', FilterRoutes::buildUrl(array('Zone', 'create')));
	}
	
	public function create() {
		if ($this->request->isPost()) {
			$MZ = new ModelZone;
			try {
				$MZ->safeCreateWithVars($this->request->post());
				$this->response->addMessage($MZ->whatAmI() . ' Created');
				$this->response->redirectTo(array('Zone', 'review', $MZ->id));
				return;
			} catch (ExceptionValidation $e) {
				$this->response->addMessage($e->getMessage(), true);
			}
		}
		$this->set('action', FilterRoutes::buildUrl(array('Zone', __FUNCTION__)));
	}
	
}
