<?php

class ControllerRecord extends ControllerApp
{
	
	public function importCsv() {
		$bad = true;
		$msg = 'Invalid Post';
		if ($this->request->isPost()) {
			$F = new UploadedFile('csv');
			if (!$F->valid) {
				$msg = $F->errorMessage;
			} else {
				$MR = new ModelRecord;
				try {
					$MR->importFromCsv($F->tmp_name, $this->request->post('headers', false));
					$msg = 'Import Successful';
					$bad = false;
				} catch (ExceptionBase $e) {
					$msg = $e->getMessage();
				}
			}
		}
		$this->response->addMessage($msg, $bad);
		$this->response->redirectTo(array('Zone'));
	}
	
	public function delete($id = NULL) {
		$MR = new ModelRecord($id);
		$this->response->redirectTo(array('Zone', 'review', Zone::findOwner($MR)->id));
		if ($MR->isValid()) {
			$MR->delete();
			$this->response->addMessage('Record Deleted');
		} else {
			$this->response->addMessage('Invalid Record', true);
		}
		return;
	}
	
	public function create($id = NULL) {
		$Z = new Zone($id);
		if ($this->request->isAjax()) {
			return array('html' => $this->renderForm($Z));
		} elseif ($this->request->isPost()) {
			$MR = new ModelRecord;
			try {
				$MR->safeCreateWithVars($this->request->post());
				$this->response->addMessage('Record Created');
			} catch (ExceptionValidation $e) {
				$this->response->addMessage($e->getMessage(), true);
			}
			$this->response->redirectTo(array('Zone'));
			return;
		}
		return $this->notFound();
	}
	
	public function update($id = NULL) {
		$MR = new ModelRecord($id);
		if ($MR->isValid()) {
			if ($this->request->isAjax()) {
				return array('html' => $this->renderForm(NULL, $MR));
			} elseif ($this->request->isPost()) {
				try {
					$MR->safeUpdateVars($this->request->post());
					$this->response->addMessage('Record Updated');
				} catch (ExceptionValidation $e) {
					$this->response->addMessage($e->getMessage(), true);
				}
				$this->response->redirectTo(array('Zone', 'review', Zone::findOwner($MR)->id));
				return;
			}
		}
		return $this->notFound();
	}
	
	protected function renderForm(Zone $MZ = NULL, ModelRecord $MR = NULL) {
		if (is_null($MR)) $MR = new ModelRecord;
		if (is_null($MZ)) $MZ = Zone::findOwner($MR);
		$v = $MR->isValid() ? 'update' : 'create';
		$AF = new AppForm(ucfirst($v) . ' DNS Record', array('Record', $v, $MR->id));
		$AF->addField('Zone', Html::n('input', 't:text;n:zone;c:not_blank', $MZ->zone));
		$AF->addField('Name', Html::n('input', 't:text;n:name;c:not_blank', $MR->name));
		$AF->addField('TTL', Html::n('input', 't:text;n:ttl', $MR->ttl));
		$TS = ModelRecord::getTypes();
		$AF->addField('Type', UtilsHtm::select(array_combine($TS, $TS), 'type', $MR->type));
		$AF->addField('Addtional', Html::n('input', 't:text;n:adi', $MR->adi));
		$AF->addField('Value', Html::n('input', 't:text;n:value;c:not_blank', $MR->value));
		$AF->addHiddenField($MR->idCol, $MR->id);
		return $AF;
	}
	
}
